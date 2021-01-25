@extends('layout', ['titulo' => 'Vendas'])

@section('cabecalho')
    Vendas
@endsection

@section('conteudo')    
    <a href="/venda/list/1" id="btn-visualizar-vendas" class="btn btn-primary btn-block mt-3">Visualizar Outras Vendas</a>
    <a href="/venda/pendente/list/1" id="btn-vendas-pendentes" class="btn btn-danger btn-block mt-3"></a>
    <div>
        <div class="d-flex justify-content-between mt-3">
            <button id="novo-produto" class="btn btn-primary btn-block" data-toggle="modal" data-target="#generic-modal">Inserir Novo Produto</button>
        </div>
        <div id="lista-venda-produtos" class="mt-3">
            <p id="alerta-venda-pendente" style="text-align: center; color:red;"></p>
            <table id="lista-produtos" class="table mt-3">
            <thead>
                <tr>
                <th scope="col">Produto</th>
                <th style="text-align: center" scope="col">Quantidade</th>
                <th style="text-align: center" scope="col">Preço</th>
                <th style="text-align: center" scope="col">Total</th>
                <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody id="lista-produtos-body">

            </tbody>
            </table>
            <p id="nenhum-produto-inserido" style="text-align: center;"></p>
        </div>
        <div id="dados-row" class="row">
            <div class="col col-2 ">
                <div class="form-group mt-3">
                    <label for="novo-produto">Pagamento:</label>
                    <select class="form-control mt-1" id="tipo-pagamento">
                        <option disabled>Selecione o Tipo de Pagamento</option>
                        @foreach($tipo_pagamento as $pagamento)
                            <option value="{{$pagamento->id}}">{{$pagamento->descricao}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col col-2 ">
                <div class="form-group mt-3">
                    <label for="conceder-desconto">Desconto:</label>
                    <input type="text" id="conceder-desconto" class="form-control mt-1 money" placeholder="Informe Valor" value="0,00">
                </div>
            </div>
            <div class="col col-6">
                <div class="form-group mt-3">
                    <label for="observacao">Observação:</label>
                    <input id="observacao" type="text" placeholder="Observação" class="form-control mt-1">
                </div>
            </div>
            <div class="col col-2 ">
                <div class="form-group mt-3">
                    <label for="valor-pago"><strong>Valor Pago:</strong></label>
                    <input type="text" id="valor-pago" class="form-control mt-1 money" placeholder="Informe Valor" value="0,00">
                </div>
            </div>
        </div>
        <div id="container-valor-total" class="d-flex justify-content-between mt-3">
            <h1>Valor Total:</h1>
            <h1 id="venda-valor-total" class="money">0,00</h1>
        </div>
        <div id="container-troco" class="d-flex justify-content-between mt-3">
            <h1>Troco:</h1>
            <h1 id="venda-troco" class="money">0,00</h1>
        </div>
        <button id="finalizar-venda" class="btn btn-primary btn-block mt-3">Finalizar Venda</button>
        
    </div>

    <!-- Conteúdo da modal -->
    @extends('modal.index', ['titulo' => 'Inserir Produtos'])
        @section('modal-body')
        <div class="form-group container">
            <!-- Dados Gerais do Produto -->
            <form>
                <section id="dados-produto">
                    <div id="dados-row" class="row">
                        <div class="col col-2">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="produto-id" name="id" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <label for="codigo-barra">Código Barra:</label>
                                <input type="text" class="form-control bar-code" id="produto-codigo-barra" name="codigo-barra" placeholder="Código de Barra" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="categoria">Categoria:</label>
                                <input type="text" class="form-control" id="produto-categoria" name="categoria" placeholder="Categoria" value="" disabled>
                            </div>
                        </div>
                        <div class="col col-8">
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <input type="text" class="form-control" id="produto-descricao" name="descricao" placeholder="Descrição" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="quantidade-estoque">UN:</label>
                                <input type="text" class="form-control" id="produto-unidade_medida" name="produto-unidade_medidas" value="" disabled>
                            </div>
                        </div>
                        <div class="col col-2">
                            <div class="form-group">
                                <label for="quantidade-estoque">Qtd. Atual:</label>
                                <input type="text" class="form-control" id="produto-quantidade-atual-estoque" name="quantidade-atual-estoque" value="" disabled>
                            </div>
                        </div>
                        <div class="col col-2">
                            <div class="form-group">
                                <label for="quantidade-estoque">Qtd. vender:</label>
                                <input type="number" class="form-control" id="produto-quantidade-vender" name="quantidade-vender" value="">
                            </div>
                        </div>
                        <div class="col col-4">
                            <div class="form-group">
                                <label for="preco-venda">Preço:</label>
                                <input type="text" class="form-control money" id="produto-preco-venda" name="produto-preco-venda" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col col-4">
                            <div class="form-group">
                                <label for="preco-venda">Total:</label>
                                <input type="text" class="form-control money" id="produto-total-venda" name="produto-total-venda" value="" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        @endsection

        @section('modal-footer')
        <div class="modal-footer">
            <div id="vendas-actions">
                <button id="btn-inserir-venda" class="btn btn-primary">Inserir</button>
            </div>
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/autocomplete.js') }}" defer></script>
    <script src="{{ asset('js/custom/dom/venda/index.js') }}" type="module"></script>
@endsection