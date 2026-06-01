<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Menu;
use App\Models\StockLog;

class CheckoutController extends Controller
{
    // =========================
    // CHECKOUT
    // =========================
    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with(
                'error',
                'Keranjang kosong'
            );
        }

        // =========================
        // NOTES
        // =========================
        $notes = $request->notes ?? null;

        // =========================
        // HITUNG TOTAL
        // =========================
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        // =========================
        // TRANSACTION CODE
        // =========================
        $transactionCode =
            'TRX-' .
            date('YmdHis') .
            rand(100, 999);

        // =========================
        // SIMPAN ORDER
        // =========================
        $order = Order::create([
            'transaction_code' => $transactionCode,
            'total_price' => $total,
            'status' => 'pending',
            'notes' => $notes,
            'payment_method' => null
        ]);

        // simpan session order terakhir
        session([
            'last_order_id' => $order->id
        ]);

        // =========================
        // SIMPAN DETAIL ORDER
        // =========================
        foreach ($cart as $id => $item) {

            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'qty' => $item['qty'],
                'price' => $item['price'],
                'notes' => $notes
            ]);

            // =========================
            // UPDATE STOCK
            // =========================
            $menu = Menu::find($id);

            if ($menu) {

                $menu->stock -= $item['qty'];

                $menu->save();

                // =========================
                // STOCK LOG
                // =========================
                StockLog::create([
                    'menu_id' => $id,
                    'qty' => $item['qty'],
                    'type' => 'out',
                    'note' => 'Penjualan - ' . $transactionCode
                ]);
            }
        }

        // =========================
        // CLEAR CART
        // =========================
        session()->forget('cart');

        return redirect()->route('order.status');
    }

    // =========================
    // STATUS ORDER
    // =========================
    public function status()
    {
        $orderId = session('last_order_id');

        if (!$orderId) {
            return redirect('/menu')->with(
                'error',
                'Order tidak ditemukan'
            );
        }

        $order = Order::with('details.menu')
            ->find($orderId);

        if (!$order) {
            return redirect('/menu')->with(
                'error',
                'Order tidak valid'
            );
        }

        return view(
            'order.status',
            compact('order')
        );
    }

    // =========================
    // HALAMAN PAYMENT
    // =========================
    public function payment($id)
    {
        $order = Order::with('details.menu')
            ->findOrFail($id);

        return view(
            'order.payment',
            compact('order')
        );
    }

    // =========================
    // PROCESS PAYMENT
    // =========================
    public function processPayment(Request $request, $id)
    {
        $order = Order::with('details.menu')
            ->findOrFail($id);

        // =========================
        // VALIDASI
        // =========================
        $request->validate([
            'payment_method' => 'required|in:cash,qris',
            'bayar' => 'nullable|numeric|min:0'
        ]);

        $total = $order->total_price;

        // =========================
        // CASH
        // =========================
        if ($request->payment_method == 'cash') {

            $bayar = $request->bayar;

            if ($bayar < $total) {

                return back()->with(
                    'error',
                    'Uang tidak cukup'
                );
            }

            $kembalian = $bayar - $total;

        } else {

            // =========================
            // QRIS
            // =========================
            $bayar = $total;
            $kembalian = 0;
        }

        // =========================
        // UPDATE ORDER
        // =========================
        $order->update([
            'status' => 'done_payment',
            'payment_method' => $request->payment_method
        ]);

        // =========================
        // REDIRECT PRINT
        // =========================
        return redirect()
            ->route('order.print', $order->id)
            ->with(
                'success',
                'Pembayaran berhasil'
            )
            ->with(
                'kembalian',
                $kembalian
            )
            ->with(
                'bayar',
                $bayar
            );
    }
}