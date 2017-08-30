<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'id', 'user_id_from', 'user_id_to', 'active'
    ];
    protected $table = 'follows';

    public function user(){
        return $this->belongsToMany('App\User', 'user_id_to', 'id');
    }
}
