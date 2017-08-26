<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id', 'user_id', 'content_id', 'active', 'text'
    ];
    protected $table = 'comments';

    public function content(){
        return $this->belongsTo('App\Content');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
