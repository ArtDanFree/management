@extends('layouts.outside')
@section('content')
<div id="login" class="container-fluid">
  <div id="login-info" class="row justify-content-center text-center">
    <div class="col-lg-5">
      <img width="250" src="{{ asset('img/logo-w.png') }}">

      <h2 style="margin: 50px">Аккаунт заблокирован</h2>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-6" style="margin-top:  9%">

      <h4> <p align="center">Для уточнения сведений о блокировке Вашего аккаунта обратитесь к администратору по адресу leads@likedengi.ru</p> </h4>
    </div>


  </div>
  <div class="row justify-content-center">
    <div class="col-lg-2" style="margin: 50px" >

      <form id="logout-form" action="{{ route('logout') }}" method="POST"
      style="display: none;">{{ csrf_field() }}</form>
      <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" type="submit" class="btn btn-warning btn-lg btn-block">Выйти</button>
    </div>
  </div>
</div>
@endsection
