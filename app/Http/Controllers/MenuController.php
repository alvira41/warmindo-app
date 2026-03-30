<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($meja = null)
    {
        // Kalau ada parameter meja dari QR
        if ($meja) {
            session(['meja_id' => $meja]);
        }

        $menus = Menu::all();
        return view('menus.index', compact('menus'));
    }

    public function byCategory($id)
    {
        $menus = Menu::where('category_id', $id)->get();
        return view('menus.index', compact('menus'));
    }
}
