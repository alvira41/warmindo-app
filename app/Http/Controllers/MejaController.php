<?php

namespace App\Http\Controllers;

use App\Models\Table;

class MejaController extends Controller
{
    public function index()
    {
        $mejas = Table::all();
        return view('mejas.index', compact('mejas'));
    }
}