@extends('errors::illustrated-layout')

@section('code', '419')
@section('title', 'срок действия сессии истек')

@section('image')
<div style="background-image: url({{ asset('/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', 'К сожалению, срок действия вашей сессии истек. Обновите и повторите попытку.')
