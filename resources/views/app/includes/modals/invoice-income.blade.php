<section class="app-modal">
    <div class="modal fade" id="invoice-income" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <section class="income">
                    <p><i class="fas fa-donate"></i>Nova Receita</p>

                    <form action="">
                        <div class="label-group">
                            <label class="display-full">
                                <i class="fas fa-envelope-open-text"></i> Descrição
                                <input type="text" placeholder="Ex: Salário" class="">
                            </label>
                        </div>
                        <div class="label-group">
                            <label class="display-flex">
                                <i class="fas fa-money-bill"></i> Valor
                                <input type="text" placeholder="0,00">
                            </label>
                            <label class="display-flex">
                                <i class="fas fa-calendar-day"></i> Data
                                <input type="date">
                            </label>
                        </div>
                        <div class="label-group">
                            <label class="display-flex">
                                <i class="fas fa-wallet"></i> Carteira
                                <select class="browser-default custom-select mt-2">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </label>
                            <label class="display-flex">
                                <i class="fas fa-list"></i> Categoria
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
                            <div class="app-checkbox-label mb-2 ml-2">
                                <i class="fas fa-undo"></i> Repetição
                            </div>
                            <div class="app-checkbox green-checkbox">
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
                            <div class="app-checkbox-label mb-2 ml-2">
                                <i class="far fa-credit-card"></i> Status
                            </div>
                            <div class="app-checkbox green-checkbox">
                                <label>
                                    <input type="checkbox" name="radio">
                                    <span>Pendente</span>
                                </label>
                            </div>
                        </div>

                        <button>
                            Registrar Receita
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>
