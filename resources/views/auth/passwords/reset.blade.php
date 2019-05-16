@extends('layouts.outside')
@section('content')
    <div id="login" class="container-fluid">
        <div id="login-info" class="row justify-content-center text-center">
            <div class="col-lg-5">
                <img width="250" src="{{ asset('img/logo-w.png') }}">
                <h1>Восстановление доступа к аккаунту</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3">
                <form method="POST" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label>Электронная почта:</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                  @if ($errors->has('email'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                  @endif
                    </div>

                    <div class="form-group">
                        <label>Новый пароль:</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                              @if ($errors->has('password'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                    </div>

                    <div class="form-group">
                        <label>Повторите новый пароль:</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                    </div>

                    <button type="submit" class="btn btn-warning btn-lg btn-block">
                      Сбросить пароль

                    </button>
                </form>

            </div>


        </div>
    </div>
@endsection
