<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyCustomer extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'user_id');
    }
}
