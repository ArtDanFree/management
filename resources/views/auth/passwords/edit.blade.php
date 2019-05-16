@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Сменить пароль</b></h1>
        <form method="POST" action="{{ Route('change_password') }}">
            @csrf
            {{ method_field('put') }}
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label>Старый пароль:</label>
                    <input name="old_password" type="password"
                           class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
                           placeholder="Введите старый пароль">
                    @if ($errors->has('old_password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-lg-12 form-group">
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
                <div class="col-lg-12 form-group">
                    <label>Подтвердите пароль:</label>
                    <input name="password_confirmation" type="password"
                           class="form-control"
                           placeholder="Повторите ввод пароля">
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>

            </div>
        </form>
    </div>
@endsection
