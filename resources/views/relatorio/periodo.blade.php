@extends('layout', ['titulo' => 'Relatório por período'])

@section('cabecalho')
    Relatório por período
@endsection

@section('conteudo')
        <div class="form-group mt-3">
            <label for="data-inicial">Data Inicial:</label>
            <input type="date" class="form-control" id="data-inicial" name="data-inicial">
            <label for="data-final" class="mt-2">Data Final:</label>
            <input type="date" class="form-control" id="data-final" name="data-final">
            <input type="checkbox" id="margem-lucro" name="margem-lucro">
            <label for="margem-lucro" class="mt-2">Mostrar Margem Lucro </label><br>
            <input type="checkbox" id="valor-lucro" name="valor-lucro">
            <label for="valor-lucro" class="mt-2">Mostrar Valor Lucro </label>
        </div>
        <button class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#generic-modal-confirm">Emitir</button>

    <!-- Conteúdo da modal confirm -->
    @extends('modal.confirm', ['titulo' => 'Confirma Emissão?'])

    @section('modal-confirm-body')
        <p>O relatório será emitido</p>
    @endsection
    
    @section('modal-confirm-footer')
        <div id="confirm-actions">
            <button id="emitir-relatorio-periodo" class="btn btn-primary">Emitir</button>
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/relatorio/periodo.js') }}" type="module"></script>
@endsection