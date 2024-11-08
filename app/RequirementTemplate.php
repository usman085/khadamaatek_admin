<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequirementTemplate extends Model
{
    use SoftDeletes;
    public function requirement_detail()
    {
        return $this->hasMany('App\RequirementTemplateDetail');
    }

    public function services()
    {
        return $this->hasMany('App\Service', 'formbuilder_id');
    }
}
