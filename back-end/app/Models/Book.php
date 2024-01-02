<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Book extends Model
{
    protected $fillable = ['name', 'file', 'cover'];


    use HasFactory;


    public function getCoverAttribute($value)
    {
        return new Collection(json_decode($value, true));
    }

    public function getFileAttribute($value)
    {
        return new Collection(json_decode($value, true));
    }
}
