<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables'; // pastikan pakai tabel ini

    protected $fillable = [
        'nomor_meja'
    ];
}