<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice as InvoiceRequest;
use App\Models\App\Category;
use App\Models\App\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceRequest $request
     * @return JsonResponse
     */
    public function store(InvoiceRequest $request): JsonResponse
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
