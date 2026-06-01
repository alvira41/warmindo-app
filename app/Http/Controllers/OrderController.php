<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // =========================
    // LIHAT SEMUA ORDER (ADMIN)
    // =========================
    public function index()
    {
        $orders = Order::with('orderDetails.menu')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    // =========================
    // DETAIL ORDER
    // =========================
    public function show($id)
    {
        $order = Order::with('orderDetails.menu')
            ->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    // =========================
    // UPDATE STATUS PESANAN
    // =========================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,done_payment'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Status berhasil diupdate');
    }

    // =========================
    // STATUS UNTUK PELANGGAN (HANYA 1 USER)
    // =========================
    public function status()
    {
        $orderId = session('last_order_id');

        if (!$orderId) {
            return redirect('/menu')->with('error', 'Tidak ada pesanan');
        }

        $orders = Order::with('orderDetails.menu')
            ->where('id', $orderId)
            ->get();

        return view('order.status', compact('orders'));
    }
public function updateStatusManual(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:menunggu,diproses,selesai,done_payment'
    ]);

    $order = Order::findOrFail($id);

    $order->update([
        'status' => $request->status
    ]);

    return back()->with(
        'success',
        'Status pesanan berhasil diupdate'
    );
}

public function print($id)
{
    $order = Order::with('details.menu')->findOrFail($id);

    return view('admin.order.print', compact('order'));
}
}