@extends('relatorio.maker.header', ['titulo' => 'Relatório por Período'])

@section('conteudo')
    <div class="relatorio container">
        <header>
            <div class="d-flex justify-content-between mt-3">
                <p class="mt-3">Data: {{$data['data_requisicao']}}</p> 
                <span></span>
                <div>
                    <h2>Relatório por Período</h2>
                    <p>Período: {{$data['data_inicial']}} até {{$data['data_final']}}</p>
                </div>
                <span></span>
                <p class="mt-3"><strong>{{\App\Util\Util::getEmpresa()}}</strong></p>
            </div>
        </header>
        <section>
            <?php
                $margem_lucro = false;
                $valor_lucro = false;

                if (isset($data['margem_lucro']) && $data['margem_lucro']) {
                    $margem_lucro = true;
                }
            
                if (isset($data['valor_lucro']) && $data['valor_lucro']) {
                    $valor_lucro = true;
                }
            ?>
            @if (count($data['hits']['hits']) < 1)
                <p style="text-align: center;">Nada consta</p>
            @endif
            <?php 
                $valor_total = 0;
                $lucro_total = 0;
                $quantidade_total_itens = 0
            ?>
            @foreach($data['hits']['hits'] as $venda)
                <?php 
                    $valor_total += $venda['_source']['valor_total'];
                ?>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="width: 35%;">Observação</th>
                            <th scope="col" style="text-align: center;">Pagamento</th>
                            <th scope="col" style="text-align: center;">Pago</th>
                            <th scope="col" style="text-align: center;">Troco</th>
                            <th scope="col" style="text-align: center;">Desconto</th>
                            <th scope="col" style="text-align: center;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$venda['_id']}}</td>
                            <td>{{\App\Util\Util::stripStringBiggerThan55($venda['_source']['observacao'])}}</td>
                            <td style="text-align: center;">{{$venda['_source']['tipo_pagamento']}}</td>
                            <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($venda['_source']['troco'] + $venda['_source']['valor_total'])}}</td>
                            <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($venda['_source']['troco'])}}</td>
                            <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($venda['_source']['desconto'])}}</td>
                            <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($venda['_source']['valor_total'])}}</td>
                            <td colspan="7">
                            <tr></tr>
                            <table style="width: 90%;" class="ml-5">
                                <thead class="subtable">
                                    <tr>
                                        <th style="text-align: center;">Quantidade</th>
                                        <th style="text-align: center;">Descrição</th>
                                        <th style="text-align: center;">Preço Unitário</th>
                                        <th style="text-align: center;">Preço Custo</th>
                                        @if ($margem_lucro)
                                            <th style="text-align: center;">Margem</th>
                                        @endif
                                        @if ($valor_lucro)
                                            <th style="text-align: center;">Lucro</th>
                                        @endif
                                        <th style="text-align: center;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($venda['_source']['produtos'] as $produto)
                                    <?php $quantidade_total_itens += $produto['quantidade']; ?>
                                    <tr>
                                        <td style="text-align: center;">{{$produto['quantidade']}}</td>
                                        <td style="text-align: center;">{{$produto['descricao']}}</td>
                                        <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($produto['preco'])}}</td>
                                        @if ($margem_lucro)
                                            <?php $valor_custo = 0; ?>
                                            <td style="text-align: center;">{{\App\Util\Money::getMargemLucro($valor_custo, $produto['preco'])}}% (cada)</td>
                                        @endif

                                        @if (!isset($produto['preco_custo']))
                                            <?php $valor_custo = \App\Util\Util::getValorCusto($produto['id']); ?>
                                        @else
                                            <?php $valor_custo = $produto['preco_custo']; ?>
                                        @endif
                                        <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($valor_custo)}}</td>
                                        
                                        @if ($valor_lucro)
                                            <?php
                                                $lucro = $produto['preco'] - $valor_custo;
                                                $lucro_total += $lucro
                                            ?>
                                            <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($lucro)}} (cada)</td>
                                        @endif

                                        <td style="text-align: center;">R$ {{\App\Util\Money::convertToReais($produto['quantidade'] * $produto['preco'])}}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7" class="subtable" style="text-align: center;">Fim dos Produtos da Venda</td>
                                </tr>
                                </tbody class="mt-5">
                            </table>
                        </tr>
                    </tbody>
                    @if (count($data['hits']['hits']) > 0)
                    <tfoot>
                    </tfoot>
                @endif
                </table>
            @endforeach
            <table style="width: 100%; color: white;  background-color: black;" class="mt-3">
                <thead>
                </thead>
                <tbody>
                    <td style="text-align: right; font-weight: bold">Quantidade Geral:</td>
                    <td style="text-align: center; font-weight: bold">{{$quantidade_total_itens}}</td>
                    @if ($lucro_total)
                        <td style="text-align: right; font-weight: bold">Lucro Geral:</td>
                        <td style="text-align: right; font-weight: bold">R$ {{\App\Util\Money::convertToReais($lucro_total)}}</td>
                    @endif  
                    <td style="text-align: right; font-weight: bold">Total Geral:</td>
                    <td style="text-align: center; font-weight: bold">R$ {{\App\Util\Money::convertToReais($valor_total)}}</td>
                    <tr></tr>
                </tbody class="mt-5">
            </table>
        </section>
    </div>
@endsection