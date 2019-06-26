@extends('layouts.app')

@section('title', 'Приборная доска')

@section('content')
<div class="container">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            @if($logs->isNotEmpty())
                <thead>
                <tr>
                    <th>Ip</th>
                    <th>Дата</th>
                    <th>Url</th>
                    <th>ОС</th>
                    <th>Архитектура</th>
                    <th>Браузер</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->ip }}</td>
                        <td>{{ $log->date }}</td>
                        <td>{{ $log->url }}</td>
                        <td>{{ $log->os }}</td>
                        <td>{{ $log->architecture ?? 'undefined' }}</td>
                        <td>{{ $log->browser }}</td>
                    </tr>
                @endforeach
                </tbody>
            @else
                <tr>
                    <th>Поиск не дал результатов</th>
                </tr>
            @endif
        </table>
    </div>
    {{ $logs->links() }}
</div>
@endsection
