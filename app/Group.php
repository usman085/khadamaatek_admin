<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name'];

    public function departments()
    {
        return $this->hasMany('App\Department');
    }

    public function getNameAttribute($value){
        return getFormatedName($value);
    }
    
    public function websites()
    {
        return $this->morphMany('App\Website', 'model');
    }

    public function logo()
    {
        return $this->morphOne('App\Logo', 'model');
    }
    
    public function setNameAttribute($value){
        $this->attributes['name'] = setFormatedName($value,$this->attributes);
    }
}
