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
    <title>Dashboard 2</title>

    <!-- Fontfaces CSS-->
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
    <!-- MENU SIDEBAR-->
    <aside class="menu-sidebar2" style="width: 300px">
        <div class="logo">
            <a href="#">
                <img src="images/icon/logo-white.png" alt="Cool Admin" />
            </a>
        </div>
        <div class="menu-sidebar2__content js-scrollbar1">
            <div class="account2">
                <div class="image img-cir img-120">
                    <img src="{{ URL::asset('admin.png')}}" alt="John Doe" />
                </div>
                <h4 class="name">You are Admin</h4>
                {{--<a href="#">Sign out</a>--}}
            </div>
            <nav class="navbar-sidebar2">
                <ul class="list-unstyled navbar__list">
                    {{--<li class="active has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-tachometer-alt"></i>Dashboard--}}
                            {{--<span class="arrow">--}}
                                    {{--<i class="fas fa-angle-down"></i>--}}
                                {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="list-unstyled navbar__sub-list js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="index.html">--}}
                                    {{--<i class="fas fa-tachometer-alt"></i>Dashboard 1</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index2.html">--}}
                                    {{--<i class="fas fa-tachometer-alt"></i>Dashboard 2</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index3.html">--}}
                                    {{--<i class="fas fa-tachometer-alt"></i>Dashboard 3</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="index4.html">--}}
                                    {{--<i class="fas fa-tachometer-alt"></i>Dashboard 4</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="inbox.html">--}}
                            {{--<i class="fas fa-chart-bar"></i>Inbox</a>--}}
                        {{--<span class="inbox-num">3</span>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<a href="#">--}}
                            {{--<i class="fas fa-shopping-basket"></i>eCommerce</a>--}}
                    {{--</li>--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-trophy"></i>Features--}}
                            {{--<span class="arrow">--}}
                                    {{--<i class="fas fa-angle-down"></i>--}}
                                {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="list-unstyled navbar__sub-list js-sub-list">--}}
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
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-copy"></i>Pages--}}
                            {{--<span class="arrow">--}}
                                    {{--<i class="fas fa-angle-down"></i>--}}
                                {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="list-unstyled navbar__sub-list js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="login.html">--}}
                                    {{--<i class="fas fa-sign-in-alt"></i>Login</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="register.html">--}}
                                    {{--<i class="fas fa-user"></i>Register</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="forget-pass.html">--}}
                                    {{--<i class="fas fa-unlock-alt"></i>Forget Password</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="has-sub">--}}
                        {{--<a class="js-arrow" href="#">--}}
                            {{--<i class="fas fa-desktop"></i>UI Elements--}}
                            {{--<span class="arrow">--}}
                                    {{--<i class="fas fa-angle-down"></i>--}}
                                {{--</span>--}}
                        {{--</a>--}}
                        {{--<ul class="list-unstyled navbar__sub-list js-sub-list">--}}
                            {{--<li>--}}
                                {{--<a href="button.html">--}}
                                    {{--<i class="fab fa-flickr"></i>Button</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="badge.html">--}}
                                    {{--<i class="fas fa-comment-alt"></i>Badges</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="tab.html">--}}
                                    {{--<i class="far fa-window-maximize"></i>Tabs</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="card.html">--}}
                                    {{--<i class="far fa-id-card"></i>Cards</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="alert.html">--}}
                                    {{--<i class="far fa-bell"></i>Alerts</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="progress-bar.html">--}}
                                    {{--<i class="fas fa-tasks"></i>Progress Bars</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="modal.html">--}}
                                    {{--<i class="far fa-window-restore"></i>Modals</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="switch.html">--}}
                                    {{--<i class="fas fa-toggle-on"></i>Switchs</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="grid.html">--}}
                                    {{--<i class="fas fa-th-large"></i>Grids</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="fontawesome.html">--}}
                                    {{--<i class="fab fa-font-awesome"></i>FontAwesome</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="typo.html">--}}
                                    {{--<i class="fas fa-font"></i>Typography</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>
            </nav>
        </div>
    </aside>
    <!-- END MENU SIDEBAR-->

    <!-- PAGE CONTAINER-->
    <div class="page-container2">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop2" style="left: 300px">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="header-wrap2">
                        <div class="logo d-block d-lg-none">
                            <a href="#">
                                <img src="../../../public/admin.png" alt="CoolAdmin" />
                            </a>
                        </div>
                        <div class="header-button2">
                            <div class="header-button-item js-item-menu">
                                <i class="zmdi zmdi-search"></i>
                                <div class="search-dropdown js-dropdown">
                                    <form action="">
                                        <input class="au-input au-input--full au-input--h65" type="text" placeholder="Search for datas &amp; reports..." />
                                        <span class="search-dropdown__icon">
                                                <i class="zmdi zmdi-search"></i>
                                            </span>
                                    </form>
                                </div>
                            </div>
                            <div class="header-button-item has-noti js-item-menu">
                                <i class="zmdi zmdi-notifications"></i>
                                <div class="notifi-dropdown js-dropdown">
                                    <div class="notifi__title">
                                        <p>You have 3 Notifications</p>
                                    </div>
                                    <div class="notifi__item">
                                        <div class="bg-c1 img-cir img-40">
                                            <i class="zmdi zmdi-email-open"></i>
                                        </div>
                                        <div class="content">
                                            <p>You got a email notification</p>
                                            <span class="date">April 12, 2018 06:50</span>
                                        </div>
                                    </div>
                                    <div class="notifi__item">
                                        <div class="bg-c2 img-cir img-40">
                                            <i class="zmdi zmdi-account-box"></i>
                                        </div>
                                        <div class="content">
                                            <p>Your account has been blocked</p>
                                            <span class="date">April 12, 2018 06:50</span>
                                        </div>
                                    </div>
                                    <div class="notifi__item">
                                        <div class="bg-c3 img-cir img-40">
                                            <i class="zmdi zmdi-file-text"></i>
                                        </div>
                                        <div class="content">
                                            <p>You got a new file</p>
                                            <span class="date">April 12, 2018 06:50</span>
                                        </div>
                                    </div>
                                    <div class="notifi__footer">
                                        <a href="#">All notifications</a>
                                    </div>
                                </div>
                            </div>
                            <div class="header-button-item mr-0 js-sidebar-btn">
                                <a href="{{ route('logout') }}"onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="zmdi zmdi-power"></i>Logout
                                </a>
                                {{--{{ Auth::user()->name }}--}}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                            <div class="setting-menu js-right-sidebar d-none d-lg-block">
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-globe"></i>Language</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-pin"></i>Location</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-email"></i>Email</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-notifications"></i>Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
            <div class="logo">
                <a href="#">
                    <img src="../../../public/admin.png" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar2__content js-scrollbar2">
                <div class="account2">
                    <div class="image img-cir img-120">
                        <img src="../../../public/admin.png" alt="" />
                    </div>
                    <h4 class="name">john doe</h4>
                    <a href="#">Sign out</a>
                </div>
                <nav class="navbar-sidebar2">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard
                                <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="index.html">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">
                                        <i class="fas fa-tachometer-alt"></i>Dashboard 4</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="inbox.html">
                                <i class="fas fa-chart-bar"></i>Inbox</a>
                            <span class="inbox-num">3</span>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fas fa-shopping-basket"></i>eCommerce</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-trophy"></i>Features
                                <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="table.html">
                                        <i class="fas fa-table"></i>Tables</a>
                                </li>
                                <li>
                                    <a href="form.html">
                                        <i class="far fa-check-square"></i>Forms</a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fas fa-calendar-alt"></i>Calendar</a>
                                </li>
                                <li>
                                    <a href="map.html">
                                        <i class="fas fa-map-marker-alt"></i>Maps</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-copy"></i>Pages
                                <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="login.html">
                                        <i class="fas fa-sign-in-alt"></i>Login</a>
                                </li>
                                <li>
                                    <a href="register.html">
                                        <i class="fas fa-user"></i>Register</a>
                                </li>
                                <li>
                                    <a href="forget-pass.html">
                                        <i class="fas fa-unlock-alt"></i>Forget Password</a>
                                </li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements
                                <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                            </a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="button.html">
                                        <i class="fab fa-flickr"></i>Button</a>
                                </li>
                                <li>
                                    <a href="badge.html">
                                        <i class="fas fa-comment-alt"></i>Badges</a>
                                </li>
                                <li>
                                    <a href="tab.html">
                                        <i class="far fa-window-maximize"></i>Tabs</a>
                                </li>
                                <li>
                                    <a href="card.html">
                                        <i class="far fa-id-card"></i>Cards</a>
                                </li>
                                <li>
                                    <a href="alert.html">
                                        <i class="far fa-bell"></i>Alerts</a>
                                </li>
                                <li>
                                    <a href="progress-bar.html">
                                        <i class="fas fa-tasks"></i>Progress Bars</a>
                                </li>
                                <li>
                                    <a href="modal.html">
                                        <i class="far fa-window-restore"></i>Modals</a>
                                </li>
                                <li>
                                    <a href="switch.html">
                                        <i class="fas fa-toggle-on"></i>Switchs</a>
                                </li>
                                <li>
                                    <a href="grid.html">
                                        <i class="fas fa-th-large"></i>Grids</a>
                                </li>
                                <li>
                                    <a href="fontawesome.html">
                                        <i class="fab fa-font-awesome"></i>FontAwesome</a>
                                </li>
                                <li>
                                    <a href="typo.html">
                                        <i class="fas fa-font"></i>Typography</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END HEADER DESKTOP-->

        <!-- BREADCRUMB-->
        <section class="au-breadcrumb m-t-75">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="au-breadcrumb-content">
                                <div class="au-breadcrumb-left">
                                    <span class="au-breadcrumb-span">You are here:</span>
                                    <ul class="list-unstyled list-inline au-breadcrumb__list">
                                        <li class="list-inline-item active">
                                            <a href="#">Home</a>
                                        </li>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
                                        <li class="list-inline-item">Dashboard</li>
                                    </ul>
                                </div>
                                {{--<button class="au-btn au-btn-icon au-btn--green">--}}
                                    {{--<i class="zmdi zmdi-plus"></i>add item</button>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div id="Vue">
                @yield('content')
            </div>
        </section>

        <section style="">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="copyright">
                            <p>Copyright © 2018 Colorlib. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END PAGE CONTAINER-->
    </div>

</div>

@include('layouts.scripts')
@yield('scriptp')
<!-- Main JS-->
<script src="js/main.js"></script>

</body>

</html>
<!-- end document-->