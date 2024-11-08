<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'schema'];

    public function forms()
    {
        return $this->hasMany('App\FormBuilder');
    }
    public function requiredTemplateDetail()
    {
        return $this->belongsTo('App\Document');
    }
    
    public function getNameAttribute($value){
        return getFormatedName($value);
    }
    
    public function setNameAttribute($value){
        $this->attributes['name'] = setFormatedName($value,$this->attributes);
    }
}
