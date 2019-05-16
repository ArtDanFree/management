<div style="margin-top: 20px" class="row">
    <div class="col-lg-6">
        <ul class="ul list-group">
            Имя:
            <li class="list-group-item">{{ $user->first_name ?: 'пусто' }}</li>
            Фамилия:
            <li class="list-group-item">{{ $user->last_name ?: 'пусто' }}</li>
            @can('telegram')
            Телеграм:
            <li class="list-group-item">{{ $user->telegram ?: 'пусто' }}</li>
                @endcan
        </ul>
    </div>
    <div class="col-lg-6">
        <ul class="ul list-group">
            Отчество:
            <li class="list-group-item">{{ $user->surname ?: 'пусто' }}</li>
            Электронная почта:
            <li class="list-group-item">{{ $user->email ?: 'пусто' }}</li>
        </ul>
    </div>
</div>
