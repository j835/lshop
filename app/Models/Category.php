<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
   use SoftDeletes;

    protected $table = 'catalog_categories';

    protected $fillable = [
        'name',
        'code',
        'full_code',
        'level',
        'parent_id',
        'sort',
        'image',
        'discount',
        'seo_description',
        'seo_keywords',
    ];

    public function products()
    {
        return $this->hasMany(Product::class)
        ->with(['category','main_image']);
    }

    public function catalog_products()
    {
        return $this->hasMany(Product::class)
        ->where('quantity', '>', 0)
        ->with(['category','main_image']);
    }


    public function subcategories() {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parentCategory() {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function getImagePath() 
    {
        return $this->image ? config('catalog.category.img_path') . $this->image : config('catalog.image_not_found');
    }
}
