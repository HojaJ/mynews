<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1><a href="{{ route('news.index') }}" class="text-white text-decoration-none">MyNews</a></h1>
            <div>
                @if(session('user_id'))
                    <a href="{{ route('profile') }}" class="btn btn-outline-light me-2">{{ session('user_login') }}</a>
                    @if(in_array(session('user_role'), ['admin', 'content_manager']))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning me-2">Админ-панель</a>
                    @endif
                    <a href="{{ route('logout') }}" class="btn btn-light">Выйти</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light">Логин</a>
                @endif
            </div>
        </div>
    </div>
</header> 