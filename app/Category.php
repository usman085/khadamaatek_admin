<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable  = ['name', 'parent_id'];

    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id');
    }

    public function getNameAttribute($value){
        return getFormatedName($value);
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = setFormatedName($value,$this->attributes);
    }

    static public function categoryTree(Category $editCat){
        $category = $editCat;
        if($category->parent_id){
            $category->categories = Category::where('parent_id', $category->parent_id)->get();
            $catTree = [$category];
            while($category->parent_id){
                $selected_id = $category->id;
                $category = Category::find($category->parent_id);
                if($category){
                    $category->selected_id = $selected_id;
                    if($category->parent_id){
                        $category->categories = Category::where('parent_id', $category->parent_id)->get();
                    }else{
                        $category->categories = Category::where('department_id', $category->department_id)->whereNull('parent_id')->get();
                    }
                }
                array_unshift($catTree, $category);
            }
        }else{
            $category->categories = Category::where('department_id', $category->department_id)->whereNull('parent_id')->get();
            $catTree = [$category];
        }
        return $catTree;
    }

    public function parent_category()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function websites()
    {
        return $this->morphMany('App\Website', 'model');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function logo()
    {
        return $this->morphOne('App\Logo', 'model');
    }
}
