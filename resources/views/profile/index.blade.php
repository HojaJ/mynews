@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3>Личный кабинет</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                <h4>Привет, {{ session('user_login') }}!</h4>
                
                <div class="list-group mt-4">
                    <a href="{{ route('profile.change-password') }}" class="list-group-item list-group-item-action">
                        Изменить пароль
                    </a>
                    <a href="{{ route('news.create') }}" class="list-group-item list-group-item-action">
                        Добавить новость
                    </a>
                    @if(session('user_role') == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        Админ-панель
                    </a>
                    @endif
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
                        Выйти
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 