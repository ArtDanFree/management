@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Список отправленных лидов</b></h1>


        @can('admin')
            <h4>Все лиды
            <a href="{{asset('report/pay/'.$data)}}">Комиссии</a>
            </h4>
        @endcan

        @can('show-own-leads')
            @if($document!="")
                <a href="{{asset($document)}}">Квитанция об оплате</a>
            @endif

        @endcan


        <div class="table-responsive">
            <table id="table" class="table">
                <thead class="bg-success">
                <tr>
                    <th scope="col">Дата</th>
                    @can('show-all-leads')
                        <th class="d-none d-md-table-cell" scope="col">Лидогенератор</th>
                        <th class="d-none d-md-table-cell" scope="col">Андеррайтер</th>
                    @endcan
                    <th class="d-none d-md-table-cell" scope="col">Город</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">ФИО</th>
                    <th class="d-none d-md-table-cell" scope="col">Телефон</th>
                    <th class="d-none d-md-table-cell" scope="col">Проверка</th>
                    <th class="d-none d-md-table-cell" scope="col">Выдача</th>
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
                            <td >{{ $lead->created_at->format('d.m.Y') ?: 'Пусто'}}</td>
                            @can('show-all-leads')
                                <td class="d-none d-md-table-cell">{{ $lead->user->organization ?: 'Пусто' }}</td>
                                @if(empty( $lead->underwriter['first_name']))
                                    <td class="d-none d-md-table-cell">Нет</td>
                                @else
                                    <td class="d-none d-md-table-cell">
                                        {{ $lead->underwriter['first_name']}}
                                    </td>
                                @endif
                            @endcan
                            <td class="d-none d-md-table-cell">{{ $lead->city->name ?: 'Пусто'}}</td>
                            <td >{{ $lead->money ?: 'Пусто'}}</td>
                            <td>
                                <a href="{{ Route('lead.show', $lead) }}">{{  $lead->last_name . ' ' .$lead->first_name . ' ' . $lead->surname }}</a>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $lead->phone ?: 'Пусто'}}</td>
                            <td class="d-none d-md-table-cell">
                                {{ $lead->status->name ?: 'Пусто'}}

                            </td>
                            <td class="d-none d-md-table-cell">{{ $lead->transactionStatus->name ?: 'Пусто'}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
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
