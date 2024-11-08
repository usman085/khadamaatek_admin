<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{

    protected $fillable = ['id', 'order_id', 'dataModel'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
