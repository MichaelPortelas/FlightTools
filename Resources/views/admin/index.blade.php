@extends('flighttools::layouts.admin')

@section('title', 'FlightTools')
@section('actions')
    <li>
        <a href="{{ url('/flighttools/admin/create') }}">
            <i class="ti-plus"></i>
            Add New</a>
    </li>
@endsection
@section('content')
    <div class="card border-blue-bottom">
        <div class="header"><h4 class="title">Admin Scaffold!</h4></div>
        <div class="content">
            <p>This view is loaded from module: {{ config('flighttools.name') }}</p>
        </div>
    </div>
@endsection
