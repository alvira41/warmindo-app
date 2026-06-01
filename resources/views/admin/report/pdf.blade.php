<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Warmindo</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .total {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h2>LAPORAN PENJUALAN WARMWINDO</h2>

    <div class="info">
        <p>Tanggal: {{ $date }}</p>
        <p>Total Transaksi: {{ $totalTransaksi }}</p>
        <p>Total Income: Rp {{ number_format($income) }}</p>
        <p>Total Barang Terjual: {{ $totalBarangTerjual }}</p>
    </div>

    <h3>Top Menu</h3>
    <table>
        <tr>
            <th>Menu</th>
            <th>Terjual</th>
        </tr>
        @foreach($topMenus as $menu)
        <tr>
            <td>{{ $menu->menu->name ?? '-' }}</td>
            <td>{{ $menu->total }}</td>
        </tr>
        @endforeach
    </table>

    <h3 style="margin-top:20px;">Aktivitas</h3>
    <table>
        <tr>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Qty</th>
            <th>Nominal</th>
        </tr>

        @foreach($activities as $act)
        <tr>
            <td>{{ $act['jenis'] }}</td>
            <td>{{ $act['deskripsi'] }}</td>
            <td>{{ $act['qty'] ?? '-' }}</td>
            <td>
                {{ $act['nominal'] ? 'Rp '.number_format($act['nominal']) : '-' }}
            </td>
        </tr>
        @endforeach

    </table>

</body>

</html>