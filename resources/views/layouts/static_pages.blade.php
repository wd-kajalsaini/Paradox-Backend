<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap Admin App">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <link rel="icon" type="image/x-icon" href="{{ asset('public/img/fav.ico')}}">
        <title></title><!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <link rel="stylesheet" href="{{asset('public/vendor/@fortawesome/fontawesome-free/css/brands.css')}}">
        <link rel="stylesheet" href="{{asset('public/vendor/@fortawesome/fontawesome-free/css/regular.css')}}">
        <link rel="stylesheet" href="{{asset('public/vendor/@fortawesome/fontawesome-free/css/solid.css')}}">
        <link rel="stylesheet" href="{{asset('public/vendor/@fortawesome/fontawesome-free/css/fontawesome.css')}}"><!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="{{asset('public/vendor/simple-line-icons/css/simple-line-icons.css')}}"><!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{asset('public/css/bootstrap.css')}}" id="bscss"><!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{asset('public/css/app.css')}}" id="maincss">
    </head>

    <body>
        @yield('content')
        <!-- MODERNIZR-->
        <script src="{{asset('public/vendor/modernizr/modernizr.custom.js')}}"></script><!-- STORAGE API-->
        <script src="{{asset('public/vendor/js-storage/js.storage.js')}}"></script><!-- i18next-->
        <script src="{{asset('public/vendor/i18next/i18next.js')}}"></script>
        <script src="{{asset('public/vendor/i18next-xhr-backend/i18nextXHRBackend.js')}}"></script><!-- JQUERY-->
        <script src="{{asset('public/vendor/jquery/dist/jquery.js')}}"></script><!-- BOOTSTRAP-->
        <script src="{{asset('public/vendor/popper.js/dist/umd/popper.js')}}"></script>
        <script src="{{asset('public/vendor/bootstrap/dist/js/bootstrap.js')}}"></script><!-- PARSLEY-->
        <script src="{{asset('public/vendor/parsleyjs/dist/parsley.js')}}"></script><!-- =============== APP SCRIPTS ===============-->
        <script src="{{asset('public/js/app.js')}}"></script>
    </body>

</html>