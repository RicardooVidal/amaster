@extends('layout', ['titulo' => 'Erro'])

@section('cabecalho')
    Erro
@endsection

@section('conteudo')
    <p class="mt-3">{{ $exception->getMessage() }}</p>
@endsection