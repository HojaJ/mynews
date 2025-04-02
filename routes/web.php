<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Главная страница (перенаправление на новости)
Route::get('/', function () {
    return redirect()->route('news.index');
});

// Маршруты для новостей
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/load-more', [NewsController::class, 'loadMore'])->name('news.load-more');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Маршруты для авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Маршруты для профиля (требуют авторизации)
Route::middleware(['auth.session'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.post');

    // Маршруты для создания новостей
    Route::post('/news_crud', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news_crud/create', [NewsController::class, 'create'])->name('news.create');

});

// Маршруты для админ-панели (требуют роли админа или контент-менеджера)
Route::middleware(['auth.session'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // CRUD для новостей
    Route::get('/news', [AdminController::class, 'newsList'])->name('admin.news.index');
    Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('admin.news.create');
    Route::post('/news', [AdminController::class, 'newsStore'])->name('admin.news.store');
    Route::get('/news/{id}/edit', [AdminController::class, 'newsEdit'])->name('admin.news.edit');
    Route::put('/news/{id}', [AdminController::class, 'newsUpdate'])->name('admin.news.update');
    Route::delete('/news/{id}', [AdminController::class, 'newsDestroy'])->name('admin.news.destroy');
    
    // CRUD для пользователей (только для админа)
    Route::middleware(['admin'])->group(function () {
        Route::get('/users', [AdminController::class, 'usersList'])->name('admin.users.index');
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');
    });
});
