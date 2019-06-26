@extends('layouts.app')

@section('title', 'Приборная доска')

@section('content')
<div class="container">
    <div class="alert alert-dark collapse show" role="alert" id="collapseExample">
        <form method="get" action="{{ route('dashboard.index') }}">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="date">Дата</label>
                    <input type="text" class="form-control" name="date" id="date" value="{{ old('date') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="request">Число запросов</label>
                    <input type="text" class="form-control" name="request" id="request" value="{{ old('request') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="url">Url</label>
                    <input type="text" class="form-control" name="url" id="url" value="{{ old('url') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="browser">Браузер</label>
                    <input type="text" class="form-control" name="browser" id="browser" value="{{ old('browser') }}">
                </div>
            </div>
            <div class="col-sm-5">
                <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-filter"></i> Фильтровать</button>
                <a class="btn btn-outline-secondary" href="{{ route('dashboard.index') }}"><i class="fas fa-filter"></i> Сбросить фильтры</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            @if($logs->isNotEmpty())
                <thead>
                <tr>
                    <th>Дата</th>
                    <td>Число запросов</td>
                    <th>Url</th>
                    <th>Браузер</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->date }}</td>
                        <td>{{ rand(1, 100) }}</td>
                        <td>{{ $log->url }}</td>
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
