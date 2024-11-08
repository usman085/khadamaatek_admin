<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberChangeRequest extends Model
{
    protected $fillable = ['customer_id', 'old_number', 'new_number', 'reason'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function relatedUser()
    {
        return $this->morphTo('user');
    }
}
