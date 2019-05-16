@extends('layouts.outside')
@section('content')
    <div id="login" class="container-fluid">
        <div id="login-info" class="row justify-content-center text-center">
            <div class="col-lg-5">
                <img src="{{ asset('img/logo-w.png') }}">
                <h1>Вход в личный кабинет</h1>
                <h2>Введите регистрационные данные для входа в личный кабинет</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>Электронная почта:</label>
                        <input name="email" value="{{ old('email') }}" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               placeholder="Введите электронную почту">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Пароль:</label>
                        <input name="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               placeholder="Введите пароль">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <input id="timezone" name="timezone" type="text" style="display: none;">
                    <script type="text/javascript">
                      var tz = new Date().getTimezoneOffset()/60;
                      document.getElementById('timezone').value = tz;
                    </script>

                    <div style="padding-left: 0px" class="form-check">
                        <label>
                            <input id="remember-me" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Запомнить меня
                        </label>

                    </div>
                    <button type="submit" class="btn btn-warning btn-lg btn-block">Войти</button>
                    <div style="margin-top: 15px" class="text-center">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Восстановить пароль
                        </a>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
