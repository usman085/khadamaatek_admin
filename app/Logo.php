<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    public function model()
    {
        return $this->morphTo();
    }
}
