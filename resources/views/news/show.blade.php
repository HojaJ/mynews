@extends('layouts.app')

@section('title', $news->name)

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mb-4">
            <img src="{{ asset( $news->image) }}" class="card-img-top" alt="{{ $news->name }}">
            <div class="card-body">
                <h1 class="card-title">{{ $news->name }}</h1>
                <h4 class="text-muted">Автор: {{ $news->author }}</h4>
                <div class="card-text mt-4 border-top">
                    {{ $news->description }}
                </div>
            </div>
            <div class="card-footer">
                <p class="text-muted text-end"> Дата создание: {{ $news->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 