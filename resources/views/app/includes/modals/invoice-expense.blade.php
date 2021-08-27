@extends('app.master.modal')

@section('modal-content')
    <section class="expense">
        <p><i class="fas fa-funnel-dollar"></i>Nova Despesa</p>

        <form action="">
            <div class="label-group">
                <label class="display-full">
                    <i class="fas fa-envelope-open-text"></i> Descrição
                    <input type="text" placeholder="Ex: Faculdade" class="">
                </label>
            </div>
            <div class="label-group">
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Carteira
                    <input type="text" placeholder="Ex: Faculdade" class="">
                </label>
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Categoria
                    <input type="text" placeholder="Ex: Faculdade" class="">
                </label>
            </div>
            <div class="label-group">
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Carteira
                    <select class="browser-default custom-select mt-2">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </label>
                <label class="display-flex">
                    <i class="fas fa-envelope-open-text"></i> Categoria
                    <select class="browser-default custom-select mt-2">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </label>
            </div>

            <div class="label-group">
                <label class="display-full">
                    <i class="fas fa-envelope-open-text mb-1"></i> Obervações
                    <textarea rows="5"></textarea>
                </label>
            </div>
            <div class="label-group">
                <div class="app-checkbox-label">
                    <i class="fas fa-undo mb-3 ml-3"></i> Repetição
                </div>
                <div class="app-checkbox red-checkbox">
                    <label>
                        <input type="radio" name="radio" checked>
                        <span>Única</span>
                    </label>
                    <label>
                        <input type="radio" name="radio">
                        <span>Fixa</span>
                    </label>
                    <label>
                        <input type="radio" name="radio">
                        <span>Parcelada</span>
                    </label>
                </div>
            </div>
            <div class="label-group">
                <div class="app-checkbox-label">
                    <i class="far fa-credit-card"></i> Status
                </div>
                <div class="app-checkbox red-checkbox">
                    <label>
                        <input type="checkbox" name="radio">
                        <span>Não Paga</span>
                    </label>
                </div>
            </div>

            <button class="btn-grad">
                Registrar Despesa
            </button>
        </form>
    </section>
@endsection
