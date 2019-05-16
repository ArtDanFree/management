@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Изменения данных аккаунта</b></h1>

        <table id="table" class="table">
            <thead class="bg-success">
            <tr>
                <th scope="col">Дата</th>
                <th scope="col">Кем изменено</th>
                <th scope="col">История</th>

            </tr>
            </thead>
            <tbody>
              @foreach($history as $key)
              <tr class="td-min">
                <td>{{$key->created_at}}</td>
                <td>{{$key->editor->first_name}}</td>
                <td>@if($key->last_name != null)
                    <span class="bold-label">Фамилия</span>: {{$key->last_name}}<br>
                    @endif
                    @if($key->first_name != null)
                    <span class="bold-label">Имя</span>: {{$key->first_name}} <br>
                    @endif
                    @if($key->surname != null)
                    <span class="bold-label">Отчество</span>: {{$key->surname}} <br>
                    @endif
                    @if($key->email != null)
                    <span class="bold-label">Почта</span>: {{$key->email}} <br>
                    @endif
                    @if($key->organization != null)
                    <span class="bold-label">Организация</span>: {{$key->organization}} <br>
                    @endif
                    @if($key->credit_carf_number != null)
                    <span class="bold-label">Номер банковской карты</span>: {{$key->credit_carf_number}} <br>
                    @endif
                    @if($key->personal_acc != null)
                    <span class="bold-label">Лицевой или расчетный счет</span>: {{$key->personal_acc}} <br>
                    @endif
                    @if($key->correspondent_acc != null)
                    <span class="bold-label">Корр. сч.</span>: {{$key->correspondent_acc}} <br>
                    @endif
                    @if($key->bic_bank != null)
                  <span class="bold-label">  БИК банка</span>: {{$key->bic_bank}} <br>
                    @endif
                    @if($key->name_bank != null)
                  <span class="bold-label">  Наименование банка</span>: {{$key->name_bank}} <br>
                    @endif
                    @if($key->type != null)

                    @switch($key->type)
                    @case(0)
                  <span class="bold-label">  Тип</span>: Недвижимость  <br>
                    @break
                    @case(1)
                  <span class="bold-label">  Тип</span>: Автомобиль <br>
                    @break
                    @case(2)
                  <span class="bold-label">  Тип</span>: Любой  <br>
                    @break
                    @endswitch
                    @endif
                    @if($key->cities != null)
                  <span class="bold-label">  Города</span>:
                    {{$key->cities}} <br>
                    @endif
                    @if($key->telegram != null)
                  <span class="bold-label">  Телеграм</span>: {{$key->telegram}} <br>
                    @endif
                    @if($key->commission != null)
                  <span class="bold-label">  Комиссия</span>: {{$key->commission}} %<br>
                    @endif
                    @if($key->role_id != null)
                <span class="bold-label">    Роль</span>: {{$key->role->name}} <br>
                    @endif

                 </td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
@endsection
