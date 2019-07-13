@extends('layouts.app')

@section('title', 'Приборная доска')

@section('content')

    @include('dashboard.components.table')

    @include('dashboard.components.chart-bar')

@endsection