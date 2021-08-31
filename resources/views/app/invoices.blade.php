@extends('app.master.master')

@section('content')
    @include('app.includes.modals.invoice-income')
    @include('app.includes.modals.invoice-expense')

    <section class="app-invoice">
        <div class="filter box">
            <div class="inputs">
                <form action="">
                    <select name="status" class="select2">
                        <option value="all">Todas</option>
                        <option value="paid">Pagas</option>
                        <option value="unpaid">Não Pagas</option>
                    </select>
                    <select name="category" class="select2" style="height: 100%">
                        <option value="all">Todas</option>
                        @foreach(categories($type) as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select name="date" class="radius select2">
                        <option value="all">Todos</option>
                        @for($range = -10; $range <= 10; $range++)
                            <option value="{{ date('m/Y', strtotime("{$range}month")) }}">{{ date('m/Y', strtotime("{$range}month")) }}</option>
                        @endfor
                    </select>
                    <button class="btn btn-filter btn-sm">
                        <i class="fas fa-filter"></i>
                    </button>
                </form>
            </div>

            @if($type == 'expense')
                <button class="income btn btn-outline-danger open-modal btn-sm" data-modal="invoice-expense">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                    <span>Nova Despesa</span>
                </button>
            @else
                <button class="income btn btn-outline-success open-modal btn-sm" data-modal="invoice-income">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                    <span>Nova Despesa</span>
                </button>
            @endif
        </div>

        <article class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Vencimento</th>
                        <th>Categoria</th>
                        <th>Parcela</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->description }}</td>
                        <td>{{ "Dia " . date('d', strtotime($invoice->due_at)) }}</td>
                        <td>{{ $invoice->category }}</td>
                        @if($invoice->enrollments > 0)

                        @else
                            <td>Única</td>
                        @endif
                        <td>{{ str_price($invoice->value) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </article>
    </section>
@endsection
