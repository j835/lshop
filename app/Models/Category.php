<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   // use HasFactory;

    protected $table = 'catalog_categories';

    protected $fillable = [
        'name',
        'code',
        'full_code',
        'level',
        'parent_id',
        'sort',
        'image',
        'is_active',
        'discount',
        'seo_description',
        'seo_keywords',
    ];


    public function products()
    {
        return $this->hasMany(Product::class)->with(['category','main_image'])
            ->where('is_active', '=', true);
    }


    public function subcategories() {
        return $this->hasMany(Category::class, 'parent_id', 'id')
            ->where('is_active', '=', true);
    }


}
