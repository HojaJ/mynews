@extends('layouts.admin')

@section('title', 'Редактирование новости')

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $news->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $news->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Автор</label>
                <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $news->author) }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Изображение</label>
                @if($news->image)
                <div class="mb-2">
                    <img src="{{ asset($news->image) }}" alt="{{ $news->name }}" style="max-width: 200px; max-height: 200px;">
                </div>
                @endif
                <input type="file" class="form-control" id="image" name="image">
                <small class="form-text text-muted">Оставьте пустым, чтобы сохранить текущее изображение</small>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Отмена</a>
            </div>
        </form>
    </div>
</div>
@endsection 