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
<div class="page-wrapper" id="app">
    <!-- HEADER MOBILE-->
    {{--<header class="header-mobile d-block d-lg-none">--}}
        {{--<div class="header-mobile__bar">--}}
            {{--<div class="container-fluid">--}}
                {{--<div class="header-mobile-inner">--}}
                    {{--<a class="logo" href="index.html">--}}
                        {{--<img src="images/icon/logo.png" alt="CoolAdmin" />--}}
                    {{--</a>--}}
                    {{--<button class="hamburger hamburger--slider" type="button">--}}
                            {{--<span class="hamburger-box">--}}
                                {{--<span class="hamburger-inner"></span>--}}
                            {{--</span>--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<nav class="navbar-mobile">--}}
            {{--<div class="container-fluid">--}}
                {{--<ul class="navbar-mobile__list list-unstyled">--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-tachometer-alt"></i>Dashboard</a>--}}
                        {{--<ul class="navbar-mobile-sub__list list-unstyled js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="index.html">Dashboard 1</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index2.html">Dashboard 2</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index3.html">Dashboard 3</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index4.html">Dashboard 4</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="chart.html">--}}
                            {{--<i class="fas fa-chart-bar"></i>Charts</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="table.html">--}}
                            {{--<i class="fas fa-table"></i>Tables</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="form.html">--}}
                            {{--<i class="far fa-check-square"></i>Forms</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<i class="fas fa-calendar-alt"></i>Calendar</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="map.html">--}}
                            {{--<i class="fas fa-map-marker-alt"></i>Maps</a>--}}
                    {{--</li>--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-copy"></i>Pages</a>--}}
                        {{--<ul class="navbar-mobile-sub__list list-unstyled js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="login.html">Login</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="register.html">Register</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="forget-pass.html">Forget Password</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-desktop"></i>UI Elements</a>--}}
                        {{--<ul class="navbar-mobile-sub__list list-unstyled js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="button.html">Button</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="badge.html">Badges</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="tab.html">Tabs</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="card.html">Cards</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="alert.html">Alerts</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="progress-bar.html">Progress Bars</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="modal.html">Modals</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="switch.html">Switchs</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="grid.html">Grids</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="fontawesome.html">Fontawesome Icon</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="typo.html">Typography</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</nav>--}}
    {{--</header>--}}
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
                {{--<aside class="menu-sidebar2 d-none d-lg-block" style="box-shadow: 1px 1px 6px #888888;">--}}
                <div class="logo">
                    <a href="/dashboard">
                        <span style="color: white; font-size: x-large"> <span style="font-weight: 600">ADG</span>POS</span>
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
