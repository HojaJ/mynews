<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Получить список всех новостей
     */
    public function index()
    {
        $news = News::latest()->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $news->items(),
            'meta' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ],
        ]);
    }

    /**
     * Получить детальную информацию о новости
     */
    public function show($id)
    {
        $news = News::find($id);
        
        if (!$news) {
            return response()->json([
                'status' => 'error',
                'message' => 'Новость не найдена',
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $news,
        ]);
    }
}
