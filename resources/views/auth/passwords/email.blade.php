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
                <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}" style="margin-bottom: 200px;">
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

                    <button type="submit" class="btn btn-warning btn-lg btn-block" >
                      Сбросить пароль

                    </button>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                    </div>
                    @endif
                </form>

            </div>


        </div>
    </div>
@endsection
