<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Ingresar | {{ config('app.name') }}</title>
        <link rel="shortcut icon" href="{{asset('img/upclogo.png')}}">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CIARP') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<!--        <link href="{{asset('css/fuente.css')}}" rel="stylesheet" type="text/css">-->
        <link href="{{asset('css/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/plugins/node-waves/waves.css')}}" rel="stylesheet" />
        <link href="{{asset('css/plugins/animate-css/animate.css')}}" rel="stylesheet" />
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
    </head                        >
    <body class="login-page">
        <div class="login-box">
            <div class="logo">
                <img src="{{asset('img/logocesar.png')}}" alt="logo" width="350">
            </div>
        </div>
        @yield('content')
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap/js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/node-waves/waves.js') }}"></script>
        <script src="{{ asset('js/jquery-validation/jquery.validate.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
        <script src="{{ asset('js/pages/examples/sign-in.js') }}"></script>
        @yield('scripts')
    </body>
</html>