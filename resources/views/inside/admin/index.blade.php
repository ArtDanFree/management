@extends('layouts.inside')
@section('content')
    <div class="container main-content">
        <h1><b>Список пользователей</b></h1>
        <div style="margin-bottom:10px" class="row">
            <div class="col-lg-4" >
              <select id='user-types' class="chosen-select">
              <option value='6' id='select1'>Все пользователи</option>
              <option value='2' id='select2'>Частные инвесторы</option>
              <option value='3' id='select3'>Лидогенераторы</option>
              <option value='1' id='select3'>Администраторы</option>
              <option value='4' id='select3'>Руководители</option>
              <option value='5' id='select3'>Заблокированные</option>
              </select>
            </div>
            <div class="col-lg-3">
                    <select id="search-city" name="" class="custom-select form-control-lg chosen-select" required>
                      @foreach($cities as $city)
                      <option value="{{ $city->id }}">{{ $city->name }}</option>
                      @endforeach
                    </select>
            </div>
            <form class="" action="{{asset('admin_search_name')}}" method="post">
              @csrf
                <input type="text" class="form-control-custom" name="search_name" value="">
                <button type="submit" class="btn btn-warning btn-custom" name="button">Поиск</button>
            </form>
        </div>
        <script type="text/javascript">
        $(document).ready(function () {
        $('#search-city').on('change', function (e) {
          link = '{{asset('/admin/user/city/')}}/'+ $("#search-city option:selected").text();
          $(location).attr('href', link);
            });
          });

        $('#user-types').on('change', function (e) {
          var link;
            var select_user = $("#user-types").val();
            switch (select_user) {
              case '6':
              link = '{{asset('/admin/user/')}}';
              $(location).attr('href', link);
              break;
              case '2':
              link = '{{asset('/admin/user/search/2')}}';
              $(location).attr('href', link);
              break;
              case '3':
              link = '{{asset('/admin/user/search/3')}}';
              $(location).attr('href', link);
              break;
              case '1':
              link = '{{asset('/admin/user/search/1')}}';
              $(location).attr('href', link);
              break;
              case '4':
              link = '{{asset('/admin/user/search/4')}}';
              $(location).attr('href', link);
              break;
              case '5':
              link = '{{asset('/admin/user/search/5')}}';
              $(location).attr('href', link);
              break;
              default:
            }

            });

            $(document).ready(function () {
              @if(!empty($type))
              var type = {{$type}};
              @else
              var type = 6;
              @endif
              $("#user-types option[value='"+type+"']").attr("selected", "selected");
            });
            </script>

        <div id="app">
            <div>
            <div class="table-responsive">
                <table id="table" class="table table-sm">
                    <thead class="bg-success">
                    <tr>
                        <th>Дата</th>
                        <th>Почта</th>
                        <th>ФИО</th>
                        <th>Роль</th>
                        <th>Комиссия</th>
                        <th>Ранг</th>
                        <th>Тип залога</th>
                        <th>Города</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($users))
                        @foreach($users as $user)
                            <tr class="no-color-tr tr td-min">
                                <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'">{{ $user->created_at->format('d.m.Y')}}</td>
                                <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'">{{ $user->email}}</td>
                                @if(empty($user->last_name))
                                    <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'">
                                        -
                                    </td>
                                @elseif($user->role->name == 'Лидогенератор')
                                    <td>
                                        <a href="{{ Route('admin_show_leads', $user) }}">{{ $user->last_name}} {{ $user->first_name}} {{ $user->surname}}</a>
                                    </td>
                                @elseif($user->role->name == 'Частный инвестор')
                                    <td>
                                        <a href="{{ Route('underwriter_report_taken_on_check_leads', $user) }}">{{ $user->last_name}} {{ $user->first_name ?: 'Пусто'}} {{ $user->surname}}</a>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ Route('user_history', $user) }}">{{ $user->last_name}} {{ $user->first_name}} {{ $user->surname}}</a>
                                    </td>
                                @endif
                                <td>
                                    <a href="#update-user-role-{{$user->id}}" data-toggle="modal" data-target="#update-user-role-{{$user->id}}">{{ $user->role->name }}</a>
                                </td>
                                <td>
                                    <a href="#update-user-comission-{{$user->id}}" data-toggle="modal" data-target="#update-user-comission-{{$user->id}}">{{ $user->commission}}
                                        % </a></td>
                                @if (($user->role_id)==2)
                                    <td>
                                        <a href="#modal-underwriter-fine" @click.prevent="onClick({{ $user->id }})" data-toggle="modal" data-target="#modal-underwriter-fine">{{ $user->fine ? $user->fine->level : '0' }}</a>
                                    </td>
                                @else
                                    <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'"></td>
                                @endif
                                @if (($user->role_id)==2)
                                    <td>
                                        <input type="radio" onclick="fun1({{$user->id}}, '{{csrf_token()}}')" name="collateral_{{$user->id}}" value="1" @if($user->type==1) checked @endif>
                                        Недвижимость<Br>
                                        <input type="radio" name="collateral_{{$user->id}}" onclick="fun1({{$user->id}}, '{{csrf_token()}}')" value="2" @if($user->type==2) checked @endif>
                                        Автомобиль<Br>
                                        <input type="radio" name="collateral_{{$user->id}}" onclick="fun1({{$user->id}}, '{{csrf_token()}}')" value="3" @if($user->type==3) checked @endif>
                                        Любой<Br>
                                    </td>
                                @else
                                    <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'"></td>
                                @endif
                                @if (($user->role_id)==2)
                                    <td>
                                        <a onclick="get_id({{$user->id}}, '{{csrf_token()}}')" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#change_city">Изменить</a>
                                    </td>
                                @else
                                    <td onclick="window.location.href='{{ Route('user.show', $user->id) }}'"></td>
                                @endif
                            </tr>

                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <underwriter-fine :user_id="data"></underwriter-fine>
            </div>
        </div>
    </div>
@foreach($users as $user)
@can('change-role')
    <!-- Modal change role-->
    <div class="modal fade" id="update-user-role-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Изменение роли</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin_user_role_update', $user->id) }}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="form-group">
                            <select name="role_id" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg btn-block">
                            Изменить
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal change role -->
@endcan
@can('change-role')
    <!-- Modal Изменение процента комиссии -->
    <div class="modal fade" id="update-user-comission-{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Изменение процента
                        комиссии</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin_user_update', $user->id) }}">
                        @csrf
                        {{ method_field('put') }}
                        <div class="form-group">
                            <label>Комиссия</label>
                            <input name="commission" value="{{ $user->commission }}" type="text"
                                   class="form-control{{ $errors->has('commission') ? ' is-invalid' : '' }}">
                            @if ($errors->has('commission'))
                                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('commission') }}</strong>
              </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg btn-block">
                            Изменить
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal Изменение процента комиссии  -->
@endcan
@endforeach
    <!-- Change city -->
    <div class="modal fade" id="change_city" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog custom-modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Выбрать список городов</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Город </label>

          <select id="add-city-select" name="city_id" class="custom-select form-control-lg chosen-select" required>

            @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
          </select>
          <script type="text/javascript">
          $(document).ready(function () {
            $(".chosen-select").chosen({width: "100%"});
          });
          </script>
          <button id="add-city-button" type="button" class="btn btn-warning btn-lg" style="margin:10px" name="button">Добавить</button>
          <button onclick="deleteCity()" type="button" class="btn btn-warning btn-lg" style="margin:10px" name="button">Удалить</button>

          <p><select id ="sel"  multiple name="hero[]" style="width: 100%" ></select></p>
          <button onclick="send('{{csrf_token()}}')"  aria-label="Close"  data-dismiss="modal" class="btn btn-success btn-lg btn-block ">Сохранить</button>

        </div>
      </div>
    </div>
  </div>
@endsection
