<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i', strtotime($date));
    }

    public function getJsonDataAttribute($data)
    {
        return json_decode($data, true);
    }

    public function user()
    {
        return $this->morphTo('user');
    }
}
