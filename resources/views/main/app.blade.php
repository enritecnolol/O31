<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="au theme template">
<meta name="author" content="Hau Nguyen">
<meta name="keywords" content="au theme template">
<!-- Title Page-->
    <title>@yield('tittle')</title>
    <link rel="icon" href="{{ URL::asset('logo2.png') }}" type="image/png">

    <!-- Fontfaces CSS-->
    <link href="{{ URL::asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('notificaciones/toastr.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('datepicker/css/datepicker.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- Vendor CSS-->
    <link href="{{ URL::asset('animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('slick/slick-theme.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('pagination/pagination.css')}}" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('DataTables/datatables.min.css') }}"/>
    <!-- Main CSS-->
    <link href="{{ URL::asset('css/theme.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('teclado/jquery.numpad.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('teclado/keyboard.css')}}" rel="stylesheet" media="all">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }


        .fondo {
            background: url({{ URL::asset('fondo2.png')}});
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;

        }
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    @yield('style')

</head>
<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER MOBILE-->
    <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
            <div class="container-fluid">
                <div class="header-mobile-inner">
                    <a href="/dashboard">
                        <span style="color: #0062cc; font-size: x-large"> <span style="font-weight: 600">ADG</span>POS</span>
                    </a>
                    <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                    </button>
                </div>
            </div>
        </div>
        <nav class="navbar-mobile">
            <div class="container-fluid">
                <ul class="navbar-mobile__list list-unstyled">
                    <li>
                        <a href="/dashboard">
                            <i class="fas fa-chart-line"></i><strong>DASHBOARD</strong></a>
                    </li>
                    <li>
                        <a href="/productos">
                            <i class="fas fa-utensils"></i><strong>PRODUCTOS</strong></a>
                    </li>
                    <li class="active has-sub">
                        <a class="js-arrow" href="#">
                            <i class="fas fa-box"></i><strong>CAJA</strong>
                        </a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list" style="display: none">
                            <li>
                                <a href="/caja">APERTURA DE CAJA</a>
                            </li>
                            <li>
                                <a href="/cierre/caja">CIERRE DE CAJAS</a>
                            </li>
                            <li>
                                <a href="/caja/ver/cuadre">CUADRES DE CAJAS</a>
                            </li>
                            <li>
                                <a href="/caja/cuadre">CUADRE DE CAJA</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/categorias">
                            <i class="fas fa-clipboard-check"></i><strong>CATEGORIAS</strong></a>
                    </li>
                    <li class="">
                        <a href="/caja/historico/ventas">
                            <i class="fas fa-book"></i><strong>VENTAS DEL DIA</strong></a>
                    </li>
                    <li class="">
                        <a href="/reportes">
                            <i class="fas fa-newspaper"></i><strong>REPORTE DE VENTAS</strong></a>
                    </li>
                    <li>
                        <a href="/clientes">
                            <i class="fas fa-users"></i><strong>CLIENTES</strong></a>
                    </li>
                    <li class="has-sub">
                        <a class="js-arrow" href="#">
                            <i class="zmdi zmdi-settings"></i><strong>CONFIGURACION</strong>
                        </a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list" style="display: none">
                            <li>
                                <a href="/configuracion">COMPANIA</a>
                            </li>
                            <li>
                                <a href="/configuracion/itbis">ITBIS</a>
                            </li>
                            <li>
                                <a href="/tipo/tarjeta">TARJETA PREFERENCIAL</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- END HEADER MOBILE-->
    <!-- PAGE CONTAINER-->
    @if(!request()->is('/'))
        <aside class="menu-sidebar2 d-none d-lg-block {{request()->is('/') ? '' : 'fondo' }}" style="box-shadow: 1px 1px 6px #888888;">
            {{--<aside class="menu-sidebar2 d-none d-lg-block" style="box-shadow: 1px 1px 6px #888888;">--}}
            <div class="logo">
                <a href="/dashboard">
                    <span style="color: white; font-size: x-large"> <span style="font-weight: 600">ADG</span>POS</span>
                </a>
            </div>
            @yield('aside')
        </aside>
    @endif
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
                                                <a href="/reportes">
                                                    <i class="fas fa-newspaper"></i>Reportes
                                                </a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="/clientes">
                                                    <i class="fas fa-users"></i>Clientes
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

            @if(request()->is('/'))
                <aside class="menu-sidebar2 d-none d-lg-block {{request()->is('/') ? '' : 'fondo' }}" style="box-shadow: 1px 1px 6px #888888;">
                    {{--<aside class="menu-sidebar2 d-none d-lg-block" style="box-shadow: 1px 1px 6px #888888;">--}}
                    <div class="logo">
                        <a href="/dashboard">
                            <span style="color: white; font-size: x-large"> <span style="font-weight: 600">ADG</span>POS</span>
                        </a>
                    </div>
                    @yield('aside')
                </aside>
            @endif

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
