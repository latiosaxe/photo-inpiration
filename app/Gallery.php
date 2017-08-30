<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'id', 'user_id', 'name', 'description', 'active', 'slug'
    ];
    protected $table = 'galleries';

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function photos(){
        return $this->hasMany('App\Gallery_Photo');
    }

    public function content(){
        return $this->hasOne('App\Content', 'type_id');
    }

}
