<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\CreateInvoiceRequest as InvoiceCreate;
use App\Http\Requests\Invoices\FilterInvoiceRequest as InvoiceFilter;
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
    public function incomes($status = 'all', $category = 'all', $date = 'all'): View
    {

        return view('app.invoices.index', [
            'invoices' => walletactive()->incomes($status, $category, $date)->sortByDesc('due_at'),
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
    public function expenses($status = 'all', $category = 'all', $date = 'all'): View
    {
        return view('app.invoices.index', [
            'invoices' => walletactive()->expenses($status, $category, $date)->sortByDesc('due_at'),
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
     * Store a newly created resource in storage.
     *
     * @param InvoiceCreate $request
     * @return JsonResponse
     */
    public function store(InvoiceCreate $request): JsonResponse
    {
        Invoice::create($request->validated());

        $this->message('success', 'fatura adicionada com sucesso!');

        return response()->json(['reload' => true]);
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
     * Update the specified resource in storage.
     *
     * @param InvoiceStatus $request
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function setStatus(InvoiceStatus $request, Invoice $invoice): JsonResponse
    {
        $invoice->update([
            'status' => $request->get('status')
        ]);

        $this->message('success', 'Status alterado com sucesso!');

        return response()->json([
            'reload' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return JsonResponse
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        $invoice->delete();

        $this->message('success', 'Fatura removida com sucesso');

        return response()->json([
            'reload' => true
        ]);
    }
}
