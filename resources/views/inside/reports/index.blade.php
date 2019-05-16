@extends('layouts.inside')

@section('content')
    <div class="container main-content table-responsive">
        <h1><b>Список отправленных лидов</b></h1>

        <table id="table" class="table ">
            <thead class="bg-success">
            <tr>
                <th scope="col">Месяц</th>
                <th class="d-none d-sm-table-cell" scope="col">Передано лидов</th>
                <th class="d-none d-sm-table-cell" scope="col">Одобрено лидов</th>
                <th class="d-none d-sm-table-cell" scope="col">Некачественных лидов</th>
                <th class="d-none d-sm-table-cell" scope="col">Выдано займов</th>
                <th scope="col">Сумма</th>
                @can('show-all-leads')
                <th scope="col">Комиссия</th>
                @endcan
                <th class="d-none d-sm-table-cell" scope="col">Статус</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($leads))
                @foreach($leads as $date => $lead)
                    <tr onclick="window.location.href='{{ Route('report_month', $date) }}'; return false"
                        class="
                                @if($lead->where('lead_status', 3)->count() == $lead->where('transaction_status', 3)->count() and  $lead->where('transaction_status', 3)->count() != 0)
                                table-success
                                @endif
                                tr">
                        <td>{{ $date ?: 'Пусто'}}</td>
                        <td class="d-none d-sm-table-cell">{{ $lead->count() ?: 'Пусто'}} (100%)</td>
                        <td class="d-none d-sm-table-cell">{{ $lead->where('lead_status', 3)->count()}}
                            ({{ (int) ($lead->where('lead_status', 3)->count() / $lead->count() * 100) }} %)
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $lead->where('lead_status', 4)->count() }}
                        </td>
                        <td class="d-none d-sm-table-cell">{{ $lead->where('transaction_status', 3)->where('lead_status', 3)->count() }}
                            ({{ (int) ($lead->where('transaction_status', 3)->where('lead_status', 3)->count() / $lead->count() * 100) }}
                            %)
                        </td>
                        @can('show-all-leads')
                        <td>
                            {{ (int) ($lead->where('transaction_status', 3)->sum('money')) }}
                        </td>
                        @endcan
                        @can('lead')
                            <td>{{ (int)($lead->where('transaction_status', 3)->where('lead_status', 3)->sum('money') / 100) * Request::user()->commission}}</td>
                        @endcan
                        @can('show-all-leads')
                            <td>{{ (int) ($lead->where('transaction_status', 3)->sum('commissionSum')) }}</td>
                        @endcan
                        <td class="d-none d-sm-table-cell">
                            @if($lead->where('lead_status', 3)->count() == $lead->where('transaction_status', 5)->count() and  $lead->where('transaction_status', 5)->count() != 0)
                                Оплачено
                            @else
                                Не оплачено
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection