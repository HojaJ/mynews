<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyNews')</title>
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
    @include('partials.header')
    
    <div class="container mt-4">
        @yield('content')
    </div>
    
    @include('partials.footer')
    
    <script src="{{ asset('assets/bootstrap.min.js') }}"></script>
    @yield('scripts')
</body>
</html> 