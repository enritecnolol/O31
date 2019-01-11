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

    <!-- Fontfaces CSS-->
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

</head>

<body class="animsition">
<div class="page-wrapper">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop3 d-none d-lg-block" style="height:55px">
        <div class="section__content section__content--p35">
            <div class="header3-wrap">
                <div class="header__logo">
                    <a href="/dashboard">
                        <span style="color: white; font-size: x-large"> <span style="font-weight: 600">ADG</span>POS</span>
                    </a>
                </div>
                <div class="header__navbar">

                </div>
                <div class="header__tool">
                    <div class="account-wrap">
                        <div class="account-item account-item--style2 clearfix js-item-menu">

                            <div class="content">
                                <a class="js-acc-btn" href="#" style="color: white"><i class="fas fa-2x fa-bars"></i></a>
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
                                        <a id="" href="/configuracion">
                                            <i class="zmdi zmdi-settings"></i>Configuracion
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
    </header>
    <!-- END HEADER DESKTOP-->

    <!-- HEADER MOBILE-->
    <!-- END HEADER MOBILE -->

    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7" style="background: url('../../../../local/fondo6.png')" id="Vue">

        @yield('content')

        <section class="p-t-60 p-b-20" style="padding-top:20%">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Sistema diseñado por <a href="http://adgsystems.com.do/">ADGsystems</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END COPYRIGHT-->
    </div>
</div>

<!-- Jquery JS-->
@include('layouts.scripts')
@yield('scriptp')
<!-- Main JS-->
<script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>
<script src="/js/main.js"></script>

</body>

</html>
<!-- end document-->
