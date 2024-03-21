<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap Admin App">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <link rel="icon" type="image/x-icon" href="{{ asset('img/fav.ico')}}">
        <title></title><!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/brands.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/regular.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/solid.css')}}">
        <link rel="stylesheet" href="{{asset('vendor/@fortawesome/fontawesome-free/css/fontawesome.css')}}"><!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="{{asset('vendor/simple-line-icons/css/simple-line-icons.css')}}"><!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" id="bscss"><!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{asset('css/app.css')}}" id="maincss">
    </head>

    <body>
        @yield('content')
        <!-- MODERNIZR-->
        <script src="{{asset('vendor/modernizr/modernizr.custom.js')}}"></script><!-- STORAGE API-->
        <script src="{{asset('vendor/js-storage/js.storage.js')}}"></script><!-- i18next-->
        <script src="{{asset('vendor/i18next/i18next.js')}}"></script>
        <script src="{{asset('vendor/i18next-xhr-backend/i18nextXHRBackend.js')}}"></script><!-- JQUERY-->
        <script src="{{asset('vendor/jquery/dist/jquery.js')}}"></script><!-- BOOTSTRAP-->
        <script src="{{asset('vendor/popper.js/dist/umd/popper.js')}}"></script>
        <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.js')}}"></script><!-- PARSLEY-->
        <script src="{{asset('vendor/parsleyjs/dist/parsley.js')}}"></script><!-- =============== APP SCRIPTS ===============-->
        <script src="{{asset('js/app.js')}}"></script>
    </body>

</html>
