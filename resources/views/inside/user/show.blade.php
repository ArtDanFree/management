@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Личные данные</b></h1>
      <p>Текущее время: {{$time->timezone(session('timezone'))->format('H:i:s')}} (UTC <span id="tz"> </span>) <a href="#" data-toggle="modal" data-target="#timezone-modal">Неверно?</a> </p>
      <script type="text/javascript">
        var tz = new Date().getTimezoneOffset()/60;
        if(tz<0){tz= '+'+(-tz);}else{tz = -tz;}
        document.getElementById('tz').innerHTML = tz;
      </script>
        @if($user->role->name == 'Лидогенератор')
            @include('inside.user.lead_show')
        @else
            @include('inside.user.admin_show')
        @endif
        @if(Auth::user()->id == $user->id)
            <div class="row justify-content-center" style="margin-top: 44px">
                <a class=" col-lg-3 btn btn-warning btn-lg" href="{{ Route('user.edit', $user) }}">Редактировать</a>
            </div>
            <div class="row justify-content-center" style="margin-top: 15px">
                <a class=" col-lg-3 btn btn-warning btn-lg" href="{{ Route('edit_change_password', $user) }}">Сменить пароль</a>
            </div>
            <div class="row justify-content-center" style="margin-top: 15px">
                <a class=" col-lg-3 btn btn-warning btn-lg" href="{{ Route('edit_change_email', $user) }}">Сменить почту</a>
            </div>
            @endif
        @can('underwriter')
            <div class="row justify-content-center" style="margin-top: 15px">
                <a class=" col-lg-3 btn btn-warning btn-lg" href="{{ Route('cities_list', $user) }}">Список городов</a>
            </div>
        @endcan
        @can('admin')
            @if($user->role->name == 'Частный инвестор')
            <div style="margin-top: 10px">
                <label>Подписан на уведомления в </label>
                <div class="row container">
                    @foreach($user->notification as $notification)
                        @if(!! $notification->pivot->confirmed == false)
                            <div style="margin-right: 7px">
                                <button class="btn btn-lg btn-outline-success">{{ $notification->name }}</button>
                            </div>
                        @else
                            <div style="margin-right: 7px">
                                <button class="btn btn-lg btn-success">{{ $notification->name }}</button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
                @endif
        @endcan
    </div>
    <!-- Modal Timezone -->
    <div class="modal fade" id="timezone-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Настройка часового пояса</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <p align="center">Если время на сайте отображается неверно, то измените часовой пояс в настройках Вашего устройства и заново выполните вход в лид-маркет.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
