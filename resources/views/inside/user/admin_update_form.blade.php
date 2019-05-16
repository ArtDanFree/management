<form method="POST" action="{{ route('user.update', $user->id) }}">
    @csrf
    {{ method_field('put') }}
    <div class="row">
        <div class="col-lg-6 form-group">
            <label>Имя:</label>
            <input name="first_name" value="{{ $user->first_name }}" type="text"
                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" placeholder="Введите Имя">
            @if ($errors->has('first_name'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
            @endif
        </div>
        <div class="col-lg-6 form-group">
            <label>Фамилия:</label>
            <input name="last_name" value="{{ $user->last_name }}" type="text"
                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" placeholder="Введите Фамилию">
            @if ($errors->has('last_name'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
            @endif
        </div>
        <div class="col-lg-6 form-group">
            <label>Отчество:</label>
            <input name="surname" value="{{ $user->surname }}" type="text"
                   class="form-control{{ $errors->has('surname') ? ' is-invalid' : '' }}" placeholder="Введите Отчество">
            @if ($errors->has('surname'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('surname') }}</strong>
                    </span>
            @endif
        </div>
         @can('telegram')
        <div class="col-lg-6 form-group">
            <label>Телеграм:</label>
            <input name="telegram" value="{{ $user->telegram }}" type="text"
                   class="form-control{{ $errors->has('telegram') ? ' is-invalid' : '' }}" placeholder="Введите Telegram ID">
            @if ($errors->has('telegram'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('telegram') }}</strong>
                    </span>
            @endif
        </div>
        @endcan
    </div>
    <div class="row justify-content-center">
        <button type="submit" class="col-lg-3 text-center btn btn-warning ">Сохранить</button>

    </div>
</form>
@can('notification')
<div class="col-lg-6">
    <label>Получать уведомления в<br></label>
    <div class="row container">
        @foreach($user->notification as $notification)
        @can(mb_strtolower($notification->name))
        @if(!! $notification->pivot->confirmed == false)
                <div style="margin-right: 7px">
                    <form action="{{ Route('toggle_notification', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $notification->id }}" name="notification_id" type="text" hidden>
                        <input value="1" name="confirmed" type="text" hidden>
                        <button class="btn btn-lg btn-outline-success">{{ $notification->name }}</button>
                    </form>
                </div>


            @else
                <div style="margin-right: 7px">
                    <form action="{{ Route('toggle_notification', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="{{ $notification->id }}" name="notification_id" type="text" hidden>
                        <input value="0" name="confirmed" type="text" hidden>
                        <button class="btn btn-lg btn-success">{{ $notification->name }}</button>
                    </form>
                </div>
            @endif
            @endcan
        @endforeach
    </div>
</div>
@endcan
