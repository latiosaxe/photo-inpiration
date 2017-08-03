<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes'; 
    protected $fillable = [
        'photo_id', 'ip', 'region'
    ];
}
