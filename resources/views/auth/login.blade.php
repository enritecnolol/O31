@include('layouts.header')
@section('tittle', 'SofiaRD | Login')
<body class="animsition">
<div class="page-wrapper">
    <div class="page-content--bge5" style="overflow: scroll">
        <div class="container" style="">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="{{ URL::asset('SOFIA.png')}}" style="width: 200px" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form class="" method="POST" action="/login">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Email</label>
                                <input value="{{ old('email') }}" required autofocus class="au-input au-input--full" type="email" name="email" placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Contraseña</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="login-checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Recordar
                                </label>
                                <label>

                                </label>
                            </div>
                            <button class="au-btn au-btn--block au-btn--blue m-b-20" type="submit">Iniciar Sesion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.scripts')

</body>

</html>
<!-- end document-->
