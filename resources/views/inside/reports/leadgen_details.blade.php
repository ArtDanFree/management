@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Список отправленных лидов</b></h1>







        <table id="table" class="table">
            <thead class="bg-success">
            <tr>
                <th scope="col">Дата</th>
                @can('show-all-leads')
                    <th scope="col">Лидогенератор</th>
                    <th scope="col">Андеррайтер</th>
                @endcan
                <th scope="col">Город</th>
                <th scope="col">Сумма</th>
                <th scope="col">ФИО</th>
                <th scope="col">Телефон</th>
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
                        <td>{{ $lead->created_at->format('d.m.Y') ?: 'Пусто'}}</td>
                        @can('show-all-leads')
                            <td>{{ $lead->user->organization ?: 'Пусто' }}</td>
                            @if(empty( $lead->underwriter['first_name']))
                                <td>Нет</td>
                            @else
                                <td>
                                    <a href="{{ Route('report_underwriter', $lead->underwriter['id']) }}">{{ $lead->underwriter['first_name'] }}</a>
                                </td>
                            @endif
                        @endcan
                        <td>{{ $lead->city->name ?: 'Пусто'}}</td>
                        <td>{{ $lead->money ?: 'Пусто'}}</td>
                        <td>
                            <a href="{{ Route('lead.show', $lead) }}">{{$lead->last_name. ' ' .$lead->first_name   . ' ' . $lead->surname }}</a>
                        </td> 
                        <td>{{ $lead->phone ?: 'Пусто'}}</td>
                        <td>
                            {{ $lead->status->name ?: 'Пусто'}}

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
