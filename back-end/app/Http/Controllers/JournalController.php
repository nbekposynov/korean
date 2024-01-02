<?php

namespace App\Http\Controllers;
use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function getByYear($year) {
        $magazines = Journal::whereYear('publication_date', $year)->get();
    
        $magazines->transform(function ($magazine) {
            $cover = json_decode($magazine->cover, true);
            $file = json_decode($magazine->file, true);
    
            $magazine->cover = url('/storage/' . str_replace('\\', '/', $cover[0]['download_link']));
            $magazine->file = url('/storage/' . str_replace('\\', '/', $file[0]['download_link']));
    
    
            return $magazine;
        });
    
        return response()->json($magazines);
    }
    
    public function getByYearAndMonth($year, $month) {
        $magazines = Journal::whereYear('publication_date', $year)
                             ->whereMonth('publication_date', $month)
                             ->get();
    
        $magazines->transform(function ($magazine) {
            $cover = json_decode($magazine->cover, true);
            $file = json_decode($magazine->file, true);
    
            // Обновляем поля cover и file на URL'ы, используя функцию url()
            $magazine->cover = url('/storage/' . str_replace('\\', '/', $cover[0]['download_link']));
            $magazine->file = url('/storage/' . str_replace('\\', '/', $file[0]['download_link']));
    
            return $magazine;
        });
    
        return response()->json($magazines);
    }

    public function downloadJournal($id) {
        $magazine = Journal::findOrFail($id);
        $fileData = json_decode($magazine->file, true);
    
        // Check if the JSON is decoded properly and the required data is available

        $filePath = 'app/public/' . $fileData[0]['download_link'];
    
        if (!file_exists(storage_path($filePath))) {
            return response()->json('Ошибка не найден файл', 404);
        }
    
        return response()->download(storage_path($filePath));
    }
}
