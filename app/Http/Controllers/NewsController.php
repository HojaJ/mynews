<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(4);
        return view('news.index', compact('news'));
    }
    
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }
    
    public function create()
    {
        return view('news.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $filename);
            $data['image'] = 'images/' . $filename;
        }
        
        $data['author'] = session('user_login');
        News::create($data);
        
        return redirect()->route('profile')->with('success', 'Новость успешно добавлена');
    }
    
    public function loadMore(Request $request)
    {
        $page = $request->input('page', 1);
        $news = News::latest()->paginate(4, ['*'], 'page', $page);

        return response()->json([
            'html' => view('news.partials.news_cards', compact('news'))->render(),
            'lastPage' => $news->lastPage(),
        ]);
    }
}
