<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // recursive, loads all descendants
    public function children()
    {
        return $this->subcategory()->with('children:id,name,slug,parent_id');
    }
}