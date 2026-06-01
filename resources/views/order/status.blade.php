<!DOCTYPE html>
<html>

<head>
    <title>Status Pesanan - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<script>
setInterval(() => {
    location.reload();
}, 3000); // refresh tiap 3 detik
</script>

<body class="min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center">

    <!-- overlay -->
    <div class="fixed inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAV -->
        <nav class="sticky top-0 bg-red-800/90 backdrop-blur-md shadow-md">
            <div class="max-w-4xl mx-auto px-4 py-4 flex items-center gap-3">
                <img src="{{ asset('/image/logo-indomie.png') }}" class="h-10">
                <p class="text-white font-bold text-xl">WARMINDO</p>
            </div>
        </nav>

        <!-- CONTENT -->
        <div class="max-w-2xl mx-auto px-4 py-8">

            <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-5 sm:p-8">

                <!-- TITLE -->
                <div class="text-center mb-8">
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-800">
                        STATUS PESANAN
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Pantau pesanan kamu secara real-time
                    </p>
                </div>

                @if($order)

                @php
                $statusColor = [
                'pending' => 'bg-gray-100 text-gray-700',
                'diproses' => 'bg-yellow-100 text-yellow-700',
                'selesai' => 'bg-green-100 text-green-700',
                'done_payment' => 'bg-blue-100 text-blue-700',
                ][$order->status] ?? 'bg-gray-100 text-gray-700';
                @endphp

                <!-- CARD -->
                <div class="bg-white border rounded-2xl shadow-sm p-5">

                    <!-- HEADER -->
                    <div class="flex justify-between items-start">

                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold">
                                No Transaksi
                            </p>

                            <h2 class="text-lg font-bold text-gray-800">
                                {{ $order->transaction_code }}
                            </h2>

                            <p class="text-xs text-gray-400">
                                {{ $order->created_at->format('d M Y - H:i') }}
                            </p>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColor }}">
                            {{ $order->status }}
                        </span>

                    </div>

                    <!-- LIST MENU -->
                    <div class="mt-5 border-t pt-4 space-y-2">

                        <p class="text-xs text-gray-400 uppercase font-bold mb-2">
                            Detail Pesanan
                        </p>

                        @foreach($order->details as $detail)

                        <div class="flex justify-between text-sm">

                            <span class="text-gray-700">
                                {{ $detail->menu->name }} <span class="text-gray-400">x{{ $detail->qty }}</span>
                            </span>

                            <span class="font-medium">
                                Rp {{ number_format($detail->price * $detail->qty, 0, ',', '.') }}
                            </span>

                        </div>

                        @endforeach

                    </div>

                    <!-- NOTES + TOTAL -->
                    <div class="mt-5 border-t pt-4 flex flex-col sm:flex-row justify-between gap-4">

                        <!-- NOTES -->
                        @if($order->notes)
                        <div class="text-sm italic text-gray-600">
                            {{ $order->notes }}
                        </div>
                        @else
                        <div class="text-sm text-gray-400">
                            Tidak ada catatan
                        </div>
                        @endif

                        <!-- TOTAL -->
                        <div class="text-right">

                            <p class="text-xs text-gray-400 uppercase font-bold">
                                Total
                            </p>

                            <p class="text-2xl font-black text-red-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </p>

                        </div>

                    </div>

                </div>

                <!-- INFO -->
                <p class="text-xs sm:text-sm text-gray-400 text-center mt-6">
                    *Silakan bayar dan ambil pesanan di kasir setelah status <b>selesai</b>
                </p>

                @else

                <div class="text-center text-gray-400 py-10">
                    Tidak ada data pesanan 🥲
                </div>

                @endif

            </div>

        </div>

    </div>

</body>

</html>