<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\UserService;


class Order extends Model
{
    // use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'user_id',
        'total',
        'is_cancelled',
        'is_paid',
        'message'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }


    
}
