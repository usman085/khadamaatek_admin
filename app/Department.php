<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'group_id'];

    public function getNameAttribute($value){
        return getFormatedName($value);
    }

    
    public function setNameAttribute($value){
        $this->attributes['name'] = setFormatedName($value,$this->attributes);
    }
    
    public function websites()
    {
        return $this->morphMany('App\Website', 'model');
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function logo()
    {
        return $this->morphOne('App\Logo', 'model');
    }
}
