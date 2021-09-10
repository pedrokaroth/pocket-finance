<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\CreateInvoiceRequest as InvoiceCreate;
use App\Http\Requests\Invoices\FilterInvoiceRequest as InvoiceFilter;
use App\Models\App\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoicesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceCreate $request
     * @return JsonResponse
     */
    public function store(InvoiceCreate $request): JsonResponse
    {
        $invoice = new Invoice();
        $invoice->fill($request->validated());
        $invoice->user_id = user()->id;

        //When status is not on the request, it calculates with the current date and the due date
        if(!$invoice->status) {
            $invoice->status = (date($invoice->due_at) <= date('Y-m-d') ? 'paid' : 'unpaid');
        }

        $invoice->save();

        $this->message('success', 'fatura adicionada com sucesso!');

        return response()->json(['reload' => true]);
    }

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
            'redirect' => route("app.{$request->get('invoice')}s") . "/{$status}/{$category}/{$date}"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
