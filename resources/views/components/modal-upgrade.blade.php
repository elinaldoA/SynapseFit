<div class="modal fade" id="modalPagamento{{ $plano->id }}" tabindex="-1" role="dialog"
    aria-labelledby="modalLabel{{ $plano->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Escolha a forma de pagamento</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pix{{ $plano->id }}">PIX</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#credito{{ $plano->id }}">Crédito</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#debito{{ $plano->id }}">Débito</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#boleto{{ $plano->id }}">Boleto</a></li>
                </ul>

                <div class="tab-content">
                    {{-- PIX --}}
                    <div class="tab-pane fade show active text-center" id="pix{{ $plano->id }}">
                        <p>Escaneie o QR Code ou copie a chave PIX:</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PagamentoPlano{{ $plano->id }}"
                             alt="QR Code PIX" class="mb-3 border rounded">
                        <p><strong>Chave:</strong> planos@academiainteligente.com</p>
                        <form method="POST" action="{{ route('planos.assinar', $plano->id) }}">
                            @csrf
                            <input type="hidden" name="payment_method" value="pix">
                            <button type="submit" class="btn btn-success btn-block mt-2">Já paguei</button>
                        </form>
                    </div>

                    {{-- Crédito --}}
                    <div class="tab-pane fade" id="credito{{ $plano->id }}">
                        <form method="POST" action="{{ route('planos.assinar', $plano->id) }}">
                            @csrf
                            <input type="hidden" name="payment_method" value="credito">
                            <div class="form-group">
                                <label>Nome no cartão</label>
                                <input type="text" name="nome_cartao" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Número do cartão</label>
                                <input type="text" name="numero_cartao" class="form-control" maxlength="16" required pattern="\d{16}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Validade</label>
                                    <input type="text" name="validade" class="form-control" placeholder="MM/AA" required pattern="\d{2}/\d{2}">
                                </div>
                                <div class="form-group col-6">
                                    <label>CVV</label>
                                    <input type="text" name="cvv" class="form-control" maxlength="3" required pattern="\d{3}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Pagar com crédito</button>
                        </form>
                    </div>

                    {{-- Débito --}}
                    <div class="tab-pane fade" id="debito{{ $plano->id }}">
                        <form method="POST" action="{{ route('planos.assinar', $plano->id) }}">
                            @csrf
                            <input type="hidden" name="payment_method" value="debito">
                            <div class="form-group">
                                <label>Nome no cartão</label>
                                <input type="text" name="nome_cartao" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Número do cartão</label>
                                <input type="text" name="numero_cartao" class="form-control" maxlength="16" required pattern="\d{16}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label>Validade</label>
                                    <input type="text" name="validade" class="form-control" placeholder="MM/AA" required pattern="\d{2}/\d{2}">
                                </div>
                                <div class="form-group col-6">
                                    <label>CVV</label>
                                    <input type="text" name="cvv" class="form-control" maxlength="3" required pattern="\d{3}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Pagar com débito</button>
                        </form>
                    </div>

                    {{-- Boleto --}}
                    <div class="tab-pane fade text-center" id="boleto{{ $plano->id }}">
                        <p>Clique no botão abaixo para gerar seu boleto.</p>
                        <form method="POST" action="{{ route('planos.assinar', $plano->id) }}">
                            @csrf
                            <input type="hidden" name="payment_method" value="boleto">
                            <button type="submit" class="btn btn-success btn-block">Gerar Boleto</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
