<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Adega Master</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
</head>
<body>
    <div id="loading">
        <img id="loading-image" src="{{asset('images/ajax-loader.gif')}}" alt="Carregando..." />
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2 d-flex justify-content-between">
        <a class="navbar-brand" href="/">
            <img src="{{asset('images/amaster-logo.png')}}">
        </a>
        @if (Auth::user()->id_empresa > 0)
            <span class="company-name">{{\App\Util\Util::getUserAndEmpresa()}}</span>
        @endif
    </nav>
    <div class="container">
        <div id="message-handler"></div>
        @yield('conteudo')
    </div>
    <footer class="navbar fixed-bottom navbar-expand-lg navbar-dark bg-primary mt-2">
        <p style="width: 100%; color: white; text-align: center;">Adega Master | contato@ricardovidal.xyz</p>
    </footer>
    <script type="text/javascript" src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/custom/util.js') }}" ></script>
    @if (Auth::user()->id_empresa > 0)
        <script src="{{ asset('js/custom/dom/index.js') }}" type="module"></script>
    @endif
</body>
</html>