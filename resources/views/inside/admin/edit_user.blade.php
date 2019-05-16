@extends('layouts.inside')

@section('content')
    <div class="container main-content">
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
                    <label>Комиссия</label>
                    <input name="commission" value="{{ $user->commission }}" type="text"
                           class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}">
                    @if ($errors->has('commission'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('commission') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>
            </div>
        </form>
        <div style="margin-top: 15px" class="row justify-content-center">
            @can('change-role')
        <button class="col-lg-3 text-center btn btn-warning" data-toggle="modal" data-target="#update-user-role">Изменить Роль</button>
                @endcan
        </div>


    </div>
    @can('change-role')
        <!-- Modal change role -->
    <div class="modal fade" id="update-user-role" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Изменение роли</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin_user_role_update', $user->id) }}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="form-group">
                            <select name="role_id" class="form-control">
                                @foreach($roles as $role)

                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg btn-block">Изменить</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Add-lead -->
    @endcan
@endsection
