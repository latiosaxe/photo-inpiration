<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery_Photo extends Model
{
    protected $table = 'gallery_photo';
    protected $fillable = [
        'id', 'gallery_id', 'photo_id'
    ];


    public function gallery(){
        return $this->belongsTo('App\Gallery');
    }
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
