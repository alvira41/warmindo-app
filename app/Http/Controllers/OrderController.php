<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu; 
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

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

   public function checkout(Request $request)
{

    try {
        Order::create([
            'notes'  => $request->notes,
            'total'  => $request->total,
            'status' => 'pending',
        ]);

        session()->forget('cart');

        return redirect()->route('order.status')->with('success', 'Pesanan sedang disiapkan!');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}

 public function admin()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();

        return view('admin.index', compact('orders'));
    }

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
    $orders = Order::orderBy('created_at', 'desc')->get(); 
    return view('order-status', compact('orders'));
}
}