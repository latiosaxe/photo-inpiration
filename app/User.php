<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name', 'email',
        'username', 'slug', 'lastname', 'description', 'avatar', 'cover', 'city', 'country', 'website', 'instagram', 'facebook', 'twitter',
        'can_travel', 'premium', 'template_id', 'views', 'active', 'password'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function galleries(){
        return $this->hasMany('App\Gallery');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }


}