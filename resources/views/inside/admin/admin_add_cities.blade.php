@extends('layouts.inside')
@section('content')
<div class="container main-content">
    <div class="row">
        <div class="col-sm-8">
            <h1><b>Список городов</b></h1>
        </div>
        <div class="col-sm-4">
                <button id="add-city-button" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#new_city">
                    Добавить
                </button>
        </div>
    </div>

    <table id="table" class="table ">
        <thead class="bg-success">
        <tr>
            <th onclick="update_table_cities() " scope="col">Город</th>
            <th scope="col">Управление</th>
        </tr>
        </thead>
        <tbody id="table_content">
        @foreach($cities as $city)
            <tr id="{{ $city->name}}" class="tr">
                <td id="city-{{ $city->id}}">{{ $city->name}}</td>

                <td>
                    <div onclick="gl_var({{$city->id}},'{{csrf_token()}}')" data-toggle="modal" data-target="#change_city" class="">
                        Изменить
                    </div>
                    <div onclick="conf_show({{$city->id}},'{{ $city->name}}','{{csrf_token()}}')" class="">
                        Удалить
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<!-- Change city -->
<div class="modal fade" id="change_city" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Изменить название города</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                {{ method_field('put') }}
                <div class="form-group">
                    <input id="input_new_name" oninput="change_input()" name="surname" type="text"
                           class="form-control"
                           placeholder="Название города">
                </div>
                <button id="save_button" onclick="change_city_name()" aria-label="Close" data-dismiss="modal" class="btn btn-success btn-lg btn-block ">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change city -->
<div class="modal fade" id="new_city" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Добавить новый город</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                {{ method_field('put') }}
                <div class="form-group">
                    <input id="input_new_city" oninput="change_input_new_city()" name="surname" type="text"
                           class="form-control"
                           placeholder="Название города">
                </div>
                <button id="save_button" onclick="add_new_city('{{csrf_token()}}')" aria-label="Close" data-dismiss="modal" class="btn btn-success btn-lg btn-block ">
                    Сохранить
                </button>
            </div>
        </div>
    </div>
</div>



@endsection
