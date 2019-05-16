@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Сменить почту</b></h1>
        <form method="POST" action="{{ Route('change_email') }}">
            @csrf
            {{ method_field('put') }}
            <div class="row">
                <div class="col-lg-12 form-group">
                    <label>Новая почта</label>
                    <input name="new_email" type="email"
                           class="form-control{{ $errors->has('new_email') ? ' is-invalid' : '' }}"
                           placeholder="Введите новую почту">
                    @if ($errors->has('new_email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-lg-12 form-group">
                    <label>Подтвердите новую почту:</label>
                    <input name="new_email_confirmation" type="email"
                           class="form-control"
                           placeholder="Подтвердите новую почту">
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>

            </div>
        </form>
    </div>
@endsection
