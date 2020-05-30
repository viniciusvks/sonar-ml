<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>iControlRural</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="row">
            <main class="col-sm-12">
                <div class="card h-100 row">
                    <div class="card-header">
                        <div class="mx-5 px-5 text-center">
                            <img src="{{ asset('img/logo-black.png') }}">
                        </div>
                    </div>
                    <div class="card-body mx-5 px-5">
                        <div class="card-title">
                            <h4 class="text-success text-left">{{ 'Bem-vindo(a) à iControl Rural!' }}</h4>
                        </div>
                        <p class="mb-0">
                            {{ 'Para ativar sua conta, clique no botão abaixo:' }}
                        </p>
                        <div class="p-3 text-center">
                            <a href="{{ $url }}" class="btn btn-success" role="button">Ativar minha conta</a>
                        </div>
                        <p class="mb-0">
                            {{ 'Se você não criou uma conta, nenhuma ação é necessária' }}
                        </p>
                        <br>
                        {{ 'Atenciosamente,' }}
                        <br>
                        {{ 'iControl' }}
                        <hr>
                        <small>
                            {{ 'Se estiver tendo problemas ao clicar no botão, copie e cole a URL abaixo no seu navegador:' }}
                            <br>
                            <a href="{{ $url }}"  target="_blank">{{ $url }}</a>
                        </small>
                    </div>
                    <small class="card-footer text-center text-muted">
                        {{ '© 2019 iControl. Todos os direitos reservados.' }}
                    </small>
                </div>
            </main>
        </div>
    </body>
</html>