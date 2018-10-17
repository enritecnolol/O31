<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
    {{--<meta name="description" content="au theme template">--}}
    {{--<meta name="author" content="Hau Nguyen">--}}
    {{--<meta name="keywords" content="au theme template">--}}
    <!-- Title Page-->
    <title>@yield('tittle')</title>

    <!-- Fontfaces CSS-->
    <link href=" {{ URL::asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('notificaciones/toastr.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('datepicker/css/datepicker.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ URL::asset('animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('slick/slick-theme.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('DataTables/datatables.min.css') }}"/>
    <!-- Main CSS-->
    <link href="{{ URL::asset('css/theme.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('teclado/jquery.numpad.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('teclado/keyboard.css')}}" rel="stylesheet" media="all">
    @yield('style')

</head>
<body class="animsition">
<div class="page-wrapper" id="app">
    <!-- HEADER MOBILE-->
    <!-- END HEADER MOBILE-->
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop2">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap">
                        <form class="form-header" action="" method="POST">
                            <div class="text-center">
                                @yield('titulo')
                            </div>
                        </form>
                        <div class="header-button">
                            <div class="account-wrap">
                                <div class="account-item clearfix js-item-menu">
                                    <div class="image">
                                        <img src="{{ URL::asset('imagenes/User.png')}}" alt="John Doe" />
                                    </div>
                                    <div class="content">
                                        <a class="js-acc-btn" href="#" style="color: white">Menu</a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="image">
                                                <a href="#">
                                                    <img src="{{ URL::asset('imagenes/User.png')}}" alt="usuario" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#">{{ Auth::user()->name }}</a>
                                                </h5>
                                                <span class="email">{{ Auth::user()->email }}</span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="/dashboard">
                                                    <i class="fas fa-chart-line"></i>Dashboard
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="/productos">
                                                    <i class="fas fa-utensils"></i>Productos
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="/">
                                                    <i class="fas fa-shopping-cart"></i>Vender
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="/categorias">
                                                    <i class="fas fa-clipboard-check"></i></i>Categorias
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="/caja">
                                                    <i class="zmdi zmdi-money-box"></i>Caja
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a id="#proximamente" href="#">
                                                    <i class="zmdi zmdi-settings"></i>Configuracion <span class="badge badge-info">Proximamente</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__footer">
                                            <a href="{{ route('logout') }}"onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <i class="zmdi zmdi-power"></i>Logout
                                            </a>
                                            {{--{{ Auth::user()->name }}--}}
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        @include('mantenimiento.proxima')
        <!-- HEADER DESKTOP-->
        <!-- MENU SIDEBAR-->
        <div id="Vue">
            <aside class="menu-sidebar2 d-none d-lg-block" style="background: url({{ URL::asset('fondo2.png')}});box-shadow: 1px 1px 6px #888888;">
                <div class="logo">
                    <a href="/">
                        <img style="width: 80px" src="{{ URL::asset('imagenes/logo.png')}}" alt="Logo" /> <span style="color: white; font-size: x-large">Cafeteria</span>
                    </a>
                </div>
                @yield('aside')
            </aside>
            <!-- END MENU SIDEBAR-->

            <!-- MAIN CONTENT-->
            <div class="main-content" style="background: url({{ URL::asset('fondo2.png')}});">
                <!--datos-->
                @yield('content')

            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>

@include('layouts.scripts')
@yield('scriptp')
<script !src="">
    $(document).on('click', '#proximamente', function() {
        $('#proxima').modal('show');
    });
</script>
</body>
</html>
<!-- end document-->
