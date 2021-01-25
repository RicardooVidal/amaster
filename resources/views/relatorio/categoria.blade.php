@extends('layout', ['titulo' => 'Relatório por categoria'])

@section('cabecalho')
    Relatório por categoria
@endsection

@section('conteudo')
        <div class="form-group mt-3">
            <label for="categoria">Categoria:</label>
            <select class="form-control" id="categoria" name="categoria">
                <option value="0">Selecione a categoria</option>
                @foreach($categorias as $categoria)
                    <option value="{{$categoria->id}}">{{$categoria->descricao}}</option>
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
            <button id="emitir-relatorio-categoria" class="btn btn-primary">Emitir</button>
        </div>
    @endsection
    <script src="{{ asset('js/custom/dom/relatorio/categoria.js') }}" type="module"></script>
@endsection