<!DOCTYPE html>
<html>

<head>
    <title>Struk Pesanan</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
        }

        .struk {
            width: 300px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        hr {
            border: 1px dashed #000;
        }

        table {
            width: 100%;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="struk">

        <h2>STRUK PESANAN</h2>
        <p class="center">Terima kasih sudah pesan 🙏</p>

        <hr>
        <p> {{ $order->transaction_code }}</p>
        <p><b>Order ID:</b> {{ $order->id }}</p>
        <p><b>Tanggal:</b> {{ $order->created_at }}</p>

        <hr>

        <table>
            @foreach($order->details as $detail)
            <tr>
                <td>{{ $detail->menu->name }}</td>
                <td class="center">{{ $detail->qty }}</td>
                <td class="center">Rp {{ number_format($detail->price) }}</td>
            </tr>
            @endforeach
        </table>

        <hr>

        <p><b>Total:</b> Rp {{ number_format($order->total_price) }}</p>
        <p>
            Metode Pembayaran:
            <strong>
                {{ strtoupper($order->payment_method) }}
            </strong>
        </p>
        <p>Bayar: Rp {{ number_format(session('bayar'),0,',','.') }}</p>
        <p>Kembalian: Rp {{ number_format(session('kembalian'),0,',','.') }}</p>


    </div>

<a href="{{ route('admin.dashboard') }}"
   class="w-full sm:w-auto px-8 py-3 bg-white/10 text-white font-semibold 
          rounded-xl border border-white/20 hover:bg-white/20 
          transition duration-300">
    Selesai
</a>


</body>

</html>