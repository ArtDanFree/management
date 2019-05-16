@extends('layouts.outside')
@section('content')
    <div id="login" class="container-fluid">
        <div id="login-info" class="row justify-content-center text-center">
            <div class="col-lg-5">
                <img width="250" src="{{ asset('img/logo-w.png') }}">
                <h1>Регистрация</h1>
                <h2>Введите регистрационные данные и дождитесь письма-подтверждения регистрации</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input name="email" value="{{ Request::get('email') }}"  hidden>

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
                    <div class="form-group">
                        <label>Подтвердите пароль:</label>
                        <input name="password_confirmation" type="password"
                               class="form-control"
                               placeholder="Повторите ввод пароля">
                    </div>

                    <div class="form-group">
                        <input name="code" type="text" value="{{ Request::get('code') }}" hidden>
                    </div>

                    <div id="personal-information" class="form-check">
                        <label>
                            <input id="remember-me" type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}>
                            даю согласие на обработку <a style="color: #007bff" href="{{ Route('personal_data_processing') }}" target="_blank">персональных данных</a>
                        </label>
                    </div>


                    <button type="submit" class="btn btn-warning btn-lg btn-block">Зарегистрироваться</button>

                </form>

            </div>

        </div>
    </div>
@endsection
