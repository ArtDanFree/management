@extends('layouts.inside')

@section('content')
    @can('telegram')
    <div class="container">
        <a href="{{ Route('telegram_id') }}">Как узнать Telegram ID ?</a>
    </div>
    @endcan
    <div class="container main-content">
        <h1><b>Редактирование личных данных</b></h1>
        @can('lead')
        @include('inside.user.lead_update_form')
            @elsecan('show-all-leads')
            @include('inside.user.admin_update_form')
        @endcan
        </div>
@endsection
