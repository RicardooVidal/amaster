<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Adega Master | Login</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{'/images/favicon.png'}}">
    <div id="login-container" class="container fade-in">
        <div id="login-div">
            <div id="login-logo">
                <img src="{{asset('images/amaster-logo.png')}}">
            </div>
            <div id="login-forms" class="form-group">
                <div id="login-message" class="mt-2">
                    @if (isset($msg))
                        <div class="alert alert-danger">{{$msg}}</div>
                    @endif
                </div>
                <form method="POST" action="{{ asset('/login') }}">
                    @csrf
                    <input type="text" name="username" placeholder="Usuário" class="form-control" autocomplete="off">
                    <input type="password" name="password" placeholder="Senha" class="form-control">
                    <input type="submit" class="btn btn-primary btn-block" value="Login">
                </form>

            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>
<body>

</body>
</html>