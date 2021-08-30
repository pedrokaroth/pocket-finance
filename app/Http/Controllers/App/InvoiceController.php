<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice as InvoiceRequest;
use App\Models\App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param InvoiceRequest $request
     * @return void
     */
    public function store(InvoiceRequest $request)
    {
        //Invoice::create($request->validated());
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
