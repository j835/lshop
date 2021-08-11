<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'link',
        'sort',
        'menu_id'
    ];
}
