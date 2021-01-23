@extends('layout', ['titulo' => 'Vendas'])

@section('cabecalho')
    Vendas
@endsection

@section('conteudo')
    <div id="dados-row" class="row d-flex justify-content-between mt-3">
    </div>
    <h1 id="pagina" style="text-align: center;" class="mt-3">Página {{$page}}</h1>
    <div id="no-vendas-pendentes"></div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="width: 35%;">Observação</th>
                    <th scope="col" style="text-align: center;">Pagamento</th>
                    <th scope="col" style="text-align: center;">Pago</th>
                    <th scope="col" style="text-align: center;">Troco</th>
                    <th scope="col" style="text-align: center;">Desconto</th>
                    <th scope="col" style="text-align: center;">Total</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody id="lista-vendas" class="justify-content-between">
            </tbody>
        </table>
        <p id="nenhuma-venda-encontrada" style="text-align: center;">Nada Consta</p>
    </div>


    @include('pages.index')

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
    <script src="{{ asset('js/custom/dom/venda/view.js') }}" type="module"></script>
@endsection