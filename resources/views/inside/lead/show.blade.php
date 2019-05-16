@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Карточка лида</b></h1>
        <div style="margin-top: 20px" class="row">
            <div class="col-lg-5">
                <ul class="ul list-group">
                    Имя
                    <li class="list-group-item">{{ $lead->first_name ?: 'пусто' }}</li>
                    Фамилия
                    <li class="list-group-item">{{ $lead->last_name ?: 'пусто' }}</li>
                    Отчество
                    <li class="list-group-item">{{ $lead->surname ?: 'пусто' }}</li>
                    Желаемая сумма:
                    <li class="list-group-item">{{ $lead->money ?: 'пусто' }}</li>
                    Телефон:
                    <li class="list-group-item">{{ $lead->phone ?: 'пусто' }}</li>
                </ul>
            </div>
            <div id="file-info" class="col-lg-5 offset-lg-2">
              @can('lead')
                <h3><b>Загрузить документы</b></h3>
                <ul>
                    <li>- Главная страница паспорта</li>
                    <li>- Страница паспорта с регистрацией</li>
                </ul>
                <ul>
                    <li><b>Для автомобиля:</b></li>
                    <li>- ПТС с обеих сторон</li>
                    <li>- СТС с обеих сторон</li>
                </ul>
                <ul>
                    <li><b>Для недвижимости:</b></li>
                    <li>- Свидетельство о регистрации и/или выписка ЕГРН</li>
                    <li>- Документы-основания владения имуществом (договор купли-продажи, дарения и т.д)</li>
                </ul>
                <ul>
                    <li><b>Примечание: загружайте в анкету не более 15 документов. Размер одного файла не должен превышать 15 Мб.</b></li>

                </ul>
                    <div class="text-center">
                        <a class="btn btn-warning" data-toggle="modal" data-target="#add-image">Загрузить</a>
                    </div>
                @endcan
                    <div id="document-list">
                        <h5><b>Список документов</b></h5>
                        @if($documents->isNotEmpty())
                        <ul>
                            @foreach($documents as $document)
                                <li><a data-fancybox="gallery"
                                       href="{{ asset('storage/' . $document->img) }}">{{ $document->name }}</a>
                                    @can('lead')
                                        <img data-toggle="modal" data-target="#img-{{ $document->id }}" id="destroy"
                                             src="{{ asset('img/trashcan.svg') }}">
                                    @endcan
                                </li>
                            @endforeach
                        </ul>
                            @else
                            <p>Нет документов</p>
                            @endif
                    </div>
            </div>
        </div>
        <div style="margin-top: 25px" class="row justify-content-center">
            <a href="{{ Route('lead.edit', $lead->id) }}" class="col-lg-3 btn btn-warning btn-lg btn-block text-center">Редактировать</a>
        </div>
        <div style="margin-top: 15px" class="row">
            @can('admin')
                <div class="col-12">
                    <h4>Статус лида</h4>
                </div>
                <form action="{{ Route('lead.update', $lead->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input hidden name="lead_status" value="3">
                    <input hidden name="transaction_status" value="1">
                    <input hidden name="approval_date" value="{{ \Carbon\Carbon::now() }}">
                    <button class="change-status-form-button btn {{ $lead->lead_status == 3 ? 'btn-success' : 'btn-outline-success' }}">
                        Сделка
                    </button>
                </form>
                <button class="change-status-form-button btn {{ $lead->lead_status == 4 ? 'btn-danger' : 'btn-outline-danger' }}" data-toggle="modal" data-target="#poor-lead">
                    Некачественный лид
                </button>
                <div id="change-status" class="col-lg-12">
                    @if($lead->lead_status == 3)
                        <h4 style="margin-top: 15px">Статус сделки</h4>
                        <div class="dropdown">
                            <button style="font-size: 16px !important;"
                                    class="btn dropdown-toggle
                                        @switch($lead->transaction_status)
                                    @case(1)
                                            btn-light
@break
                                    @case(2)
                                            btn-info
@break
                                    @case(3)
                                            btn-success
@break
                                    @case(4)
                                            btn-danger
@break
                                    @endswitch
                                            " type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                {{ $lead->transactionStatus->name ?: 'Пусто'}}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @foreach($transactionStatus as $status)
                                    @if($status->name == 'Сделка не заключена')
                                        <button style="font-size: 16px!important;"
                                                class="lead-status dropdown-item btn-link" data-toggle="modal" data-target="#transaction_is_not_completed">{{ $status->name }}</button>
                                    @elseif($status->name != 'Сделка заключена')
                                        <form action="{{ Route('lead.update', $lead->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PUT') }}
                                            <input hidden name="transaction_status" value="{{ $status->id }}">
                                            <button style="font-size: 16px!important;"
                                                    class="lead-status dropdown-item btn-link">{{ $status->name }}</button>
                                        </form>
                                    @else
                                        <button style="font-size: 16px!important;"
                                                class="lead-status dropdown-item btn-link" data-toggle="modal" data-target="#specified-amount">{{ $status->name }}</button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else('update-status')
                @if($lead->lead_status != 1 and $lead->transaction_status != 3)
                    <div class="col-12">
                        <h4>Статус лида</h4>
                    </div>
                    @if($lead->lead_status != 4)
                    <form action="{{ Route('lead.update', $lead->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input hidden name="lead_status" value="3">
                        <input hidden name="transaction_status" value="1">
                        <input hidden name="approval_date" value="{{ \Carbon\Carbon::now() }}">
                        <button class="change-status-form-button btn {{ $lead->lead_status == 3 ? 'btn-success' : 'btn-outline-success' }}">
                            Сделка
                        </button>
                    </form>
                    @endif
                    <button class="change-status-form-button btn {{ $lead->lead_status == 4 ? 'btn-danger' : 'btn-outline-danger' }}" data-toggle="modal" data-target="#poor-lead">
                        Некачественный лид
                    </button>
                    <div id="change-status" class="col-lg-12">
                        @if($lead->lead_status == 3)
                            <h4 style="margin-top: 15px">Статус сделки</h4>
                            <div class="dropdown">
                                <button style="font-size: 16px !important;"
                                        class="btn dropdown-toggle
                                        @switch($lead->transaction_status)
                                        @case(1)
                                                btn-light
@break
                                        @case(2)
                                                btn-info
@break
                                        @case(3)
                                                btn-success
@break
                                        @case(4)
                                                btn-danger
@break
                                        @endswitch
                                                " type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    {{ $lead->transactionStatus->name ?: 'Пусто'}}
                                </button>
                                @if($lead->transaction_status != 4)
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach($transactionStatus as $status)
                                        @if($status->name == 'Сделка не заключена')
                                            <button style="font-size: 16px!important;"
                                                    class="lead-status dropdown-item btn-link" data-toggle="modal" data-target="#transaction_is_not_completed">{{ $status->name }}</button>
                                        @elseif($status->name != 'Сделка заключена')
                                            <form action="{{ Route('lead.update', $lead->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                <input hidden name="transaction_status" value="{{ $status->id }}">
                                                <button style="font-size: 16px!important;"
                                                        class="lead-status dropdown-item btn-link">{{ $status->name }}</button>
                                            </form>
                                        @else
                                            <button style="font-size: 16px!important;"
                                                    class="lead-status dropdown-item btn-link" data-toggle="modal" data-target="#specified-amount">{{ $status->name }}</button>
                                        @endif
                                    @endforeach
                                </div>
                                    @endif
                            </div>
                        @endif
                    </div>
                @endif
            @endcan
        </div>
    </div>
        <div style="margin-top: 20px" class="container">
            @if(!empty($lead->rejection_reason))
                <div class="row">
                    <p class="col-lg-6"><b>Причина отказа: </b>{{ $lead->rejection_reason }}</p>
                </div>
            @endif
            @if(!empty($lead->comment))
                <div class="row">
                    <p class="col-lg-6"><b>Коментарий: </b>{{ $lead->comment }}</p>
                </div>
            @endif
        </div>
    <!-- Modal Загрузить документы -->
    @include('inside.lead.modals.upload_documents')
    <!-- end Modal Загрузить документы -->

    <!-- Modal Укажите выданную сумму -->
    @include('inside.lead.modals.indicate_the_amount_issued')
    <!-- end Modal Укажите выданную сумму-->

    <!-- Modal Некачественный лид  -->
    @include('inside.lead.modals.poor_lead')
    <!-- end Modal Некачественный лид  -->

    <!-- Modal Сделка не заключена   -->
    @include('inside.lead.modals.transaction_is_not_completed')
    <!-- end Modal Сделка не заключена   -->

    @can('lead')
        @if(!empty($documents))
            @foreach($documents as $document)
                <div id="img-{{ $document->id }}" class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Удалить '{{ $document->name }}' ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="text-center" method="post"
                                      action="{{ Route('lead_image.destroy' ,$document) }}">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button style="font-size: 20px !important" class="btn btn-danger">Удалить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endcan
@endsection

@section('script')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
@endsection
