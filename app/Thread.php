<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //one thead heva many messages 
    public function message(){
        return $this->belongsToMany('App\Message')->withTimestamps();
    }

    public function recipients(){
        //recipients is middle table name 
        return $this->belongsToMany('App\User','recipients')->withTimestamps();
        //return $this->belongsToMany('App\User','recipients','thread_id', 'user_id')->withTimestamps();
    }

    
}
