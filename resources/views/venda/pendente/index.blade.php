@extends('layout', ['titulo' => 'Vendas Pendentes'])

@section('cabecalho')
    Vendas Pendentes
@endsection

@section('conteudo')
    <div id="dados-row" class="row d-flex justify-content-between mt-3">
        <span></span>
        <form autocomplete="off">
            <div class="autocomplete" style="width:350px;">
                <input id="buscar" type="text" placeholder="Digite para buscar por Observação">
            </div>
            <button id="btn-buscar" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <h1 id="pagina" style="text-align: center;" class="mt-3">Página {{$page}}</h1>
    <div id="no-vendas-pendentes"></div>
    <!-- <table id="lista-vendas" class="table mt-3">
        <thead>
            <tr>
                <th scope="col">Nº</th>
                <th scope="col">Tipo Pagamento</th>
                <th style="text-align: center" scope="col">Total</th>
                <th>Observação</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="lista-vendas-body">
            <tr class="fade-in">
                <th id="produto" scope="row">1</th>
                <td>CERVEJA SKOL 300</td>
                <td style="text-align: center">ML</td>
                <td style="text-align: center">3.50</td>
                <td style="text-align: center">-7</td>
                <td>
                    <button id="btn-editar-produto-1" name="editar-produto" class="btn btn-warning mr-1" data-toggle="modal" data-target="#generic-modal" value="1">Produtos</button>
                    <button id="btn-deletar-produto-1" name="deletar-produto" class="btn btn-danger" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" value="1">Deletar</button>
                </td>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                    </div>
                </div>
            </tr>
        </tbody>
    </table> -->

    <!-- <div class="divTable">
             <div class="headRow">
                <div  class="divCell">Nº</div>
                <div  class="divCell">Observação</div>
                <div  class="divCell">Total</div>
                <div  class="d-flex justify-content-between divCell">
                    <button id="btn-editar-produto-1" name="editar-produto" class="btn btn-warning mr-1" data-toggle="modal" data-target="#generic-modal" value="1">Produtos</button>
                    <button id="btn-deletar-produto-1" name="deletar-produto" class="btn btn-danger" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" value="1">Deletar</button>
                </div>
             </div>
            <div class="divRow">
                  <div class="divCell">1</div>
                <div class="divCell">CERVEJA SKOL 300 ML</div>
                <div class="divCell">TESTETESTETESTE</div>
            </div>
           
      </div> -->

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="width: 50%;">Observação</th>
                    <th scope="col" style="text-align: center;">Desconto</th>
                    <th scope="col" style="text-align: center;">Total</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody id="lista-vendas" class="justify-content-between">
                <!-- <tr class="">
                    <td class="expand-button">5</td>
                    <td>VAI PAGAR MUUUUIITO TEMPO DEPOIS</td>
                    <td>35,50</td>
                    <td>
                        <button id="btn-finalizar-venda" name="finalizar-venda" class="btn btn-primary mr-1" data-toggle="modal" data-target="#generic-modal" value="1">Finalizar</button>
                        <button id="btn-produtos" name="visualizar-produtos" class="btn btn-warning mr-1" data-toggle="collapse" href="#collapse-id-1" value="1">Produtos</button>
                        <button id="btn-deletar-produto-1" name="deletar-produto" class="btn btn-danger" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" value="1">Deletar</button>
                    </td>
                </tr>
                <tr class="hide-table-padding">
                    <td></td>
                    <td colspan="3">
                        <div id="collapse-id-1" class="collapse in p-3">
                            <table class="table">
                                <thead class="subtable">
                                    <tr>
                                        <th scope="col" style="text-align: center;">Quantidade</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col" style="text-align: center;">Preço Unitário</th>
                                        <th scope="col" style="text-align: center;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td style="text-align: center;">2</td>
                                        <td>CERVEJA SKOL 320 ML</td>
                                        <td style="text-align: center;"> 35,50</td>
                                        <td style="text-align: center;">70,00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr> -->
            </tbody>
        </table>
        <p id="nenhuma-venda-encontrada" style="text-align: center;">Nada Consta</p>
    </div>


    @include('pages.index')

    <!-- Conteúdo da modal -->
    @extends('modal.index', ['titulo' => 'Finalizar Venda'])
        @section('modal-body')
        <div class="form-group container">
            <!-- Finalizar venda pendente -->
            <form>
                <section id="dados-venda">
                    <div id="dados-row" class="row">
                        <div class="col col-3">
                            <div class="form-group mt-3">
                                <label for="novo-produto">Tipo:</label>
                                <select class="form-control" id="tipo-pagamento">
                                    <option disabled>Selecione o Tipo de Pagamento</option>
                                    @foreach($tipo_pagamento as $pagamento)
                                        @if ($pagamento->id !=6)
                                            <option value="{{$pagamento->id}}">{{$pagamento->descricao}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group mt-3">
                                <label for="total-agar"><strong>Total pagar:</strong></label>
                                <input type="text" id="total-pagar" class="form-control mt-1 money" value="0,00" disabled>
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group mt-3">
                                <label for="valor-pago"><strong>Valor Pago:</strong></label>
                                <input type="text" id="valor-pago" class="form-control mt-1 money" placeholder="Informe Valor" value="0,00">
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group mt-3">
                                <label for="troco"><strong>Troco:</strong></label>
                                <input type="text" id="troco" class="form-control mt-1 money" value="0,00" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        @endsection

    @section('modal-footer')
        <div class="modal-footer">
            <div id="venda-actions">
                <button id="btn-finalizar" class="btn btn-primary">Finalizar</button>
            </div>
        </div>
    @endsection

    <!-- Conteúdo da modal confirm -->
    @extends('modal.confirm', ['titulo' => 'Confirma Exclusão?'])
    @section('modal-confirm-body')
    <section id="dados-venda">
        <p>Essa ação não poderá ser desfeita</p>
    </section>
    @endsection
    @section('modal-confirm-footer')
        <div id="confirm-actions">
            <button id="btn-remover-venda" class="btn btn-danger">Confirmar</button>
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/autocomplete.js') }}" defer></script>
    <script src="{{ asset('js/custom/dom/venda/view-pendentes.js') }}" type="module"></script>
@endsection