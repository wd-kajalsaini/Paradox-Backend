<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Paradox">
        <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" href="{{ asset('img/fav.ico')}}">
        <title>Paradox - {{ $page_title }}</title>
        <!-- =============== VENDOR STYLES ===============-->
        <!-- FONT AWESOME-->
        <script src="{{ asset('vendor/jquery/dist/jquery.js')}}"></script><!-- BOOTSTRAP-->
        <link rel="stylesheet" href="{{ asset('dist/css/demo.css')}}">
        <link rel="stylesheet" href="{{ asset('dist/css/dropify.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/brands.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/regular.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/solid.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/fontawesome.css')}}"><!-- SIMPLE LINE ICONS-->
        <link rel="stylesheet" href="{{ asset('vendor/simple-line-icons/css/simple-line-icons.css')}}"><!-- =============== BOOTSTRAP STYLES ===============-->

        <!-- BOOTSTRAP 3.3.7-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css">
        <link href="{{ asset('icon/css/icon-picker.min.css')}}" media="all" rel="stylesheet" type="text/css" />

        @if(Auth::user()->locale=="english" || Auth::user()->locale=="russian")
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}" id="bscss">
        <!--  APP STYLES -->
        <link rel="stylesheet" href="{{ asset('css/app.css')}}" id="maincss">

        @else
        <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css')}}" id="bscss">
        <!--  APP STYLES -->
        <link rel="stylesheet" href="{{ asset('css/app-rtl.css')}}" id="maincss">

        @endif
        <!-- END LTR -->

        <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.css')}}">

        <!--  ANIMATE.CSS-->
        <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css')}}">
        <!-- WHIRL (spinners)-->
        <link rel="stylesheet" href="{{ asset('vendor/whirl/dist/whirl.css')}}">

        <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.css')}}">
        <link rel="stylesheet" href="{{ asset('libs/flatpickr/flatpickr.min.css')}}">

        <!-- Datatables-->
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-keytable-bs/css/keyTable.bootstrap.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/datatables.net-responsive-bs/css/responsive.bootstrap.css')}}">
        <!-- =============== BOOTSTRAP STYLES ===============-->
        <script type="text/javascript" src="{{asset('js/ckfinder/ckfinder.js')}}"></script>
        <script>CKFinder.config({connectorPath: '{{asset("ckfinder/connector")}}'});</script>



        <script src="https://kit.fontawesome.com/d565f77dcb.js" crossorigin="anonymous"></script>
        <style>
        .loader{
            width: 150px;
            height: 150px;
            margin: 15% auto;
            transform: rotate(-45deg);
            font-size: 0;
            line-height: 0;
            animation: rotate-loader 5s infinite;
            padding: 25px;
            border: 1px solid #978200;
        }
        .loader .loader-inner{
            position: relative;
            display: inline-block;
            width: 50%;
            height: 50%;
        }
        .loader .loading{
            position: absolute;
            background: #978200;
        }
        .loader .one{
            width: 100%;
            bottom: 0;
            height: 0;
            animation: loading-one 1s infinite;
        }
        .loader .two{
            width: 0;
            height: 100%;
            left: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.25s;
        }
        .loader .three{
            width: 0;
            height: 100%;
            right: 0;
            animation: loading-two 1s infinite;
            animation-delay: 0.75s;
        }
        .loader .four{
            width: 100%;
            top: 0;
            height: 0;
            animation: loading-one 1s infinite;
            animation-delay: 0.5s;
        }
        @keyframes loading-one {
            0% {
                height: 0;
                opacity: 1;
            }
            12.5% {
                height: 100%;
                opacity: 1;
            }
            50% {
                opacity: 1;
            }
            100% {
                height: 100%;
                opacity: 0;
            }
        }
        @keyframes loading-two {
            0% {
                width: 0;
                opacity: 1;
            }
            12.5% {
                width: 100%;
                opacity: 1;
            }
            50% {
                opacity: 1;
            }
            100% {
                width: 100%;
                opacity: 0;
            }
        }
        @keyframes rotate-loader {
            0% {
                transform: rotate(-45deg);
            }
            20% {
                transform: rotate(-45deg);
            }
            25% {
                transform: rotate(-135deg);
            }
            45% {
                transform: rotate(-135deg);
            }
            50% {
                transform: rotate(-225deg);
            }
            70% {
                transform: rotate(-225deg);
            }
            75% {
                transform: rotate(-315deg);
            }
            95% {
                transform: rotate(-315deg);
            }
            100% {
                transform: rotate(-405deg);
            }
        }
    </style>
    </head>

    <body>
        <div class="" id="loader" style="position: fixed;top: 0;left: 0;width: 100%;height: 100%;background: rgba(255,255,255,0.8);z-index:99999;display: none;">
            <div class="row">
                <div class="col-md-12">
                    <div class="loader">
                        <div class="loader-inner">
                            <div class="loading one"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading two"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading three"></div>
                        </div>
                        <div class="loader-inner">
                            <div class="loading four"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper">

            <!-- top navbar-->
            <header class="topnavbar-wrapper">
                <!-- START Top Navbar-->
                <nav class="navbar topnavbar bg-black">
                    <!-- START navbar header-->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#/">
                            <div class="brand-logo p-0">
                                <img class="img-fluid width-1" src="{{ asset('img/logo.png')}}" alt="App Logo">
                            </div>
                            <div class="brand-logo-collapsed"><img class="img-fluid" src="{{ asset('img/fav.png')}}" alt="App Logo"></div>
                        </a>
                    </div><!-- END navbar header-->
                    <!-- START Left navbar-->
                    <ul class="navbar-nav mr-auto flex-row">
                        <li class="nav-item">
                            <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                            <a class="nav-link d-none d-md-block d-lg-block d-xl-block" href="#" data-trigger-resize="" data-toggle-state="aside-collapsed"><em class="fas fa-bars"></em></a><!-- Button to show/hide the sidebar on mobile. Visible on mobile only.--><a class="nav-link sidebar-toggle d-md-none" href="#" data-toggle-state="aside-toggled" data-no-persist="true"><em class="fas fa-bars"></em></a></li><!-- START User avatar toggle-->
                        <li class="nav-item d-none d-md-block">
                            <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                            <a class="nav-link" id="" href="{{route('editManager',Auth::user()->id)}}" ><em class="fa fa-user"></em></a></li><!-- END User avatar toggle-->
                        <!-- START lock screen-->
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Lock screen"><em class="fa fa-unlock"></em></a></li><!-- END lock screen-->

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <!-- START -->
                        <li class="nav-item d-none d-md-block">
                            <div class="dropdown mt-3">
                                <button class="btn btn-primary dropdown-toggle b-0" type="button" data-toggle="dropdown" style="border:1px solid white;background: transparent;">
                                    @if(Cookie::get('locale'.Auth::user()->id)=="hebrew")
                                    {{'עברית' }}
                                    @elseif(Cookie::get('locale'.Auth::user()->id)=="english")
                                    {{'English' }}
                                    @endif
                                </button>
                                <ul class="dropdown-menu">
                                    <li ><a href="{{route('setLocale','hebrew')}}" >עברית</a></li>
                                    <li><a href="{{route('setLocale','english')}}">English</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- END --
                        <li class="nav-item d-none d-md-block"><a class="nav-link" href="" title="תירבע">תירבע</a></li> END -->
                    </ul><!-- END Left navbar-->

                </nav><!-- END Top Navbar-->
            </header><!-- sidebar-->
            <aside class="aside-container">
                <!-- START Sidebar (left)-->
                <div class="aside-inner">
                    <nav class="sidebar" data-sidebar-anyclick-close="">
                        <!-- START sidebar nav-->
                        <ul class="sidebar-nav" style="margin: 0px;padding: 0px;">
                            <!-- START user info-->
                            <li class="has-user-block">
                                <div class="" id="user-block">
                                    <div class="item user-block">
                                        <!-- User picture-->

                                        <div class="user-block-picture">

                                            <div class="user-block-status">
                                                <img class="img-thumbnail rounded-circle" src="{{(Auth::user()->image!=='' && @getimagesize(Auth::user()->image)) ?Auth::user()->image:asset('img/user.png')}}" alt="Avatar" width="60" height="60">
                                                <div class="circle bg-success circle-lg"></div>
                                            </div>

                                        </div><!-- Name and Job-->

                                        <div class="user-block-info"><span class="user-block-name">{{__('Hello')}}, {{__(Auth::user()->full_name)}}</span></div>

                                        <!-- <a href="">
                                        <div class="user-block-info"><a href="{{route('changePassword')}}"> <span class="fa fa-lock">  </span> &nbsp;Change Password </a></div>
                                    </a> -->
                                    </div>
                                </div>
                            </li><!-- END user info-->
                            @include('sidebar')

                        </ul><!-- END sidebar nav-->
                    </nav>
                </div><!-- END Sidebar (left)-->
            </aside><!-- offsidebar-->

            @yield('content')
            <footer class="footer-container"><span>&copy; 2020 - Paradox</span></footer>

        </div>
        <!-- =============== VENDOR SCRIPTS ===============-->
        <script>
            (function() {
            'use strict';
                    $(initDatatables);
                    function initDatatables() {

                    if (!$.fn.DataTable) return;
                            //Zero configuration

                            $('#datatable1').DataTable({

                    'paging': true, // Table pagination
                            'ordering': true, // Column ordering
                            'info': true, // Bottom left status text
                            'stateSave': true,
                            "aLengthMenu": [[10, 25, 50, - 1], [10, 25, 50, "All"]],
                            responsive: false,
                            // Text translation options
                            // Note the required keywords between underscores (e.g _MENU_)

                            oLanguage: {
                            sEmptyTable: "{{__('Empty Data Dable')}}",
                                    sZeroRecords: "{{__('No records')}}",
                                    sSearch: '<em class="fas fa-search"></em>',
                                    sLengthMenu: '_MENU_ {{__("records per page")}}',
                                    sinfo: 'Showing page _PAGE_ of _PAGES_',
                                    zeroRecords: 'Nothing found - sorry',
                                    infoEmpty: 'No records available',
                                    infoFiltered: '(filtered from _MAX_ total records)',
                                    oPaginate: {
                                    sNext: '<em class="fa fa-caret-right"></em>',
                                            sPrevious: '<em class="fa fa-caret-left"></em>'
                                    }
                            },
                            dom: '<"pull-left ml-2"B><"pull-right mr-2"l>T<"pull-left"f>gtip',
                            buttons: [
                            { extend: 'excel', className: 'btn-info', title: 'XLS-File', text:'Export' }
                            ]
                    });
                            // Filter

                            $('#datatable2').DataTable({
                    'paging': true, // Table pagination
                            'ordering': true, // Column ordering
                            'info': true, // Bottom left status text
                            'stateSave': true,
                            "aLengthMenu": [[10, 25, 50, - 1], [10, 25, 50, "All"]],
                            responsive: true,
                            // Text translation options
                            // Note the required keywords between underscores (e.g _MENU_)
                            oLanguage: {
                            sSearch: 'Search all columns:',
                                    sLengthMenu: '_MENU_ records per page',
                                    info: 'Showing page _PAGE_ of _PAGES_',
                                    zeroRecords: 'Nothing found - sorry',
                                    infoEmpty: 'No records available',
                                    infoFiltered: '(filtered from _MAX_ total records)',
                                    oPaginate: {
                                    sNext: '<em class="fa fa-caret-right"></em>',
                                            sPrevious: '<em class="fa fa-caret-left"></em>'
                                    }
                            },
                            // Datatable Buttons setup
                            dom: 'Bfrtip',
                            buttons: [
                            { extend: 'copy', className: 'btn-info' },
                            { extend: 'csv', className: 'btn-info' },
                            { extend: 'excel', className: 'btn-info', title: 'XLS-File' },
                            { extend: 'pdf', className: 'btn-info', title: $('title').text() },
                            { extend: 'print', className: 'btn-info' }
                            ]
                    });
                            $('#datatable3').DataTable({
                    'paging': true, // Table pagination
                            'ordering': true, // Column ordering
                            'info': true, // Bottom left status text
                            'stateSave': true,
                            "aLengthMenu": [[10, 25, 50, - 1], [10, 25, 50, "All"]],
                            responsive: true,
                            // Text translation options
                            // Note the required keywords between underscores (e.g _MENU_)
                            oLanguage: {
                            sSearch: 'Search all columns:',
                                    sLengthMenu: '_MENU_ records per page',
                                    info: 'Showing page _PAGE_ of _PAGES_',
                                    zeroRecords: 'Nothing found - sorry',
                                    infoEmpty: 'No records available',
                                    infoFiltered: '(filtered from _MAX_ total records)',
                                    oPaginate: {
                                    sNext: '<em class="fa fa-caret-right"></em>',
                                            sPrevious: '<em class="fa fa-caret-left"></em>'
                                    }
                            },
                            // Datatable key setup
                            keys: true
                    });
                    }

            })();
                    @if (Session::has('message'))
            (function () {
                'use strict';

                $(initCustom);
                function initCustom() {

                    // custom code
                    $.notify("{{ session('message') }}", {"status": "{{ session('class') }}"});
                }

            })();
            @endif
        </script>

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
        <script src="{{ asset('dist/js/dropify.min.js')}}"></script>
        <script src="{{ asset('vendor/sweetalert/dist/sweetalert.min.js')}}"></script>
        <!-- RTL -->
        <script src="{{ asset('vendor/select2/dist/js/select2.full.js')}}"></script>

        <link rel="stylesheet" href="{{ asset('css/custom.css')}}">



        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
        <script src="{{ asset('js/custom.js')}}"></script>
        <!-- nestable-->
        <script src="{{ asset('vendor/html5sortable/dist/html5sortable.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>

        <script src="{{asset('icon/js/iconPicker.min.js')}}"></script>
        <script src="{{asset('vendor/ckeditor/ckeditor.js')}}"></script>
        <script src="{{asset('vendor/ckeditor/config.js')}}"></script>

        <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>

        @if(!empty($link))
        <script>
            //var parentCollapse = $('.{{$page_title}}').parents('#{{$page_title}}Collapse').find('.{{$page_title}}Collapse');
            //parentCollapse.trigger('click');
            $('.{{$link}}').addClass('active');

        </script>
        @endif
        <script>
            $(document).ready(function () {
                // Basic
                $('.dropify').dropify();


            });
        </script>
        @if(Session::has('addManagerType'))
        <script>
            //alert('hlo');
            $(".bb1").trigger("click");
        </script>
        @endif
        <script>

            function goBack() {
                window.history.back();
            }

            $('#editRow').on('click', function ()
            {
                $('#editRowData').show();
            });
            $('#editScreenText').on('click', function ()
            {
                $('#editScreenData').show();
            });

            $('#editMessageText').on('click', function ()
            {
                $('#editMessageData').show();
            });

            $('#editTemplateText').on('click', function ()
            {
                $('#editTemplateData').show();
            });
        </script>


        <script type="text/javascript">
            $(function () {
                $(".icon-picker").iconPicker();
            });
        </script>

        <script>
            $('#summernote').summernote({
                placeholder: 'Describe here',
                tabsize: 2,
                height: 100
            });
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();


        </script>
        <script src="{{ asset('vendor/parsleyjs/dist/parsley.js')}}"></script>
        <!--- RTL Mode  Code--->

        <script>
            function selectFileWithCKFinder(elementId, imageId) {

                CKFinder.modal({
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function (finder) {
                        finder.on('files:choose', function (evt) {
                            var file = evt.data.files.first();
                            var output = document.getElementById(elementId);
                            output.value = file.getUrl();
                            //var image = document.getElementById( imageId );

                            $('#' + imageId).attr("src", output.value);
                        });

                        finder.on('file:choose:resizedImage', function (evt) {
                            var output = document.getElementById(elementId);
                            output.value = evt.data.resizedUrl;
                        });
                    }
                });
            }
        </script>

        @yield('modals')

        @yield('script')

    </body>
</html>
