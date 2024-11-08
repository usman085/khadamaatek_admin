<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'category_id', 'department_id'];

    public function getNameAttribute($value){
        return getFormatedName($value);
    }
    
    public function setNameAttribute($value){
        $this->attributes['name'] = setFormatedName($value,$this->attributes);
    }
    
    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function websites()
    {
        return $this->morphMany('App\Website', 'model');
    }

    public function logo()
    {
        return $this->morphOne('App\Logo', 'model');
    }

    public function serviceLogo()
    {
        return $this->morphOne('App\Logo', 'model');
    }
    
    public function template()
    {
        return $this->belongsTo('App\RequirementTemplate', 'formbuilder_id');
    }
}
