<?php

namespace App\Http\Controllers;
use TCG\Voyager\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    // Method to get all posts
    public function index()
    {
        $posts = Post::all();
    
        $posts->transform(function ($post) {
            // Получаем путь к изображению
            $imagePath = $post->image;
    
            // Формируем URL на основе пути к изображению
            $post->image = url('/storage/' . $imagePath);
    
            // Удаляем ненужные поля или форматируем данные по желанию
    
            return $post;
        });
    
        return response()->json($posts);
    }
    // Method to get a single post by ID
    public function show($id)
    {
        $post = Post::find($id);
    
        if ($post) {
            // Получаем путь к изображению
            $imagePath = $post->image;
    
            // Добавляем URL к изображению
            $post->image = url('/storage/' . $imagePath);
    
            // Удаляем ненужные поля или форматируем данные по желанию
    
            return response()->json($post);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }


    public function filter(Request $request): JsonResponse
    {
        $query = Post::query();
    
        // Фильтр для новостей на выходных
        if ($request->has('weekends')) {
            $query->where(function ($query) {
                $query->whereDate('created_at', Carbon::now()->startOfWeek()->addDays(5))
                      ->orWhereDate('created_at', Carbon::now()->startOfWeek()->addDays(6));
            });
        }
    
        // Фильтр для новостей на этой неделе
        if ($request->has('this_week')) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
    
        // Фильтр для новостей в этом месяце
        if ($request->has('this_month')) {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }
    
        $posts = $query->get();
    
        $posts->transform(function ($post) {
            // Получаем путь к изображению
            $imagePath = $post->image;
    
            // Добавляем URL к изображению
            $post->image = url('/storage/' . $imagePath);
    
            // Удаляем ненужные поля или форматируем данные по желанию
    
            return $post;
        });
    
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found for the given filter']);
        }
    
        return response()->json($posts);
    }

}
