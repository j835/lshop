<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stores';

    protected $fillable = [
        'name',
        'code',
        'address',
        'city_id',
        'quantity',
    ];


    public function products() {
        return $this->belongsToMany(Product::class, 'product_store', 'store_id', 'product_id')
            ->withPivot(['quantity']);
    }

    public function getQuantity() {
        return $this->pivot->quantity;
    }
}
