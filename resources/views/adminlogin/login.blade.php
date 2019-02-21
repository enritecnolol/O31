<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADGPOS | Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link href="{{ URL::asset('notificaciones/toastr.css')}}" rel="stylesheet" media="all">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('Loginv2/css/main.css') }}">
    <!--===============================================================================================-->
</head>
<body>

<div id="Vue">
    <loginv2></loginv2>
</div>

<!--===============================================================================================-->
<script src="{{ URL::asset('Loginv2/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ URL::asset('Loginv2/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ URL::asset('Loginv2/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ URL::asset('Loginv2/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ URL::asset('Loginv2/vendor/tilt/tilt.jquery.min.js') }}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!--===============================================================================================-->
<script src="{{ URL::asset('Loginv2/js/main.js') }}"></script>
<script src="/js/app.js"></script>
</body>
</html>