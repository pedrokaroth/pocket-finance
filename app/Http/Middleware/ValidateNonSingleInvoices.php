<?php

namespace App\Http\Middleware;

use App\Models\App\Invoice;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

/**
 * Class ValidateNonSingleInvoices
 * @package App\Http\Middleware
 */
class ValidateNonSingleInvoices
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $invoices = Invoice::where([
            'user_id' => auth()->id(),
            'repeat_when' => 'fixed',
            'status' => 'paid'
        ])->get();

        foreach ($invoices as $invoice) {
            switch ($invoice->repeat_type) {
                case 'weekly':
                    $monthEnd = (new Carbon())->endOfMonth();
                    $invoiceStart = (new Carbon($invoice->due_at))->setMonth(now()->month);

                    while ($invoiceStart < $monthEnd) {
                        if(!$this->existInvoiceOnDate($invoice->id, $invoiceStart)) {
                            $this->createInvoiceOf($invoice, $invoiceStart->format('Y-m-d'));
                        }

                        $invoiceStart->addWeek();
                    }

                    break;

                case 'monthly':
                    $currentMonth = (new Carbon($invoice->due_at))->setMonth(now()->month);

                    if(!$this->existInvoiceOnDate($invoice->id, $currentMonth)) {
                        $this->createInvoiceOf($invoice, $currentMonth->format('Y-m-d'));
                    }

                    break;

                case 'annually':
                    $currentYear = (new Carbon($invoice->due_at))->setYear(now()->year);

                    if(!$this->existInvoiceOnDate($invoice->id, $currentYear)) {
                        $this->createInvoiceOf($invoice, $currentYear->format('Y-m-d'));
                    }
            }
        }

        return $next($request);
    }

    /**
     * @param int $invoice_id
     * @param string $date
     * @return int
     */
    private function existInvoiceOnDate(int $invoice_id, string $date): int
    {
        return Invoice::withTrashed()->where([
            'invoice_of' => $invoice_id,
            'due_at' => $date
        ])->count();
    }

    /**
     * @param $invoice
     * @param $due_at
     */
    private function createInvoiceOf($invoice, $due_at) {
        Invoice::create([
            'wallet_id' => $invoice->wallet_id,
            'category_id' => $invoice->category_id,
            'invoice_of' => $invoice->id,
            'description' => $invoice->description,
            'comments' => $invoice->comments,
            'value' => $invoice->value,
            'type' => $invoice->type,
            'due_at' => $due_at,
            'repeat_when' => 'single',
            'status' => 'unpaid'
        ]);
    }


}
