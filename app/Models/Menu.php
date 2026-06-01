<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // 🔥 WAJIB
use App\Models\Category;

class Menu extends Model // 🔥 WAJIB EXTENDS
{
    protected $fillable = [
    'name',
    'price',
    'harga_beli',
    'stock',
    'category_id',
    'image'
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}