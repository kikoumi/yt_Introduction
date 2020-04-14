<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    //いいねした人とどの動画にいいねしたか
    protected $fillable = [
        'user_id','post_id'
    ];

    public function post()
    {
        return $this->belongsTo(\App\Post::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

}
