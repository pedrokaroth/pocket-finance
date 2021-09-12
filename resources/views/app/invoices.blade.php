@extends('app.master.master')

@section('content')
    @include('app.includes.modals.invoice-income')
    @include('app.includes.modals.invoice-expense')

    <section class="app-invoice">
        @if(!empty($filter))
            <div class="filter box">
            <div class="inputs">
                <form action="{{ route('app.invoices.filter') }}" method="post">
                    @method('POST')

                    <select name="status" class="select2">
                        <option value="all" {{ $filter['status'] == 'all' ? 'selected' : ''}}>Todas</option>
                        <option value="paid" {{ $filter['status'] == 'paid' ? 'selected' : '' }}>Pagas</option>
                        <option value="unpaid" {{ $filter['status'] == 'unpaid' ? 'selected' : '' }}>Não Pagas</option>
                    </select>
                    <select name="category" class="select2" style="height: 100%">
                        <option value="all" {{ $filter['category'] == 'all' ? 'selected' : '' }}>Todas</option>
                        @foreach(categories($type) as $category)
                            <option value="{{ $category->id }}" {{ $filter['category'] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <select name="date" class="radius select2">
                        <option value="all" {{ $filter['date'] == 'all' }}>Todos</option>
                        @for($range = -10; $range <= 10; $range++)
                            {{ $date = date('m/Y', strtotime("{$range}month")) }}

                            <option value="{{ $date }}" {{ $filter['date'] == $date ? 'selected' : '' }}>{{ date('m/Y', strtotime("{$range}month")) }}</option>
                        @endfor
                    </select>

                    <input type="hidden" name="invoice" value="{{ $type }}">
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
        @endif
        <article class="box">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Vencimento</th>
                        <th>Categoria</th>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Acões</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->description }}</td>
                        <td>{{ "Dia " . date('d/m', strtotime($invoice->due_at)) }}</td>
                        <td>{{ $invoice->category }}</td>
                        @if($invoice->enrollments > 0)

                        @else
                            <td>
                                @switch($invoice->repeat_when)
                                    @case('single')
                                        Única
                                    @break
                                    @case('fixed')
                                        Fixa
                                    @break
                                @endswitch
                            </td>
                        @endif
                        <td>{{ str_price($invoice->value) }}</td>
                        <td>
                            <div class="btn-group">
                                <form action="{{ route('app.invoices.destroy', ['invoice' => $invoice]) }}" method="post">
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger  btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                                <button type="submit" class="btn btn-info  btn-sm"><i class="far fa-eye"></i></button>
                                @if($invoice->status == 'paid')
                                    <form action="{{ route('app.invoices.status', ['invoice' => $invoice]) }}" method="post">
                                        @method('PUT')
                                        <input type="hidden" name="status" value="unpaid">
                                        @if($invoice->repeat_when == 'single')
                                            <button type="submit" class="btn btn-success  btn-sm btn-form" title="Marcar como não Paga"><i class="far fa-grin"></i></button>
                                        @else
                                            <button type="submit" class="btn btn-success  btn-sm btn-form" title="Marcar como não Ativa"><i class="fas fa-check"></i></button>
                                        @endif
                                    </form>
                                @else
                                    <form action="{{ route('app.invoices.status', ['invoice' => $invoice]) }}">
                                        @method('PUT')
                                        <input type="hidden" name="status" value="paid">
                                        @if($invoice->repeat_when == 'single')
                                            <button type="submit" class="btn btn-warning  btn-sm btn-form" title="Marcar como Paga"><i class="far fa-frown"></i></button>
                                        @else
                                            <button type="submit" class="btn btn-warning  btn-sm btn-form" title="Marcar como Ativa"><i class="fas fa-check"></i></button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </article>
    </section>
@endsection
