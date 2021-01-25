@extends('layout', ['titulo' => 'Relatório'])

@section('cabecalho')
    Selecione o tipo de relatório
@endsection

@section('conteudo')
    <a href="relatorio/periodo" id="b" class="btn btn-primary btn-block mt-3">Relatório de vendas por período</a>
    <a href="relatorio/categoria" id="c" class="btn btn-primary btn-block mt-3">Relatório de vendas categoria</a>
    <a href="relatorio/tipo_pagamento" id="d" class="btn btn-primary btn-block mt-3">Relatório de vendas por tipo de pagamento</a>
@endsection