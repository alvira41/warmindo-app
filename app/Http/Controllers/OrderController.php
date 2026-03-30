<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu; 
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // 1. Menampilkan Halaman Keranjang Pelanggan
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // 2. Fungsi Tambah Item ke Keranjang
    public function add($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                "nama_menu" => $menu->nama_menu,
                "qty" => 1,
                "harga" => $menu->harga,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu ditambahkan!');
    }

    // 3. Fungsi Kurangi Item di Keranjang
    // ... bagian atas tetap sama ...

    // 3. Fungsi Kurangi Item (Ubah nama dari menus menjadi minus agar tidak bingung)
    public function minus($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($cart[$id]['qty'] > 1) {
                $cart[$id]['qty']--;
            } else {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);
        return redirect()->back();
    }

    // 4. Fungsi Checkout (Simpan ke Database)
   public function checkout(Request $request)
{
    // ... kode validasi dan pengecekan cart tetap sama ...

    try {
        Order::create([
            'notes'  => $request->notes,
            'total'  => $request->total,
            'status' => 'pending',
        ]);

        // Hapus isi keranjang setelah dipesan
        session()->forget('cart');

        // PERBAIKAN DI SINI: Arahkan ke halaman order status
        return redirect()->route('order.status')->with('success', 'Pesanan sedang disiapkan!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}

    // 5. Menampilkan Dashboard Admin (Halaman Kasir)
 public function adminDashboard()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        // Pastikan nama file adalah resources/views/admin.blade.php
        return view('admin.index', compact('orders'));
    }

    // 6. Update status pesanan (Untuk Manual Refresh/PHP)
    public function updateStatusManual(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }

    public function orderStatus()
{
    // Mengambil pesanan terbaru milik pelanggan (atau semua pesanan)
    $orders = Order::orderBy('created_at', 'desc')->get(); 
    return view('order-status', compact('orders'));
}
}