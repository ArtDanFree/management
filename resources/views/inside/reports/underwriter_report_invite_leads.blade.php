@extends('layouts.inside')

@section('content')
    <div class="container main-content">
        <h1><b>Приглашенные Лидогенераторы</b></h1>
        <div class="two-menu">
            <a  href="{{ Route('underwriter_report_taken_on_check_leads', $id) }}">Проверяемые Лиды</a>
            <a href="{{ Route('underwriter_report_invite_leads', $id) }}">Приглашенные Лидогенераторы</a>
        </div>
        <table id="table" class="table ">
            <thead class="bg-success">
            <tr>
                <th scope="col">Дата приглашения</th>
                <th scope="col">Профиль</th>
                <th scope="col">Имя</th>
                <th scope="col">Почта</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($user->inviter))
                @foreach($user->inviter as $user)
                    <tr class="tr">
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        @if(!empty($user->invite))
                            <td><a href="{{ Route('admin_show_leads', $user->invite) }}">смотреть</a></td>
                        @else
                            <td>Не зарегистрирован</td>
                        @endif
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
@endsection
