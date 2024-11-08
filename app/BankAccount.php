<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['user_type', 'user_id', 'bank_name', 'account_title', 'account_no', 'sort_code'];

    public function userdata()
    {
        return $this->belongsTo('App\User');
    }

    public function user()
    {
        return $this->morphTo();
    }
}
