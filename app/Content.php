<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'id', 'type', 'type_id', 'active'
    ];
    protected $table = 'contents';

    public function photo(){
        return $this->belongsTo('App\Photo', 'type_id', 'id');
    }
    public function galllery(){
        return $this->belongsTo('App\Gallery', 'type_id', 'id');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }

}
