<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // =========================
    // LIHAT CART
    // =========================
    public function index()
    {
        $cart = session('cart', []);
        $note = session('note', ''); // 🔥 NOTE

        return view('cart.index', compact('cart', 'note'));
    }

    // =========================
    // TAMBAH KE CART
    // =========================

    public function add(Request $request, $id)
    {

        $menu = Menu::findOrFail($id);

        $cart = session()->get('cart', []);

        $notes = $request->notes_pesanan; // 🔥 AMBIL NOTES

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;

            // 🔥 update notes kalau ada
            if ($notes) {
                $cart[$id]['notes'] = $notes;
            }
        } else {
            $cart[$id] = [
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => 1,
                'notes' => $notes // 🔥 SIMPAN NOTES
            ];
        }

        session()->put('cart', $cart);

        return back();
    }

    // =========================
    // MINUS ITEM
    // =========================
    public function minus($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);

        return back();
    }

    // =========================
    // DELETE ITEM
    // =========================
    public function delete($id)
    {
        $cart = session()->get('cart', []);

        unset($cart[$id]);

        session()->put('cart', $cart);

        return back();
    }

    // =========================
    // SIMPAN NOTE
    // =========================
    public function saveNote(Request $request)
    {
        session(['note' => $request->notes]);
        return back();
    }

    // =========================
    // CLEAR CART
    // =========================
    public function clear()
    {
        session()->forget(['cart', 'note']);
        return back();
    }

    
}
