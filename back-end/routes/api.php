<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Album
Route::get('/getAlbumPhoto', [AlbumController::class, 'index']);

//Posts
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/post/filter', [PostController::class, 'filter']);


//Journal
Route::get('/magazines/download/{id}', [ JournalController::class, 'downloadJournal']);
Route::get('/magazines/year/{year}/month/{month}', [JournalController::class, 'getByYearAndMonth']);
Route::get('/magazines/year/{year}', [JournalController::class, 'getByYear']);

//Book
Route::get('/book/getBook', [ BookController::class, 'getBook']);
Route::get('/book/download/{id}', [ BookController::class, 'downloadBook']);

//City
Route::get('/cities', [ContactController::class, 'index']);
Route::get('/cities/{city_id}/contacts', [ContactController::class, 'show']);

//Contact Us

Route::post('/send-phone',  [PhoneController::class, 'sendPhone']);
