<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Journal extends Model
{
    protected $fillable = ['name', 'publication_date', 'file', 'cover' ];

    use HasFactory;
    

}
