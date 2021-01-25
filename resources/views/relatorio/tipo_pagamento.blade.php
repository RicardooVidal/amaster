@extends('layout', ['titulo' => 'Relatório por Tipo de Pagamento'])

@section('cabecalho')
    Relatório por Tipo de Pagamento
@endsection

@section('conteudo')
        <div class="form-group mt-3">
            <label for="categoria">Tipo de Pagamento:</label>
            <select class="form-control" id="tipo-pagamento" name="tipo-pagamento">
                <option value="0">Selecione o tipo de pagamento</option>
                @foreach($tipo_pagamento as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->descricao}}</option>
                @endforeach
            </select>
            <label for="data-inicial" class="mt-2">Data Inicial:</label>
            <input type="date" class="form-control" id="data-inicial" name="data-inicial">
            <label for="data-final" class="mt-2">Data Final:</label>
            <input type="date" class="form-control" id="data-final" name="data-final">
        </div>
        <button class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#generic-modal-confirm">Emitir</button>

    <!-- Conteúdo da modal confirm -->
    @extends('modal.confirm', ['titulo' => 'Confirma Emissão?'])

    @section('modal-confirm-body')
        <p>O relatório será emitido</p>
    @endsection
    
    @section('modal-confirm-footer')
        <div id="confirm-actions">
            <button id="emitir-relatorio-tipo_pagamento" class="btn btn-primary">Emitir</button>
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/relatorio/tipo_pagamento.js') }}" type="module"></script>
@endsection