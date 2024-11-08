<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use SoftDeletes;

    protected $fillable = ['website_name', 'website_url', 'service_id', 'department_id'];

    public function relatedModels()
    {
        return $this->morphTo();
    }
}
