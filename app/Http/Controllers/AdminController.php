<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Топ 5 новостей (по просмотрам, но у нас нет счетчика просмотров, поэтому берем последние)
        $topNews = News::latest()->take(5)->get();
        
        // Топ авторов (по количеству новостей)
        $topAuthors = DB::table('news')
            ->select('author', DB::raw('count(*) as news_count'))
            ->groupBy('author')
            ->orderBy('news_count', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('topNews', 'topAuthors'));
    }
    
    // CRUD для новостей
    public function newsList()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }
    
    public function newsCreate()
    {
        return view('admin.news.create');
    }
    
    public function newsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'author' => 'required|string|max:255',
        ]);
        
        $data = $request->all();

        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }

        News::create($data);
        
        return redirect()->route('admin.news.index')->with('success', 'Новость успешно добавлена');
    }
    
    public function newsEdit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }
    
    public function newsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image',
            'author' => 'required|string|max:255',
        ]);
        
        $news = News::findOrFail($id);
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Удаляем старое изображение, если оно есть
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }

            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }
        
        $news->update($data);
        
        return redirect()->route('admin.news.index')->with('success', 'Новость успешно обновлена');
    }
    
    public function newsDestroy($id)
    {
        $news = News::findOrFail($id);
        
        // Удаляем изображение, если оно есть
        if ($news->image && file_exists(public_path($news->image))) {
            unlink(public_path($news->image));
        }

        $news->delete();
        
        return redirect()->route('admin.news.index')->with('success', 'Новость успешно удалена');
    }
    
    // CRUD для пользователей
    public function usersList()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    public function usersCreate()
    {
        return view('admin.users.create');
    }
    
    public function usersStore(Request $request)
    {
        $request->validate([
            'login' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,content_manager,admin',
        ]);
        
        User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно добавлен');
    }
    
    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'login' => 'required|string|unique:users,login' . $id,
            'role' => 'required|in:user,content_manager,admin',
        ]);
        
        $data = [
            'login' => $request->login,
            'role' => $request->role,
        ];
        
        // Обновляем пароль только если он был предоставлен
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно обновлен');
    }
    
    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);
        
        // Запрещаем удалять самого себя
        if ($user->id == session('user_id')) {
            return redirect()->route('admin.users.index')->with('error', 'Вы не можете удалить свою учетную запись');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно удален');
    }
}
