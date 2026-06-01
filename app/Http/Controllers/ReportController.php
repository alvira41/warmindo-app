<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockLog;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // =========================
    // GET REPORT DATA
    // =========================
    private function getReportData($date)
    {
        // ORDER
        $orders = Order::whereDate('created_at', $date)->get();

        // ORDER DETAIL
        $orderDetails = OrderDetail::with('menu')
            ->whereDate('created_at', $date)
            ->get();

        // STOCK LOG
        $logs = StockLog::with('menu')
            ->whereDate('created_at', $date)
            ->get();

        // TOP MENU
        $topMenus = OrderDetail::select(
            'menu_id',
            DB::raw('SUM(qty) as total')
        )
            ->with('menu')
            ->whereDate('created_at', $date)
            ->groupBy('menu_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // PROFIT
        $profit = $orderDetails->sum(function ($item) {
            return ($item->price - ($item->menu->harga_beli ?? 0))
                * $item->qty;
        });

        // ACTIVITIES
        $activities = collect();

        // STOCK ACTIVITY
        foreach ($logs as $log) {
            $activities->push([
                'tanggal' => $log->created_at,
                'jenis' => $log->note ?? (
                    $log->type == 'in'
                    ? 'Tambah Stok'
                    : 'Stok Berkurang'
                ),
                'deskripsi' => $log->menu->name ?? '-',
                'qty' => $log->qty,
                'nominal' => null
            ]);
        }

        // SALES ACTIVITY
        foreach ($orders as $order) {
            $activities->push([
                'tanggal' => $order->created_at,
                'jenis' => 'Penjualan',
                'deskripsi' =>
                $order->transaction_code .
                    ' (' . strtoupper($order->payment_method) . ')',
                'qty' => null,
                'nominal' => $order->total_price
            ]);
        }

        // SORT
        $activities = $activities->sortByDesc('tanggal')->values();

        // INCOME HARIAN
        $incomeHarian = $orders->groupBy(function ($item) {
            return Carbon::parse($item->created_at)
                ->format('Y-m-d');
        })->map(function ($day) {
            return $day->sum('total_price');
        });

        return [
            'date' => $date,
            'orders' => $orders,
            'orderDetails' => $orderDetails,
            'logs' => $logs,
            'topMenus' => $topMenus,
            'activities' => $activities,
            'income' => $orders->sum('total_price'),
            'profit' => $profit,
            'totalTransaksi' => $orders->count(),
            'totalBarangTerjual' => $orderDetails->sum('qty'),
            'stockIn' => $logs->where('type', 'in')->sum('qty'),
            'stockOut' => $logs->where('type', 'out')->sum('qty'),
            'incomeHarian' => $incomeHarian
        ];
    }

    // =========================
    // HALAMAN REPORT
    // =========================
    public function index(Request $request)
    {
        $date = $request->date
            ?? Carbon::today()->toDateString();

        $data = $this->getReportData($date);

        return view('admin.report.index', $data);
    }

    // =========================
    // DOWNLOAD PDF
    // =========================
    public function downloadPDF(Request $request)
    {
        $date = $request->date
            ?? Carbon::today()->toDateString();

        $data = $this->getReportData($date);

        $pdf = Pdf::loadView('admin.report.pdf', $data);

        return $pdf->download('laporan-warmindo.pdf');
    }

    // =========================
    // PREVIEW PDF
    // =========================
    // =========================
    // PREVIEW PDF (STREAM)
    // =========================
    public function previewPDF(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        // ambil semua data report
        $data = $this->getReportData($date);

        // generate pdf dari view
        $pdf = Pdf::loadView('admin.report.pdf', $data);

        // preview di browser
        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'inline; filename="laporan-warmindo.pdf"'
            );
    }
}
