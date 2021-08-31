@extends('app.master.master')

@section('content')

    @include('app.includes.modals.invoice-income')

    @include('app.includes.modals.invoice-expense')

    <div class="app-home">
        <section class="left">

        </section>
        <section class="right">
            <article class="widget-launch">
                <button class="income btn btn-outline-success open-modal" data-modal="invoice-income">
                    <i class="fas fa-plus-circle"></i>
                    <span>RECEITA</span>
                </button>
                <button class="expense btn btn-outline-danger open-modal" data-modal="invoice-expense">
                    <i class="fas fa-minus-circle"></i>
                    <span>DESPESA</span>
                </button>
            </article>
        </section>
    </div>
@endsection
