<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = ['id'];

    protected $table = 'movies';
    
    protected $casts = [
        'genre' => 'array'
    ];
   
   
}
