<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Category;
use App\Models\StockLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // =========================
    // ACCESS CHECK
    // =========================
    private function checkAuth()
    {
        if (!session('user_id')) {
            abort(403);
        }

        if (!in_array(session('role'), ['admin', 'kasir'])) {
            abort(403);
        }
    }

    // =========================
    // DASHBOARD (KASIR)
    // =========================
    public function dashboard()
    {
        $this->checkAuth();

        if (session('role') !== 'kasir') {
            abort(403);
        }

        $orders = Order::latest()->get();

        return view('admin.dashboard', compact('orders'));
    }

    // =========================
    // MENU (ADMIN ONLY)
    // =========================
    public function menu()
    {
         // 🔐 CEK LOGIN ADMIN
         if (!session('user_id') || session('role') !== 'admin') {
             abort(403);
         }
    
         $menus = Menu::with('category')->get();
         $categories = Category::all();
    
         return view('admin.menu.index', compact('menus', 'categories'));
    }
     
    // =========================
    // UPDATE STOCK (ADMIN ONLY)
    // =========================
    public function updateStock(Request $request, $id)
     {
         $this->checkAuth();
   
         if (session('role') !== 'admin') {
             abort(403);
         }
   
         $request->validate([
             'stock' => 'required|integer|min:1'
         ]);
   
         $menu = Menu::findOrFail($id);
   
         // tambah stok
         $menu->stock += $request->stock;
         $menu->save();
   
         // =========================
         // LOG STOK MASUK (FIX DISINI)
         // =========================
         StockLog::create([
             'menu_id' => $id,
             'qty' => $request->stock,
             'type' => 'in',
             'note' => 'Penambahan stok oleh admin'
         ]);
   
         return back()->with('success', 'Stok berhasil ditambahkan');
     }
}    