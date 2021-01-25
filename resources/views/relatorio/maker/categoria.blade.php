@extends('relatorio.maker.header', ['titulo' => 'Relatório por Categoria'])

@section('conteudo')
    <div class="relatorio container">
        <header>
            <div class="d-flex justify-content-between mt-3">
                <p class="mt-3">Data: {{$data['data_requisicao']}}</p> 
                <span></span>
                <div>
                    <h2>Relatório por Categoria</h2>
                    <p>Período: {{$data['data_inicial']}} até {{$data['data_final']}}</p>
                    <p><span style="font-weight: bold">Categoria: {{$data['categoria']}}</span></p>
                </div>
                <span></span>
                <p class="mt-3"><strong>{{\App\Util\Util::getEmpresa()}}</strong></p>
            </div>
        </header>
        <section>
            <?php 
                $valor_total = 0;
                $quantidade_total_itens = 0
            ?>
            @if (count($data['produtos']) < 1)
                <p style="text-align: center;">Nada consta</p>
            @else
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col" style="text-align: center;">Data</th>
                            <th scope="col" style="text-align: center;">Quantidade Vendida</th>
                            <th scope="col" style="text-align: center;">Produto</th>
                            <th scope="col" style="text-align: center;">Categoria</th>
                            <th scope="col" style="text-align: center;">Total Período</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
            @endif
                    @foreach($data['produtos'] as $venda)
                        <?php 
                            $valor_total += $venda['total'];
                            $quantidade_total_itens += $venda['quantidade_total'];
                        ?>
                        <td style="text-align: center;">{{$venda['data_venda']}}</td>
                        <td style="text-align: center;">{{$venda['quantidade_total']}}</td>
                        <td style="text-align: center;">{{$venda['produto']}}</td>
                        <td style="text-align: center;">{{$venda['categoria']}}</td>
                        <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($venda['total'])}}</td>
                        <td colspan="5">
                        <tr></tr>
                    @endforeach
                    </tr>
                </tbody>
                @if (count($data['produtos']) > 0)
                    <tfoot>
                        <tr>
                            <td style="text-align: right; font-weight: bold">Quantidade total:</td>
                            <td style="text-align: center; font-weight: bold">{{$quantidade_total_itens}}</td>
                            <td></td>
                            <td style="text-align: right; font-weight: bold">Valor total:</td>
                            <td style="text-align: center; font-weight: bold">R$ {{\App\Util\Money::convertToReais($valor_total)}}</td>
                            <td></td>
                            <td colspan="5">
                            <tr></tr>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </section>
    </div>
@endsection