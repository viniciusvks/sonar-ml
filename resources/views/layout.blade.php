<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{--    <title>{{ config('app.name', 'Sonar') }}</title>--}}
        <title>Sonar</title>

        <script src="{{ mix('js/app.js') }}" defer></script>
        @yield('js')
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <main id="app" class="d-flex align-items-stretch">
            <section class="container-fluid content-inner">
                @yield('content')
            </section>
        </main>
    </body>
</html>
