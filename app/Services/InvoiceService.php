<?php


namespace App\Services;


use App\Models\App\Invoice;
use Carbon\Carbon;

/**
 * Class InvoiceService
 * @package App\Services
 */
class InvoiceService
{
    /**
     * @param array $invoice
     * @return false
     */
    public function create(array $invoice): bool
    {
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

            $this->create($invoice->toArray());

            $invoice->due_at = $due_at->addMonth();
        }

        return true;
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
}
