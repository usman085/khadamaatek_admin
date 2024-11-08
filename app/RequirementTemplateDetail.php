<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequirementTemplateDetail extends Model
{
    public function requirement()
    {
        return $this->belongsTo('App\RequirementTemplate', 'requirement_template_id');
    }

    public function document()
    {
        return $this->belongsTo('App\Document');
    }
}
