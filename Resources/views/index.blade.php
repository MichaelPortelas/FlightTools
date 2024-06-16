@extends('flighttools::layouts.frontend')

@section('title', 'FlightTools')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {{ config('flighttools.name') }}
    </p>
@endsection
