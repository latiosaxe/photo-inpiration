<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $fillable = [
        'uid', 'title', 'description', 'photo', 'votes', 'category', 'user_name', 'user_nickname', 'user_location', 'user_profile', 'average_color', 'palette_color',
        'views', 'watermark', 'user_id', 'featured', 'gallery_id'
    ];

    public function galleries(){
        return $this->hasMany('App\Gallery');
    }

    public function content(){
        return $this->hasOne('App\Content', 'type_id');
    }
}
