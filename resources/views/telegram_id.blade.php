@extends('layouts.inside')
@section('content')
    <div class="container main-content">
        <h1><b>Как узнать Telegram ID ?</b></h1>
        <p>
            Добавьте в контакты бота @userinfobot, после чего он пришлет вам ваш id.<br>
            Укажите ваш id в <a href="{{ Route('user.show', Request::user()->id) }}">личных данных.</a>
        </p>
        <br>
        <p>
            Чтобы получать сообщения от нашего бота, добавьте его в контакты: {{ Config::get('constants.telegramBot') }}
        </p>
    </div>
@endsection