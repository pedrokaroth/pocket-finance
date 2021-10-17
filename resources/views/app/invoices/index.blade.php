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
                    <span>Nova Receita</span>
                </button>
            @endif
        </div>
        @endif
        <article class="box">
            @if($invoices->count())
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>{{ $type !== 'fixed' ? 'Vencimento' : 'Repete'  }}</th>
                        <th>Categoria</th>
                        <th>{{ $type !== 'fixed' ? 'Parcela' : 'Repetição' }}</th>
                        <th>Valor</th>
                        <th>Acões</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->description }}</td>
                            <td>{{ $type == 'fixed' ? $invoice->repeat_date : "Dia " . date('d/m', strtotime($invoice->due_at)) }}</td>
                            <td>{{ $invoice->category }}</td>
                            @if($invoice->enrollments > 0)
                                <td>
                                    @if($invoice->enrollment_of)
                                        <a class="nav-link" href="{{ route('app.invoices.edit', ['invoice' => $invoice->enrollment_of]) }}">{{ $invoice->installments }}</a>
                                    @else
                                        {{ $invoice->installments }}
                                    @endif
                                </td>
                            @else
                                <td>
                                    @switch($invoice->repeat_when)
                                        @case('single')
                                            Única
                                        @break
                                        @case('fixed')
                                            {{ ucfirst(__('messages.' . $invoice->repeat_type)) }}
                                        @break
                                    @endswitch
                                </td>
                            @endif
                            <td>{{ $invoice->totalValue ?? $invoice->value }}</td>
                            <td>
                                <div class="btn-group">
                                    <form action="{{ route('app.invoices.destroy', ['invoice' => $invoice]) }}" method="post">
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger  btn-sm" style="border-bottom-right-radius: 0;border-top-right-radius: 0" title="Remover Fatura"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    <a href="{{ route('app.invoices.edit', ['invoice' => $invoice]) }}" class="btn btn-info  btn-sm" title="Acessar Fatura"><i class="far fa-eye"></i></a>

                                    @if(!$invoice->cloned && !$invoice->invoice_of && !$invoice->enrollments)
                                        <form action="{{ route('app.invoices.clone', ['invoice' => $invoice]) }}" method="post">
                                            @method('POST')

                                            <button type="submit" class="btn btn-warning  btn-sm" title="Criar uma {{ $invoice->type == 'expense' ? 'receita' : 'despesa' }} clone" style="color: #FFFFFF;border-radius: 0"><i class="far fa-clone"></i></button>
                                        </form>
                                    @endif

                                    @if($invoice->status == 'paid')
                                        <form action="{{ route('app.invoices.status', ['invoice' => $invoice]) }}" method="post">
                                            @method('PUT')
                                            <input type="hidden" name="status" value="unpaid">
                                            @if($invoice->repeat_when == 'single')
                                                <button type="submit" class="btn btn-success  btn-sm btn-form" title="Marcar como não Paga"><i class="far fa-grin"></i></button>
                                            @elseif($invoice->repeat_when != 'enrollment')
                                                <button type="submit" class="btn btn-success  btn-sm btn-form" title="Marcar como não Ativa"><i class="fas fa-check"></i></button>
                                            @endif
                                        </form>
                                    @else
                                        <form action="{{ route('app.invoices.status', ['invoice' => $invoice]) }}">
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            @if($invoice->repeat_when == 'single')
                                                <button type="submit" class="btn btn-warning  btn-sm btn-form" title="Marcar como Paga"><i class="far fa-frown"></i></button>
                                            @elseif($invoice->repeat_when != 'enrollment')
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
            @elseif($type != 'fixed')
                <div class="alert alert-primary mt-3" role="alert">
                    Ainda não existem faturas cadastradas, <a href="#" class="alert-link open-modal" data-modal="invoice-{{ $type }}">clique aqui para adicionar</a>.
                </div>
            @else
                <div class="alert alert-primary mt-3" role="alert">
                    Primeiro realize o cadastro de uma fatura fixa através da tela principal ou da tela de faturas.
                </div>
            @endif
        </article>
    </section>
@endsection

