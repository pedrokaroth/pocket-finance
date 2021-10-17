<?php


namespace App\Services;


use App\Models\App\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    /**
     * @param array $invoice
     * @return bool|Invoice
     */
    public function create(array $invoice)
    {
        if($invoice['repeat_when'] == 'enrollment') {
            $invoice['status'] = 'unpaid';
        }

        $invoice = Invoice::create($invoice);

        if (!$invoice) {
            return false;
        }

        if ($invoice->repeat_when == 'fixed') {
            $this->setNonSingleAsUnvalidated();
        }

        if ($invoice->repeat_when == 'enrollment') {
            $this->createEnrollmentsInvoices($invoice);
        }

        return $invoice;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public function createCloneInvoice(Invoice $invoice): bool
    {
        $invoice->setAsCloned();

        $invoice->invoice_of = $invoice->id;
        $invoice->type = $invoice->type == 'expense' ? 'income' : 'expense';
        $invoice->status = 'unpaid';
        $invoice->cloned = null;

        return $this->create($invoice->toArray());
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    private function getTotalEnrollments(Invoice $invoice) {
        $invoice = Invoice::findById($invoice->enrollment_of);

        return $invoice->enrollments;
    }


    /**
     * @param $status
     * @param $category
     * @param $date
     * @return Collection
     */
    public function getExpensesInvoices($status, $category, $date): Collection
    {
        $invoices = walletactive()->expenses($status, $category, $date)->sortByDesc('due_at');

        foreach ($invoices as $invoice) {
            if ($invoice->enrollments > 0) {
                $invoice->installments = $invoice->enrollments . ' de ' . $this->getTotalEnrollments($invoice);
            }
        }

        return $invoices;
    }

    /**
     * @param $status
     * @param $category
     * @param $date
     * @return Collection
     */
    public function getIncomesInvoices($status, $category, $date): Collection
    {
        $invoices = walletactive()->incomes($status, $category, $date)->sortByDesc('due_at');

        foreach ($invoices as $invoice) {
            if($invoice->enrollments > 0) {
                $invoice->installments = $this->getInstallmentsKey($invoice, $invoice->enrollments);
            }
        }

        return $invoices;

    }

    /**
     * @return Collection
     */
    public function getInstallmentsInvoices(): Collection
    {
        $invoices = walletactive()->installments()->where('status', '!=', 'paid');

        foreach ($invoices as $invoice) {
            $invoice->installments = $this->getInstallmentsKey($invoice);
            $invoice->value = str_to_number($invoice->value) * $invoice->enrollments;
        }

        return $invoices;
    }

    /**
     * @param Invoice $invoice
     * @return bool
     */
    public function createEnrollmentsInvoices (Invoice $invoice): bool
    {
        if ($invoice->enrollments <= 0) {
            return false;
        }

        $due_at = new Carbon($invoice->due_at);
        $enrollments = $invoice->enrollments;

        $invoice->enrollment_of = $invoice->id;
        $invoice->repeat_when = 'single';
        $invoice->repeat_type = null;

        for ($x = 1; $x <= $enrollments; $x++) {
            $invoice->enrollments = $x;
            $invoice->status = $due_at > Carbon::now() ? 'unpaid' : 'paid';

            $this->create($invoice->toArray());

            $invoice->due_at = $due_at->addMonth();
        }

        return true;
    }

    /**
     * @param Invoice $invoice
     * @return bool|null
     */
    public function destory(Invoice $invoice): ?bool
    {
        Invoice::where(['enrollment_of' => $invoice->id, 'status' => 'unpaid'])->delete();

        return $invoice->delete();
    }

    public function getDashboardChart(): \stdClass
    {
        $invoices = Invoice()->dashboardChartData();

        if($invoices->count()) {
            foreach ($invoices as $invoice) {
                $chartCategories[] = $invoice->due_month . '/' . $invoice->due_year;
                $chartExpense[] = $invoice->expense ?? 0;
                $chartIncome[] = $invoice->income ?? 0;
            }
        } else {
            for ($month = -4; $month <= 0; $month++) {
                $chartDate[] = date("m/Y", strtotime("{$month}month"));
            }
        }


        $chartData = new \stdClass();
        $chartData->categories = $chartCategories ?? $chartDate;
        $chartData->expense = $chartExpense ?? [0,0,0,0,0];
        $chartData->income = $chartIncome ?? [0,0,0,0,0];

        return $chartData;
    }

    /**
     *
     */
    public function setNonSingleAsUnvalidated()
    {
        session()->put('nonSingleInvoicesValidated', false);
    }

    /**
     *
     */
    public function setNonSingleAsValidated()
    {
        session()->put('nonSingleInvoicesValidated', true);
    }

    /**
     * @param Invoice $invoice
     * @param string $status
     * @return bool
     */
    public function setInvoiceStatus(Invoice $invoice, string $status): bool
    {
        if($invoice->enrollments > 0 && $status == 'paid') {
            $paids = Invoice::where([
                'status' => 'unpaid',
                'enrollment_of' => $invoice->enrollment_of,
            ])->where('id', '!=', $invoice->id)->count();

            if(!$paids) {
                $mainInvoice = Invoice::findById($invoice->enrollment_of);
                $mainInvoice->update([
                    'status' => $status
                ]);
            }
        }

        return $invoice->update([
            'status' => $status
        ]);
    }

    /**
     * @param Invoice $invoice
     * @param null $enrollment
     * @return string
     */
    private function getInstallmentsKey(Invoice $invoice, $enrollment = null): string
    {
        if(!$enrollment) {
            $paids = Invoice::where([
                'status' => 'paid',
                'enrollment_of' => $invoice->id
            ])->count();

            return $paids . ' de ' . $invoice->enrollments;
        }

        return $invoice->enrollments . ' de ' . $this->getTotalEnrollments($invoice);
    }
}
