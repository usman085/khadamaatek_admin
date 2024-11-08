<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public function relatedUser()
    {
        return $this->morphTo('user');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'user_id');
    }
}
