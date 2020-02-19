@include('layouts.header')
<body class="animsition">
<div class="page-wrapper" style="overflow: scroll">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="{{ URL::asset('SOFIA.png')}}" style="width: 150px" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Nombre</label>
                                <input class="au-input au-input--full" required autofocus type="text" value="{{ old('name') }}" name="name" placeholder="Nombre">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Email Address</label>
                                <input class="au-input au-input--full" type="email" name="email" value="{{ old('email') }}" required placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Contrasena</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Confirmar Contrasena</label>
                                <input class="au-input au-input--full" type="password" name="password_confirmation" placeholder="Password" required>
                            </div>

                            <div class="login-checkbox">
                                <label>
                                    <input type="checkbox" name="aggree">Agree the terms and policy
                                </label>
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit" style="background: #0062cc">Registrar</button>
                        </form>
                        <div class="register-link">
                            <p>
                                <a href="#"></a>
                            </p>
                        </div>
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
