<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adega Master</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{'/images/favicon.png'}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:8000/css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div id="loading">
        <img id="loading-image" src="{{'/images/ajax-loader.gif'}}" alt="Carregando..." />
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2 d-flex justify-content-between">
        <a class="navbar-brand" href="/">
            <img src="{{asset('images/amaster-logo.png')}}">
        </a>
        <span class="company-name">{{\App\Util\Util::getUserAndEmpresa()}}</span>
    </nav>
    <div class="container fade-in mb-3">
        <div class="jumbotron">
            <h1>@yield('cabecalho')</h1>
        </div>
        <button class="btn btn-secondary" onclick="history.back()" value="Voltar">Voltar</button>
        <div id="message-handler"></div>

        @yield('conteudo')
    </div>
    <br/><br/>
    <footer class="navbar fixed-bottom navbar-dark bg-primary">
        <p style="width: 100%; color: white; text-align: center;">Adega Master | contato@ricardovidal.xyz</p>
    </footer>

    <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
    <script src="{{ asset('js/custom/Controllers/ApiController.js') }}" type="module"></script>
    <script src="{{ asset('js/custom/Controllers/ProdutoController.js') }}" type="module"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/util.js') }}" ></script>
</body>
</html>