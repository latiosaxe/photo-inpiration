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
    public function follows(){
        return $this->hasMany('App\Follow', 'user_id_from', 'id');
    }
    protected $following_list = null;
    public function getFollowingListIdsAttribute($id){
        if($this->following_list !== null){
            return $this->following_list;
        }else{
            $users = $this->follows()->get();
            $return = [];
            foreach ($users as $user){
                $return[] = $user->user_id_to;
            }
            return $return;
        }
    }

}