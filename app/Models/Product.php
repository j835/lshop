<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'catalog_products';

    protected $fillable = [
        'name',
        'code',
        'category_id',
        'description',
        'sort',
        'price',
        'new_price',
        'discount',
        'is_active',
    ];

    public function getActualPrice() {
        $price = $this->price;

        if($this->category->discount) {
            $new_price = $price * ( 100 - $this->category->discount ) / 100;
        }
        if($this->discount) {
            $new_price = $price * ( 100 - $this->discount ) / 100;
        }
        if($this->new_price) {
            $new_price = $this->new_price;
        }

        return isset($new_price) ? $new_price : $price;
    }


    public function getMainImagePreviewPath() {
        if($this->getRelation('main_image')) {
            return $this->getRelation('main_image')->getPreviewPath();
        } else {
            return config('catalog.image_not_found');
        }
    }

    public function getFullLink() {
        return '/' . config('catalog.path') . '/' . $this->category->full_code . '/' . $this->code . '/';
    }

    public function getSeoKeywords() {
        if($this->getAttribute('seo_keywords')) {
            return $this->getAttribute('seo_keywords');
        } else if($this->getRelation('category')->getAttribute('seo_keywords')) {
            return $this->getRelation('category')->getAttribute('seo_keywords');
        } else {
            return false;
        }
    }

    public function getSeoDescription() {
        if($this->getAttribute('seo_description')) {
            return $this->getAttribute('seo_description');
        } else if($this->getRelation('category')->getAttribute('seo_description')) {
            return $this->getRelation('category')->getAttribute('seo_description');
        } else {
            return false;
        }
    }



    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function main_image() {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')
            ->where('is_main', 1);
    }

    public function images() {
        return $this->hasMany(ProductImage::class,'product_id', 'id');
    }



}
