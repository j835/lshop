<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'name',
        'code',
    ];

    public function items() 
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')->orderBy('sort');
    }
}
