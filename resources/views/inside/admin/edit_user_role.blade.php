@extends('layouts.inside')
@section('content')
    <div class="container main-content">{{}}
        <h1><b>Редактирование личных данных</b></h1>
        <form method="POST" action="{{ Route('admin_user_update', $user) }}">
            @csrf
            {{ method_field('put') }}
            <div class="row">
                <div class="col-lg-4 form-group">
                    <label>ФИО</label>
                    <input value="{{ $user->first_name . ' ' . $user->last_name . ' ' . $user->surname}}" type="text" disabled class="form-control">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Роль</label>
                    <input value="{{ $user->role->name ?: ''}}" type="text" disabled class="form-control">
                </div>
                <div class="col-lg-4 form-group">
                    <label>Комисия</label>
                    <input name="commission" value="{{ $user->commission }}" type="text"
                           class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}">
                    @if ($errors->has('commission'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('commission') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row justify-content-around">
                <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>
                @can('change-role')
                <button type="submit" class="col-lg-3 text-center btn btn-warning ">Изменить Роль</button>
                    @endcan

            </div>
        </form>
    </div>
@endsection
