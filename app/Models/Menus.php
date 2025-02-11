<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';
    public $timestamps = false;

    public function roles()
    {
        return $this->hasMany(Menurole::class);
    }
}
