<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'id', 'uid', 'photo_id', 'red', 'green', 'blue'
    ];
    protected $table = 'colors';
}
