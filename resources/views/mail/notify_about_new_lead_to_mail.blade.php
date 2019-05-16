<div style="margin: 25px auto 0 auto; width: 90%; text-align: center">
    <div style="background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 5px; padding-bottom: 25px; margin: 0 auto">
        <img style="margin: 20px auto 0 auto" src="{{ asset('img/logo.png') }}" alt="" class="">
        <div style="margin-top: 5px">
            <h5 style="font-size: 18px">Добавлен новый лид</h5>
            <p>
                <br>
                Город: . {{ $lead->city->name }}
                <br>
                Тип залога: {{ $lead->typeDeposit->name }}
                <br>
                Сумма: {{ $lead->money }} руб.
            </p>
        </div>
        <a style="margin: 25px auto 0 auto;background-color: #28a745; color: #fff; text-decoration: none; display: block; width: 150px; padding: 10px 0 10px 0; border-radius: 5px"
           href="{{ Route('home', ['lead_id' => $lead->id]) }}" role="button">
            Взять на проверку
        </a>
    </div>
</div>
