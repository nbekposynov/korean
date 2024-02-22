<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('photos')->get();
    
        $albums->transform(function ($album) {
            $album->photos->transform(function ($photo) {
                $imagePaths = json_decode($photo->image_path, true);
    
                // Убедитесь, что путь корректен и не содержит лишних символов
                $correctedPath = str_replace('\\', '/', $imagePaths[0]['download_link']);
                $fullUrl = url('/storage/' . $correctedPath);
                
                //dd("Original path: " . $imagePaths[0]['download_link']);
    
                $photo->image_path = $fullUrl;
    
                unset($photo->created_at, $photo->updated_at);
    
                return $photo;
            });
    
            unset($album->updated_at);
    
            return $album;
        });
    
        return response()->json(['albums' => $albums]);
    }

    public function indexForHome()
    {
        // Используем подзапрос для фильтрации альбомов с более чем 4 фотографиями
        $latestAlbum = Album::with('photos')
            ->whereHas('photos', function ($query) {
                $query->selectRaw('album_id, COUNT(*) as photo_count')
                      ->groupBy('album_id')
                      ->having('photo_count', '>', 4);
            })
            ->orderByDesc('created_at') // Сортируем альбомы по дате создания
            ->first(); // Получаем только последний альбом
    
        // Проверяем, найден ли альбом
        if ($latestAlbum) {
            $latestAlbum->photos->transform(function ($photo) {
                $imagePaths = json_decode($photo->image_path, true);
                $correctedPath = str_replace('\\', '/', $imagePaths[0]['download_link']);
                $fullUrl = url('/storage/' . $correctedPath);
                $photo->image_path = $fullUrl;
                unset($photo->created_at, $photo->updated_at);
                return $photo;
            });
    
            unset($latestAlbum->updated_at);
        }
    
        return response()->json(['album' => $latestAlbum]);
    }
}
