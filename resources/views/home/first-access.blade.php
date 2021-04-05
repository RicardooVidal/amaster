@extends('default')

@section('conteudo')
    <div class="first-access mt-3">
        <form id="form-cadastro" method="POST" action="/empresa">
            <h1>Primeiro Acesso</h1>
            <legend>Dados da Empresa</legend>
            <small>Por favor preencha os dados necessários (*) abaixo</small>
            <div class="form-group mt-3">
                <label for="razao-social">Razão Social (*):</label>
                <input type="text" class="form-control" name="razao_social" autocomplete="off" required>
                <label for="cnpj" class="mt-2">CNPJ:</label>
                <input type="text" class="form-control cnpj" name="cnpj" autocomplete="off">
            </div>
            <legend>Dados do Usuário</legend>
            <div class="form-group mt-3">
                <label for="nome" class="mt-2">Nome (*):</label>
                <input type="text" class="form-control" name="nome" placeholder="Este nome será exibido ao iniciar a sessão no sistema" autocomplete="off" required>
                <label for="password" class="mt-2">Senha (*):</label>
                <input type="password" class="form-control" name="password" placeholder="Por razões de segurança, mude sua senha" autocomplete="off" required>
            </div>
            <p style="text-align: center">
                Ao finalizar você estará aceitando que o Adega Master se encontra na versão <strong>beta</strong> e que está sujeito a bugs e constantes atualizações. 
                Ao finalizar você estará entrando em programa de demonstração que será contabilizado a partir da data de hoje somado 30 dias.
                Após este período, se houver interesse no produto, verificar com o administrador para liberação via pagamento.
                Qualquer dúvida favor entrar em contato no e-mail <strong>contato@ricardovidal.xyz</strong> e para reportar bugs, favor enviar para <strong>reports@ricardovidal.xyz</strong>
            </p>
            <input type="submit" id="finalizar" class="btn btn-primary btn-block mt-3" value="Finalizar" data-toggle="modal" data-target="#generic-modal-confirm"></button>
        </form>
        <a class="btn btn-danger btn-block mt-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cancelar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <br/><br/><br/>
    </div>

    <!-- Conteúdo da modal confirm -->
    @extends('modal.confirm', ['titulo' => 'Confirma os Dados?'])
    @section('modal-confirm-body')
    <section>
        <p>O sistema será configurado.</p>
    </section>
    @endsection
    @section('modal-confirm-footer')
        <div id="confirm-actions">
            <button id="confirmar-cadastro" class="btn btn-primary">Confirmar os Dados</button>
        </div>
    @endsection

    <script src="{{ asset('js/custom/dom/first-access.js') }}" type="module"></script>
@endsection