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
    <title>Report Print</title>
    <link rel="icon" href="{{ URL::asset('logo2.png') }}" type="image/png">
    <!-- Bootstrap CSS-->
    <link href="{{ URL::asset('bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ URL::asset('animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ URL::asset('wow/animate.css')}}" rel="stylesheet" media="all">
    <!-- Main CSS-->
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
<div class="page-wrapper">
    <div id="Vue">
        <print-report-ventas />
    </div>
</div>
</div>

@include('layouts.scripts')
@yield('scriptp')
<script src="/js/app.js"></script>
</body>
</html>
<!-- end document-->
