<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <meta name="yandex-verification" content="2b90f08c2f8f18e6" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Лид-маркет</title>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}" />

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="{{asset('js/jquery.maskedinput.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment-timezone-with-data-2012-2022.js')}}" type="text/javascript"></script>



    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/default.min.css">

@yield('script-head')

</head>
<body>
<div id="inside-header" class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <a class="logo-a" href="{{ Route('home') }}"><img width="180" src="{{ asset('img/logo.png') }}"></a>
        </div>
        <div class="col-lg-4 col-md-6 stat">
            @can('lead')
                @if(!empty($statistic))
                    <b>{{ $statistic['date'] }}</b>
                    <br>Вы заработали {{ $statistic['earned'] }} рублей
                    <br>Выдано {{ $statistic['issued']}} из {{ $statistic['count']}},
                    конверсия {{ $statistic['conversion']}}%
                    <br>На рассмотрении {{ $statistic['on_check']}}
                    <br> Некачественных лидов {{ $statistic['bad_quality']}}
                @endif
            @elsecan('admin')
                @if(!empty($statistic))
                <b>{{ $statistic['date'] }}</b>
                <br>К оплате: {{ $statistic['to_pay'] }} рублей
                <br>Выдано {{ $statistic['issued'] }} из {{ $statistic['count'] }}, конверсия {{ $statistic['conversion'] }}%
                <br>На рассмотрении {{ $statistic['on_check'] }}
                <br> Некачественных лидов {{ $statistic['bad_quality']}}
                @endif
            @endif
        </div>
        <div id="menu" class="col-lg-5 text-right col-md-7">
          <a href="{{ Route('user.show', Request::user()->id) }}">
              @if(!empty($notification_user))
                  @foreach($notification_user as $key)
                      <img src="{{asset('img/user.png')}}" alt="">  <span class="bold-label">{{$key->role->name}}</span>
                      : {{$key->first_name}}
                  @endforeach
              @endif
          </a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit().detach()"><span id="head-logout">Выйти</span> </a>
                <form hidden id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
          <br>
            @can('reports')
            <a href="{{ Route('reports') }}"><span id="head-reports">Отчеты</span></a>
            @endcan
            @can('telegram')
            <a  href="{{ Route('reports') }}" data-toggle="modal" data-target="#telegram-modal"> <span id="head-notification" >Уведомления</span></a>
            @endcan
            @can('admin')
            <a href="{{ Route('admin_user') }}"> <span id="head-users"> Пользователи</span> </a>
            @endcan
            @can('admin')
            <a  href="{{ Route('admin_add_cities') }}"><span id="head-location">Города</span></a>
            @endcan
            @can('api')
                <a href="{{ Route('api') }}"><span id="head-api" >API</span> </a>
            @endcan
        </div>
        @can('add-lead')
            <div class="inside-header-button col-lg-4 offset-lg-8 col-md-5">
                <a class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#add-lead">Добавить
                    лида</a>
            </div>
        @endcan
        @can('invite-user')
            <div class="inside-header-button col-lg-4 offset-lg-8 col-md-5">
                <a class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#invite-user">Пригласить
                    партнера</a>
            </div>
        @endcan
    </div>

</div>
@if (count($errors) > 0)
    <div style="margin-top: 15px" class="container">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>

@endif
@if (\Session::has('message'))
    <div style="margin-top: 15px" class="container">
        <div class="alert alert-success">
            <ul>
                @foreach( \Session::get('message') as $message)
                <li>{{ $message }}</li>
                    @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="container">
    {{ Breadcrumbs::render() }}
</div>
<div id="app">
    @yield('content')
    @include('inside.notification')

</div>
{{--footer--}}
<div id="footer" class="container text-center">
    © 2018 Все права защищены
    <br>
    <a href="{{ Route('personal_data_processing') }}" target="_blank">Политика обработки персональных данных</a>
    <br>
    <a href="#">Публичная оферта</a>
    <br>
</div>
{{--end footer--}}
@include('inside.add_lead_or_invite_user')
<script src="{{mix('js/app.js')}}" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/highlight.min.js"></script>
<script>
hljs.initHighlightingOnLoad();
var get_user_cities = '{{asset('admin/get_user_cities')}}';
var update_cities = '{{asset('admin/update_cities')}}';
var update_type = '{{asset('admin/update_type')}}';
var search_by_cities = '{{asset('admin/search_by_cities')}}';
var change_telegram_id = '{{asset('change_telegram_id')}}';
var notification_ajax = '{{asset('notification_ajax')}}';
var csrf = '{{csrf_token()}}';
var notification_user_id = '{{Request::user()->id}}';
var x_select = '0';
var page_count = '15';
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

@yield('script')
@can('feedback')
    {{--BEGIN JIVOSITE CODE {literal}--}}
    <script type='text/javascript'>
        (function(){ var widget_id = 'rpD7JLevYq';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
    </script>
    {{--{/literal} END JIVOSITE CODE--}}
@endcan

</body>
</html>
