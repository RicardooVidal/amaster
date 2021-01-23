<DOCTYPE html>
    <html>
        <head>
            <title>{{$titulo}}</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <style>
                * {
                    margin: 0;
                    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', 'Geneva', 'Verdana', 'sans-serif';
                }

                .subtable {
                    background-color: rgb(110, 110, 110);
                    color: white;
                }

                .relatorio header {
                    text-align: center;
                }
            </style>
        </head>
        <body>
            @yield('conteudo')
        </body>
    </html>