@extends('app.master.master')

@section('content')
    <section class="app-invoice-edit box">
        <form action="{{ route('app.invoices.update', ['invoice' => $invoice]) }}" method="post">
            @method('PUT')

            <div class="label-group">
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Descrição
                    <input type="text" value="{{ $invoice->description }}" name="description">
                </label>
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Status
                    <select class="browser-default custom-select mt-2" name="status">
                        <option value="unpaid" {{ $invoice->status == 'unpaid' ? 'selected' : '' }}>{{ !empty($invoice->repeat_when == 'fixed') ? 'Inativa' : 'Pendente' }}</option>
                        <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>{{ !empty($invoice->repeat_when == 'fixed') ? 'Ativa' : 'Pago' }}</option>
                    </select>
                </label>
            </div>
            <div class="label-group">
                <label class="display-flex">
                    <i class="fas fa-money-bill"></i> Valor
                    <input type="text" value="{{ str_price($invoice->value) }}" class="mask-money" name="value">
                </label>
                <label class="display-flex">
                    <i class="fas fa-calendar-day"></i> Data
                    <input type="date" name="due_at" value="{{ $invoice->due_at }}">
                </label>
            </div>
            <div class="label-group">
                <label class="display-flex">
                    <i class="fas fa-wallet"></i> Carteira
                    <select class="browser-default custom-select mt-2" name="wallet_id">
                        @foreach(wallets() as $wallet)
                            <option value="{{ $wallet->id }}" {{ $invoice->wallet_id == $wallet->id ? 'selected' : '' }}>{{ $wallet->wallet }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="display-flex">
                    <i class="fas fa-list"></i> Categoria
                    <select class="browser-default custom-select mt-2" name="category_id">
                        @foreach(categories('income') as $category)
                            <option value="{{ $category->id }}" {{ $invoice->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="label-group">
                <label class="display-full">
                    <i class="fas fa-envelope-open-text mb-1"></i> Obervações
                    <textarea rows="5" name="comments">{{ $invoice->comments }}</textarea>
                </label>
            </div>

            <div class="btn-edit">
                <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="btn btn-info">Voltar</a>
                <button class="btn btn-success">Salvar</button>
            </div>
        </form>
    </section>
@endsection
