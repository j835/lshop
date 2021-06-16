<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
   // use HasFactory;

    protected $table = 'order_products';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'product_quantity',
    ];


    public function productInfo() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
