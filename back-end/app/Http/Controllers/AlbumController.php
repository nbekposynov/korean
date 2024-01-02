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
}
