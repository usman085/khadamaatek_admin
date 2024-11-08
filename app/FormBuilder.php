<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormBuilder extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'schema'];

    public function services()
    {
        return $this->hasMany('App\Service', 'formbuilder_id');
    }
}
