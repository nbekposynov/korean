<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koreilbo extends Model
{

    protected $fillable = ['name', 'description', 'desc', 'image'];


    use HasFactory;
}
