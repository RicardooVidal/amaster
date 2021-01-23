@extends('default')

@section('conteudo')
<div class="dashboard fade-in mt-2">
        <div>
            <h2>Informações:</h2>   
        </div>
        <div>
            <h4>Produto mais vendido no período:</h4>
            <div id="dashboard-destaque">
                <h3>Nada Consta</h3>
            </div>
        </div>
        <div>
            <h5>Quantidade de vendas pendentes:</h5>
            <a href="/venda/pendente/list/1" id="btn-vendas-pendentes" class="btn btn-danger btn-block mt-3"></a>
        </div>
    </div>

    <div class="menu fade-in">
        <div class="d-flex">
            <figure class="figure-img img-fluid">
                <a href="/venda">
                    <img src="{{'/images/home/money.png'}}">
                <p>Vendas</p>
                </a>
            </figure>
           
            <figure class="figure-img img-fluid">
                <a href="produto/list/1">
                    <img src="{{'/images/home/products.png'}}">
                    <p>Produtos</p>
                </a>
            </figure>
        </div>
        <div class="d-flex">
            <figure class="figure-img img-fluid">
                <a href="relatorio">
                    <img src="{{'/images/home/paper.png'}}">
                    <p>Relatórios</p>
                </a>
            </figure>
            <figure class="figure-img img-fluid">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        <img src="{{'/images/home/exit.png'}}">
                        <p>Sair</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </figure>
        </div>
    </div>
@endsection