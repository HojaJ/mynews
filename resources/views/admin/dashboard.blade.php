@extends('layouts.admin')

@section('title', 'Дашборд')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Топ 5 новостей</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($topNews as $news)
                    <a href="{{ route('news.show', $news->id) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $news->name }}</h5>
                            <small>{{ $news->created_at->format('d.m.Y') }}</small>
                        </div>
                        <p class="mb-1">{{ Str::limit($news->description, 100) }}</p>
                        <small>Автор: {{ $news->author }}</small>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Топ авторов</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($topAuthors as $author)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $author->author }}</h5>
                            <span class="badge bg-primary rounded-pill">{{ $author->news_count }}</span>
                        </div>
                        <p class="mb-1">Количество новостей: {{ $author->news_count }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 