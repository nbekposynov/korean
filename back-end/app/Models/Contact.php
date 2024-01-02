<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone_number', 'email', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
