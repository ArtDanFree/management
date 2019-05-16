<div style="margin: 25px auto 0 auto; width: 90%; text-align: center">
    <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 5px; padding-bottom: 25px; margin: 0 auto">
        <a href="{{ Route('home') }}">
            <img style="margin: 20px auto 0 auto" src="{{ asset('img/logo.png') }}" alt="" class="">
        </a>
        <div style="margin-top: 5px">
            <h5 style="font-size: 18px">Здравствуйте, {{ $user['first_name'] }}.
                <br>
                Для вашего аккаунты отключена отправка сообщений в телеграм по причине «{{ $reason }}»
            </h5>
        </div>
    </div>
</div>