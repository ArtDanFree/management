<div style="margin: 25px auto 0 auto; width: 90%; text-align: center">
    <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 5px; padding-bottom: 25px; margin: 0 auto">
        <img style="margin: 20px auto 0 auto" src="{{ asset('img/logo.png') }}" alt="" class="">
        <div style="margin-top: 5px">
            <h5 style="font-size: 18px">Для восстановления пароля пройдите по ссылке </h5>
        </div>
        <a style="margin: 25px auto 0 auto;background-color: #28a745; color: #fff; text-decoration: none; display: block; width: 210px; padding: 10px 0 10px 0; border-radius: 5px"
           href="{{ Route('password.reset', $token) }}" role="button">
            Восстановить пароль
        </a>
    </div>
</div>
