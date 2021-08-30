<section class="app-modal">
    <div class="modal fade" id="invoice-expense" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <section class="expense">
                    <p><i class="fas fa-funnel-dollar"></i>Nova Despesa</p>

                    <form action="{{ route('app.invoices.store') }}" method="post">
                        @method('POST')

                        <input type="hidden" value="expense" name="invoice">

                        <div class="label-group">
                            <label class="display-full">
                                <i class="fas fa-envelope-open-text"></i> Descrição
                                <input type="text" placeholder="Ex: Faculdade" name="description">
                            </label>
                        </div>
                        <div class="label-group">
                            <label class="display-flex">
                                <i class="fas fa-money-bill"></i> Valor
                                <input type="text" placeholder="0,00" class="mask-money" name="value">
                            </label>
                            <label class="display-flex">
                                <i class="fas fa-calendar-day"></i> Data
                                <input type="date" name="due_at">
                            </label>
                        </div>
                        <div class="label-group">
                            <label class="display-flex">
                                <i class="fas fa-wallet"></i> Carteira
                                <select class="browser-default custom-select mt-2" name="wallet_id">
                                    @foreach(wallets() as $wallet)
                                        <option value="{{ $wallet->id }}">{{ $wallet->wallet }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="display-flex">
                                <i class="fas fa-list"></i> Categoria
                                <select class="browser-default custom-select mt-2" name="category">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </label>
                        </div>

                        <div class="label-group">
                            <label class="display-full">
                                <i class="fas fa-envelope-open-text mb-1"></i> Obervações
                                <textarea rows="5" name="comments"></textarea>
                            </label>
                        </div>
                        <div class="label-group">
                            <div class="app-checkbox-label  mb-2 ml-2">
                                <i class="fas fa-undo"></i> Repetição
                            </div>
                            <div class="app-checkbox red-checkbox">
                                <label>
                                    <input type="radio" name="repeat_when" value="single" checked>
                                    <span>Única</span>
                                </label>
                                <label>
                                    <input type="radio" name="repeat_when" value="fixed">
                                    <span>Fixa</span>
                                </label>
                                <label>
                                    <input type="radio" name="repeat_when" value="enrollment">
                                    <span>Parcelada</span>
                                </label>
                            </div>
                        </div>
                        <div class="label-group">
                            <div class="app-checkbox-label mb-2 ml-2">
                                <i class="far fa-credit-card"></i> Status
                            </div>
                            <div class="app-checkbox red-checkbox">
                                <label>
                                    <input type="checkbox" name="status">
                                    <span>Pendente</span>
                                </label>
                            </div>
                        </div>

                        <button>
                            Registrar Despesa
                        </button>
                    </form>
                </section>
            </div>
        </div>
    </div>
</section>
