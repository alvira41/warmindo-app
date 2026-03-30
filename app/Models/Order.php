<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'orders';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'notes',
        'total',
        'status',
    ];
}