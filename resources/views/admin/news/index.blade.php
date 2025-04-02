@extends('layouts.admin')

@section('title', 'Управление новостями')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Добавить новость</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Автор</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->author }}</td>
                        <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('news.show', $item->id) }}" class="btn btn-sm btn-info">Просмотр</a>
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-primary">Редактировать</a>
                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $news->links() }}
        </div>
    </div>
</div>
@endsection 