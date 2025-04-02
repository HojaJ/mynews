@extends('layouts.app')

@section('title', 'Изменение пароля')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h3>Изменение пароля</h3>
            </div>
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
                
                <form action="{{ route('profile.change-password.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">Новый пароль</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Повторите пароль</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
                
                <div class="mt-3 text-center">
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Назад в профиль</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 