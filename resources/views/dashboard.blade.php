@extends('layouts.app')

@section('title', 'Приборная доска')

@section('content')
<div class="container">
    <div class="alert alert-dark collapse show" role="alert" id="collapseExample">
        <form method="get" action="{{ route('dashboard.index') }}">
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="date">Дата</label>
                    <input type="date" class="form-control" name="date" id="date" value="{{ request('date') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="os">ОС</label>
                    <input type="text" class="form-control" name="os" id="os" value="{{ request('os') }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="architecture">Архитектура</label>
                    <select class="form-control select2-container" id="architecture" name="architecture">
                        <option></option>
                        <option value="x86" {{ request('architecture') === 'x86' ? 'selected' : ''  }}>x86</option>
                        <option value="x64" {{ request('architecture') === 'x64' ? 'selected' : ''  }}>x64</option>
                    </select>
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
                    <th>Дата запроса</th>
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
                        <td>{{ $log->count }}</td>
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
