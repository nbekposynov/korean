<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBook() {
        $books = Book::all();
    
        $books->transform(function ($book) {
            $file = json_decode($book->file, true);
            $cover = json_decode($book->cover, true);
    
            // Добавляем URL к файлу книги внутри массива
            $file[0]['download_link'] = url('/storage/' . str_replace('\\', '/', $file[0]['download_link']));
    
            // Добавляем URL к обложке внутри массива
            $cover[0]['download_link'] = url('/storage/' . str_replace('\\', '/', $cover[0]['download_link']));
    
            // Обновляем поля file и cover с новыми URL
            $book->file = json_encode($file);
            $book->cover = json_encode($cover);
    
            // Удаляем ненужные поля или форматируем данные по желанию
            unset($book->created_at, $book->updated_at);
    
            return $book;
        });
    
        return response()->json($books);
    }
    
    public function downloadBook($id) {
        $book = Book::findOrFail($id);
        $fileData = json_decode($book->file, true);

        $filePath = 'app/public/' . $fileData[0]['download_link'];
    
        if (!file_exists(storage_path($filePath))) {
            return response()->json('Ошибка не найден файл', 404);
        }
    
        return response()->download(storage_path($filePath));
    }
}
