<!doctype html>
<html lang="pt_BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="stylesheet" href="{{ url(mix('/front/assets/css/reset.css')) }}">
        <link rel="stylesheet" href="{{ url(mix('/front/assets/css/app.css')) }}">
        <link rel="shortcut icon" href="{{ asset('/img/favicon/pocketfinance.png') }}" />

        <script src="https://kit.fontawesome.com/e3c510ddaa.js" crossorigin="anonymous"></script>

        <title>Pocket Finance</title>
    </head>
    <body>
        <div class="app">

            @include('app.includes.header')

            <div class="app-box">

                @include('app.includes.nav')

                <main class="main">

                    @yield('content')

                </main>
            </div>
        </div>

        <script src="{{ url(mix('/assets/js/vendor.js')) }}"></script>
        <script src="{{ url(mix('/app/assets/js/app.js')) }}"></script>
        @hasSection('script')
            @yield('script')
        @endif

    </body>
</html>
