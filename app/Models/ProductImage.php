<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'path',
        'preview_path',
        'is_main'
    ];

    protected $table = 'catalog_images';

    public function getPreviewPath() {
        return config('catalog.product.preview_path') . $this->path;
    }

    public function getPath() {
        return config('catalog.product.img_path') . $this->path;
    }
}
