@extends('layout', ['titulo' => 'Produto'])

@section('cabecalho')
    Produtos
@endsection

@section('conteudo')
    <div id="dados-row" class="row d-flex justify-content-between mt-3">
        <button type="button" id="btn-cadastrar-produto" class="btn btn-primary" data-toggle="modal" data-target="#generic-modal">Cadastrar Novo Produto</button>
        <form autocomplete="off">
            <div class="autocomplete" style="width:350px;">
                <input id="buscar" type="text" placeholder="Digite para buscar">
            </div>
            <button id="btn-buscar" class="btn btn-primary">Buscar</button>
        </form>
    </div>
    <h1 id="pagina" style="text-align: center;" class="mt-3">Página {{$page}}</h1>
    <div id="no-products"></div>
    <table id="lista-produtos" class="table mt-3">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Descrição</th>
            <th style="text-align: center" scope="col">Unidade Medida</th>
            <th style="text-align: center" scope="col">Preço</th>
            <th style="text-align: center" scope="col">Quantidade Disp.</th>
            <th scope="col">Ação</th>
            </tr>
        </thead>
        <tbody id="lista-produtos-body">

        </tbody>
    </table>

    @include('pages.index')

    <!-- Conteúdo da modal -->
    @extends('modal.index', ['titulo' => 'Manutenção de Produtos'])
        @section('modal-body')
        <div class="form-group container">
            <!-- Dados Gerais do Produto -->
            <form>
                <section id="dados-produto">
                    <div id="dados-row" class="row">
                        <legend>Dados Gerais</legend>
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="id">ID:</label>
                                <input type="text" class="form-control" id="produto-id" name="id" value="" disabled>
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
                                <select class="form-control" id="produto-categoria" name="categoria" required>
                                    <option value="0" disabled>Selecione o Tipo</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria->id}}">{{$categoria->descricao}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col col-9">
                            <div class="form-group">
                                <label for="descricao">Descrição:</label>
                                <input type="text" class="form-control" id="produto-descricao" name="descricao" placeholder="Descrição" value="" required>
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="unidade-medida">UN Medida:</label>
                                <select class="form-control" id="produto-unidade-medida" name="unidade-medida">
                                    <option value="ML">ML</option>
                                    <option value="ML">G</option>
                                    <option value="LT">LT</option>
                                    <option value="PC">PC</option>
                                    <option value="CX">CX</option>
                                    <option value="OT">OT</option>
                                    <option value="UN">UN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-4">
                            <div class="form-group">
                                <label for="quantidade-estoque">Qtd. Atual:</label>
                                <input type="text" class="form-control" id="produto-quantidade-atual-estoque" name="quantidade-atual-estoque" value="" disabled>
                            </div>
                        </div>
                        <div class="col col-4">
                            <div class="form-group">
                                <label for="produto-quantidade-estoque">Definir:</label>
                                <input type="number" class="form-control" id="produto-quantidade-estoque" name="quantidade-estoque" value="">
                            </div>
                        </div>
                        <div class="col col-4">
                            <div class="form-group">
                                <label for="produto-nova-quantidade-estoque">Novo:</label>
                                <input type="text" class="form-control" id="produto-nova-quantidade-estoque" name="quantidade-estoque" value="" disabled>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <label for="preco-custo">Preço de Custo:</label>
                                <input type="text" class="form-control money" id="produto-preco-custo" name="preco-custo" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <label for="preco-venda">Preço de Venda:</label>
                                <input type="text" class="form-control money" id="produto-preco-venda" name="preco-venda" value="" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="form-group">
                                <label for="ativo">Ativo:</label>
                                <select class="form-control" id="produto-ativo" name="ativo">
                                    <option value="1">SIM</option>
                                    <option value="0">NÃO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
        @endsection

    @section('modal-footer')
        <div class="modal-footer">
            <div id="produto-actions">
                
            </div>
        </div>
    @endsection

    <!-- Conteúdo da modal confirm -->
    @extends('modal.confirm', ['titulo' => 'Confirma Exclusão?'])
    @section('modal-confirm-body')
    <section id="dados-produto">
        <div id="dados-row" class="row">
            <div class="col col-3">
                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" class="form-control" id="deletar-id" name="deletar-id" value="" disabled>
                </div>
            </div>
            <div class="col col-8">
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" class="form-control" id="deletar-descricao" name="deletar-descricao" placeholder="Descrição" value="" disabled>
                </div>
            </div>
        </div>
    </section>
    @endsection
    @section('modal-confirm-footer')
        <div id="confirm-actions">
            
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/autocomplete.js') }}" defer></script>
    <script src="{{ asset('js/custom/dom/produto/index.js') }}" type="module"></script>
@endsection