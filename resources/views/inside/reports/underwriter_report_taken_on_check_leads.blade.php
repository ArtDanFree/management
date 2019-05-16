@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Проверяемые Лиды</b></h1>
        <div class="two-menu">
            @can('admin')
                <a  href="{{ Route('underwriter_report_taken_on_check_leads', $id) }}">Проверяемые Лиды</a>
                <a href="{{ Route('user_history', $id) }}">История изменений аккаунта</a>
            @endcan

        </div>
        <table id="table" class="table ">
            <thead class="bg-success">
            <tr>
                <th scope="col">Дата изменения </th>
                @can('show-all-leads')
                    <th scope="col">Лидогенератор</th>
                    <th scope="col">Частный инвестор</th>
                @endcan
                <th scope="col">Город</th>
                <th scope="col">Сумма</th>
                <th scope="col">ФИО</th>
                <th scope="col">Проверка</th>
                <th scope="col">Выдача</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($leads))
                @foreach($leads as $lead)
                    <tr class="
                            @if($lead->transactionStatus->name == 'Сделка заключена' and $lead->status->name == 'Сделка')
                            table-success
                            @elseif($lead->transactionStatus->name == 'Сделка не заключена' or $lead->status->name == 'Некачественный лид')
                            table-danger
                            @endif
                            tr">
                        <td>{{ $lead->updated_at->format('d.m.Y') ?: 'Пусто'}}</td>
                        @can('show-all-leads')
                            <td><a href="{{ Route('admin_show_leads', $lead->user->id) }}">{{ $lead->user->first_name ?: 'Пусто' }}</a></td>
                            <td>{{ $lead->underwriter->first_name }}</td>
                        @endcan
                        <td>{{ $lead->city->name ?: 'Пусто'}}</td>
                        <td>{{ $lead->money ?: 'Пусто'}}</td>
                        <td>
                            <a href="{{ Route('lead.show', $lead) }}">{{ $lead->last_name . ' ' .$lead->first_name  . ' ' . $lead->surname }}</a>
                        </td>
                        <td>
                            @can('take-on-check')
                                @if($lead->status->name == 'Не обработан')
                                    <a data-toggle="modal" href="#take-on-check-{{ $lead->id }}"
                                    >{{ $lead->status->name ?: 'Пусто'}}</a>
                                @else
                                    {{ $lead->status->name ?: 'Пусто'}}
                                @endif
                            @else
                                {{ $lead->status->name ?: 'Пусто'}}
                            @endcan

                        </td>
                        <td>{{ $lead->transactionStatus->name ?: 'Пусто'}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        {{--pagination--}}
        @if(!empty($leads))
            <div class="row">
                <div class="col-lg-6">
                    {{ $leads->appends(['count' => Request::get('count')])->links() }}
                </div>
                <div class="col-lg-6 text-right dropdown show">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        На странице
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{Route('home', ['count' => 15])}}">15</a>
                        <a class="dropdown-item" href="{{Route('home', ['count' => 25])}}">25</a>
                        <a class="dropdown-item" href="{{Route('home', ['count' => 50])}}">50</a>
                        <a class="dropdown-item" href="{{Route('home', ['count' => 100])}}">100</a>
                    </div>
                </div>
            </div>
        @endif
        {{--end pagination--}}
    </div>
@endsection
