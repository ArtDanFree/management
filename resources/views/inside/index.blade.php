@extends('layouts.inside')
@section('content')
    <div class="container container-fluid">
            @can('lead')
                <home-page-lead-generator></home-page-lead-generator>
            @elsecan('underwriter')
                <home-page-underwriter></home-page-underwriter>
            @elsecan('admin')
                <home-page-admin></home-page-admin>
            @endcan
    </div>
@endsection
