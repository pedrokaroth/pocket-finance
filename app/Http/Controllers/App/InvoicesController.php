<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\CreateInvoiceRequest as InvoiceCreate;
use App\Http\Requests\Invoices\FilterInvoiceRequest as InvoiceFilter;
use App\Http\Requests\Invoices\UpdateInvoiceRequest as InvoiceUpdate;
use App\Http\Requests\Invoices\UpdateStatusInvoiceRequest as InvoiceStatus;
use App\Models\App\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

/**
 * Class InvoicesController
 * @package App\Http\Controllers\App
 */
class InvoicesController extends Controller
{

    /**
     * @param mixed $status
     * @param mixed $category
     * @param mixed $date
     * @return View
     */
    public function incomes($status = 'all', $category = 'all', $date = null): View
    {
        if(!$date) {
            $date = date('m-Y');
        }

        return view('app.invoices.index', [
            'invoices' => InvoiceService()->getIncomesInvoices($status, $category, $date),
            'filter' => [
                'status' => $status ?? null,
                'category' => $category ?? null,
                'date' => !empty($date) && $date != 'all' ?
                    explode('-', $date)[0] . '/' . explode('-', $date)[1] : 'all'
            ],
            'type' => 'income'
        ]);
    }

    /**
     * @param mixed $status
     * @param mixed $category
     * @param mixed $date
     * @return View
     */
    public function expenses($status = 'all', $category = 'all', $date = null): View
    {
        if(!$date) {
            $date = date('m-Y');
        }

        return view('app.invoices.index', [
            'invoices' => InvoiceService()->getExpensesInvoices($status, $category, $date),
            'filter' => [
                'status' => $status ?? null,
                'category' => $category ?? null,
                'date' => !empty($date) && $date != 'all' ?
                    explode('-', $date)[0] . '/' . explode('-', $date)[1] : 'all'
            ],
            'type' => 'expense'
        ]);
    }

    /**
     * @return View
     */
    public function fixed(): View
    {
        return view('app.invoices.index', [
            'invoices' => walletactive()->fixed(),
            'type' => 'fixed'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Invoice $invoice
     * @return View
     */
    public function edit(Invoice $invoice): View
    {
        return view('app.invoices.edit', [
            'invoice' => $invoice
        ]);
    }

    /**
     *
     */
    public function installments()
    {
        return view('app.invoices.index', [
            'invoices' => InvoiceService()->getInstallmentsInvoices(),
            'type' => 'installments'
        ]);
    }

    /**
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function clone(Invoice $invoice): JsonResponse
    {
        if ($invoice->type === 'fixed') {
            return $this->jsonError('N??o ?? poss??vel clonar faturas fixas');
        }

        if(!InvoiceService()->createCloneInvoice($invoice)) {
            return $this->jsonError('Houve um problema ao cadastrar sua fatura, tente novamente!');
        }

        return $this->jsonReload('Fatura clonada com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceCreate $request
     * @return JsonResponse
     */
    public function store(InvoiceCreate $request): JsonResponse
    {
       if(!InvoiceService()->create($request->validated())){
           return $this->jsonError('Houve um problema ao cadastrar sua fatura, tente novamente');
       };

        return $this->jsonReload('Fatura adicionada com sucesso!');
    }

    /**
     * @param InvoiceFilter $request
     * @return JsonResponse
     */
    public function filter(InvoiceFilter $request): JsonResponse
    {
        $status = $request->get('status');
        $category = $request->get('category');

        if($request->get('date') == 'all' || count(explode('/', $request->get('date'))) != 2) {
            $date = 'all';
        } else {
            list($m, $y) = explode('/', $request->get('date'));
            $date = "{$m}-{$y}";
        }


        return response()->json([
            'redirect' => route("app.invoices.{$request->get('invoice')}s") . "/{$status}/{$category}/{$date}"
        ]);
    }

    /**
     * @param InvoiceUpdate $request
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function update(InvoiceUpdate $request, Invoice $invoice): JsonResponse
    {
        $invoice->update($request->validated());

        return $this->jsonSuccess('Fatura atualizada com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param InvoiceStatus $request
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function setStatus(InvoiceStatus $request, Invoice $invoice): JsonResponse
    {
        if(!InvoiceService()->setInvoiceStatus($invoice, $request->get('status'))) {
            return $this->jsonError('Houve um problema ao alterar o status da fatura');
        }

        return $this->jsonReload('Status alterado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        if(!InvoiceService()->destory($invoice)) {
            $this->jsonError('Houve um problema ao remover a fatura');
        }

        return $this->jsonReload('Fatura removida com sucesso');
    }
}
