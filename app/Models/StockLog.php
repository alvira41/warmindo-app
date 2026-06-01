<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'menu_id',
        'qty',
        'type',
        'note'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}