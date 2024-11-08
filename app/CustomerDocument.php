<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    public function document_template()
    {
        return $this->belongsTo('App\Document', 'document_id');
    }
    
    public function getNameAttribute($value){
        return getFormatedName($value);
    }
}
