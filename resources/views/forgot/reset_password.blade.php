<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap Admin App">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <link rel="icon" type="image/x-icon" href="{{ asset('img/fav.ico')}}">
        <title>Paradox - Change Password</title>
        <!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/brands.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/regular.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/solid.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/fontawesome.css')}}"><!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css')}}"><!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}" id='bscss'><!-- =============== APP STYLES ===============-->

        <!-- Datatables-->
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-keytable-bs/css/keyTable.bootstrap.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-responsive-bs/css/responsive.bootstrap.css')}}"><!-- =============== BOOTSTRAP STYLES ===============-->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css')}}" id="bscss"><!-- =============== APP STYLES ===============-->
        <link rel="stylesheet" href="{{ asset('css/app.css')}}" id="maincss">

        <script src="https://kit.fontawesome.com/d565f77dcb.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <div class="wrapper">

            <!---Block Start-->

            <div class="block-center mt-5 wd-xl">
                <!-- START card-->
                <div class="card card-flat ">
                    <div class="card-header text-center" style="background-color:#000">
                        <a href="#">
                            <img class="block-center rounded" src="{{ asset('img/logo-dark.png')}}" alt="Image" >
                        </a>
                    </div>
                    <div class="card-body">

                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <p class="text-center py-2">Reset Password</p>

                        <form method="POST" action="{{route('reset_password_submit')}}" class="mb-3" novalidate >
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input type="hidden" name="forgot_token" value="{{ $token }}">
                                    <input class="form-control border-right-0 borderLeft form-control @error('password') is-invalid @enderror" type="password" placeholder="Enter Password" autocomplete="off" name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0">
                                            <em class="fa fa-lock"></em>
                                        </span>
                                    </div>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group with-focus">
                                    <input class="form-control border-right-0 borderLeft form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="Re-enter Password for confirmation" autocomplete="off" name="password_confirmation" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted bg-transparent border-left-0">
                                            <em class="fa fa-lock"></em>
                                        </span>
                                    </div>

                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-block btn-themebutton mt-4" type="submit">Send</button>
                        </form>
                    </div>
                </div><!-- END card-->

                <footer class="footer-container"><span>&copy; 2020 - Paradox</span></footer>

            </div>
            <!-- =============== VENDOR SCRIPTS ===============-->

            <script src="{{ asset('vendor/jquery/dist/jquery.js')}}"></script><!-- BOOTSTRAP-->
            <script src="{{ asset('vendor/modernizr/modernizr.custom.js')}}"></script><!-- STORAGE API-->
            <script src="{{ asset('vendor/js-storage/js.storage.js')}}"></script><!-- i18next-->
            <script src="{{ asset('vendor/i18next/i18next.js')}}"></script>
            <script src="{{ asset('vendor/i18next-xhr-backend/i18nextXHRBackend.js')}}"></script><!-- JQUERY-->
            <script src="{{ asset('vendor/popper.js/dist/umd/popper.js')}}"></script>
            <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.js')}}"></script><!-- PARSLEY-->

            <!-- Datatables-->
            <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons-bs/js/buttons.bootstrap.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.colVis.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.flash.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-keytable/js/dataTables.keyTable.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-responsive/js/dataTables.responsive.js')}}"></script>
            <script src="{{ asset('vendor/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
            <script src="{{ asset('vendor/jszip/dist/jszip.js')}}"></script>
            <script src="{{ asset('vendor/pdfmake/build/pdfmake.js')}}"></script>
            <script src="{{ asset('vendor/pdfmake/build/vfs_fonts.js')}}"></script>
            <script src="{{ asset('vendor/js-storage/js.storage.js')}}"></script><!-- SCREENFULL-->
            <script src="{{ asset('vendor/nestable/jquery.nestable.js')}}"></script><!-- =============== APP SCRIPTS ===============-->
            <script src="{{ asset('vendor/parsleyjs/dist/parsley.js')}}"></script><!-- =============== APP SCRIPTS ===============-->
            <script src="{{ asset('js/app.js')}}"></script>

            <script>
function goBack() {
    window.history.back();
}
            </script>
    </body>
</html>
