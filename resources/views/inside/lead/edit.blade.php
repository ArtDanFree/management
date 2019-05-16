@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Редактирование лида</b></h1>
        @can('update-lead-phone')
            <form method="POST" action="{{ route('lead.update', $lead->id) }}">
                @csrf
                {{ method_field('put') }}
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Телефон: </label>
                        <input name="phone" value="{{ $lead->phone }}" type="text"
                               class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>

                </div>
            </form>

        @elsecan('lead')
            <form method="POST" action="{{ route('lead.update', $lead->id) }}">
                @csrf
                {{ method_field('put') }}
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>Имя</label>
                        <input name="first_name" value="{{ $lead->first_name }}" type="text"
                               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('first_name'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Фамилия</label>
                        <input name="last_name" value="{{ $lead->last_name }}" type="text"
                               class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}">
                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Отчество</label>
                        <input name="surname" value="{{ $lead->surname }}" type="text"
                               class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}">
                        @if ($errors->has('surname'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('surname') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>Желаемая сумма: </label>
                        <input name="money" value="{{ $lead->money }}" type="text"
                               class="form-control{{ $errors->has('money') ? ' is-invalid' : '' }}">
                        @if ($errors->has('money'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('money') }}</strong>
                    </span>
                        @endif
                    </div>
                    <div class="col-lg-6 form-group" >
                        <label>Телефон: </label>
                        <input name="phone" value="{{ $lead->phone }}" type="text"
                               class="phone form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>

                </div>
            </form>

        @endcan
    </div>
@endsection
