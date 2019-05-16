<div style="margin-top: 20px" class="row">
    <div class="col-lg-6">
        <ul class="ul list-group">
            Фамилия:
            <li class="list-group-item">{{ $user->last_name ?: 'пусто' }}</li>
            Имя:
            <li class="list-group-item">{{ $user->first_name ?: 'пусто' }}</li>
            Отчество:
            <li class="list-group-item">{{ $user->surname ?: 'пусто' }}</li>
            Организация:
            <li class="list-group-item">{{ $user->organization ?: 'пусто' }}</li>
            Наименование банка:
            <li class="list-group-item">{{ $user->name_bank ?: 'пусто' }}</li>
{{--            Стоимость лидов:
            <li class="list-group-item">{{ $user->leads_cost ?: 'пусто' }}</li>--}}
        </ul>
    </div>
    <div class="col-lg-6">
        <ul class="ul list-group">
            Лицевой или расчетный счет:
            <li class="list-group-item">{{ $user->personal_acc ?: 'пусто' }}</li>
            Номер банковской карты:
            <li class="list-group-item">{{ $user->credit_card_number ?: 'пусто' }}</li>
            Корр. сч.
            <li class="list-group-item">{{ $user->correspondent_acc ?: 'пусто' }}</li>
            БИК банка:
            <li class="list-group-item">{{ $user->bic_bank ?: 'пусто' }}</li>
            Электронная почта:
            <li class="list-group-item">{{ $user->email ?: 'пусто' }}</li>
        </ul>
    </div>
</div>
