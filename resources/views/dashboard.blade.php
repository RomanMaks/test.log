@extends('layouts.app')

@section('title', 'Приборная доска')

@section('content')
    <div class="container dashboard-table">
        <dashboard-table></dashboard-table>
    </div>
    <div class="container dashboard-chart-bar">
        <dashboard-chart-bar></dashboard-chart-bar>
    </div>
@endsection