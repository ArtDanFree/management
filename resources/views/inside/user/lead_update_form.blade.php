<form method="POST" action="{{ route('user.update', $user->id) }}">
    @csrf
    {{ method_field('put') }}
<div class="row">
    <div class="col-lg-6 form-group">
        <label>Фамилия:</label>
        <input name="last_name" value="{{ old('last_name') ?: $user->last_name }}" type="text"
               class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Введите Фамилию">
        @if ($errors->has('last_name'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        <label>Имя:</label>
        <input name="first_name" value="{{ old('first_name') ?: $user->first_name }}" type="text"
               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="Введите Имя">
        @if ($errors->has('first_name'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
        @endif
    </div>

    <div class="col-lg-6 form-group">
        <label>Отчество:</label>
        <input name="surname" value="{{ old('surname') ?: $user->surname }}" type="text"
               class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="Введите Отчество">
        @if ($errors->has('surname'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('surname') }}</strong>
                    </span>
        @endif
    </div>
    
    <div class="col-lg-6 form-group">
        <label>Лицевой или расчетный счет:</label>
        <input name="personal_acc" value="{{ old('personal_acc') ?: $user->personal_acc }}" type="text"
               class="form-control{{ $errors->has('personal_acc') ? ' is-invalid' : '' }}" placeholder="Введите лицевой или расчетный счет">
        @if ($errors->has('personal_acc'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('personal_acc') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        <label>Номер банковской карты:</label>
        <input name="credit_card_number" value="{{ old('credit_card_number') ?: $user->credit_card_number }}" type="text"
               class="form-control{{ $errors->has('credit_card_number') ? ' is-invalid' : '' }}" placeholder="Введите номер банковской карты">
        @if ($errors->has('credit_card_number'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('credit_card_number') }}</strong>
                    </span>
        @endif
    </div>

    <div class="col-lg-6 form-group">
        <label>Корр. сч.</label>
        <input name="correspondent_acc" value="{{ old('correspondent_acc') ?: $user->correspondent_acc }}" type="text"
               class="form-control{{ $errors->has('correspondent_acc') ? ' is-invalid' : '' }}" placeholder="Введите Корр. сч.">
        @if ($errors->has('correspondent_acc'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('correspondent_acc') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        <label>Организация:</label>
        <input name="organization" value="{{ old('organization') ?: $user->organization }}" type="text"
               class="form-control{{ $errors->has('organization') ? ' is-invalid' : '' }}" placeholder="Введите название организации">
        @if ($errors->has('organization'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('organization') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        <label>БИК банка:</label>
        <input name="bic_bank" value="{{ old('bic_bank') ?: $user->bic_bank }}" type="text"
               class="form-control{{ $errors->has('bic_bank') ? ' is-invalid' : '' }}" placeholder="Введите БИК банка">
        @if ($errors->has('bic_bank'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('bic_bank') }}</strong>
                    </span>
        @endif
    </div>
    <div class="col-lg-6 form-group">
        <label>Наименование банка:</label>
        <input name="name_bank" value="{{ old('name_bank') ?: $user->name_bank }}" type="text"
               class="form-control{{ $errors->has('name_bank') ? ' is-invalid' : '' }}" placeholder="Введите наименование банка">
        @if ($errors->has('name_bank'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name_bank') }}</strong>
                    </span>
        @endif
    </div>
    {{--<div class="col-lg-6 form-group">
        <label>Стоимость лидов:</label>
        <input name="leads_cost" value="{{ old('leads_cost') ?: $user->leads_cost }}" type="text"
               class="form-control{{ $errors->has('leads_cost') ? ' is-invalid' : '' }}" placeholder="Введите стоимость лидов">
        @if ($errors->has('leads_cost'))
            <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('leads_cost') }}</strong>
                    </span>
        @endif
    </div>--}}
</div>
    <div class="row justify-content-center">
        <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>
    </div>
</form>
