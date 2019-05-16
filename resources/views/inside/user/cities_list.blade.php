@extends('layouts.inside')

@section('content')
<div class="container main-content">
  <h1><b>Список доступных городов</b></h1>
  @can('underwriter')
  <table id="table" class="table">
    <thead class="bg-success">
      <tr>
        <th scope="col">Город</th>
      </tr>
    </thead>
    <tbody>
      @foreach($user_city as $key)
      <tr>
        <td>{{$key->name}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endcan
</div>
@endsection
