<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = [
        'uid', 'title', 'description', 'photo', 'votes', 'category', 'user_name', 'user_nickname', 'user_location', 'user_profile', 'average_color', 'palette_color'
    ];

}
