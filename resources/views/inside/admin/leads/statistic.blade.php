@extends('layouts.inside')
@section('content')
    <div class="container main-content">
        <h1><b>Статистика</b></h1>
        @can('admin')
            <a href="{{ Route('user_history', $id) }}">История изменений аккаунта </a>
            <a style="margin-left: 7px" href="{{ Route('admin_lead_statistic', $id) }}">Статистика</a>
        @endcan
        <table id="table" class="table">
            <thead class="bg-success">
            <tr>
                <th>Дата</th>
                <th>Заработал</th>
                <th>Выдал заявок</th>
                <th>Конверсия</th>
                <th>На рассмотрении</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($statistics))
                @foreach($statistics as $key => $item)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $item['earned'] }}</td>
                        <td>{{ $item['issued'] }} из {{ $item['count'] }}</td>
                        <td>{{ $item['conversion'] }}%</td>
                        <td>{{ $item['on_check'] }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
