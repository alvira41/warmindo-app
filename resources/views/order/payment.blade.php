<!DOCTYPE html>
<html>

<head>
    <title>Pembayaran - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAVBAR -->
        <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('/image/logo-indomie.png') }}" class="h-10">
                    <p class="text-white font-bold text-2xl tracking-tighter">
                        WARMINDO
                        <span class="font-light text-sm bg-yellow-400 text-red-800 px-2 py-0.5 rounded ml-2">
                            KASIR
                        </span>
                    </p>
                </div>
            </div>
        </nav>

        <!-- CONTENT -->
        <div class="flex justify-center items-center px-4 py-12">

            <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 border border-white/20">

                <h2 class="text-2xl font-extrabold text-gray-800 mb-6 text-center">
                    💳 Pembayaran
                </h2>

                <!-- DETAIL PESANAN -->
                <div class="border rounded-xl mb-5 overflow-hidden">

                    <div class="bg-gray-100 px-4 py-3 font-bold text-gray-700">
                        🛒 Detail Pesanan
                    </div>

                    <div class="divide-y">

                        @foreach($order->details as $detail)

                        <div class="flex justify-between items-center px-4 py-3">

                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $detail->menu->name ?? 'Menu Dihapus' }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    {{ $detail->qty }} x
                                    Rp {{ number_format($detail->price,0,',','.') }}
                                </p>

                                @if($detail->notes)
                                <p class="text-xs text-gray-400 italic">
                                    Catatan: {{ $detail->notes }}
                                </p>
                                @endif
                            </div>

                            <div class="font-bold text-red-600">
                                Rp {{ number_format($detail->qty * $detail->price,0,',','.') }}
                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>
                <!-- TOTAL -->
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5 text-center">
                    <p class="text-sm text-gray-500">Total Tagihan</p>
                    <h3 class="text-2xl font-black text-red-600">
                        Rp {{ number_format($order->total_price,0,',','.') }}
                    </h3>
                </div>

                <form method="POST" action="{{ route('order.pay', $order->id) }}">
                    @csrf

                    <!-- TOTAL HIDDEN -->
                    <input type="hidden" id="total" value="{{ $order->total_price }}">

                    <!-- METODE PEMBAYARAN -->
                    <div class="mb-4">

                        <label class="block mb-2 font-semibold text-gray-700">
                            Metode Pembayaran
                        </label>

                        <select name="payment_method"
                            class="w-full border border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-red-500"
                            required>

                            <option value="">-- Pilih Metode --</option>

                            <option value="cash">
                                Cash
                            </option>

                            <option value="qris">
                                QRIS
                            </option>

                        </select>

                    </div>

                    <!-- INPUT BAYAR -->
                    <input type="number" name="bayar" id="bayar"
                        class="w-full border border-gray-300 p-3 rounded-xl mb-4 focus:ring-2 focus:ring-red-500 outline-none"
                        placeholder="Masukkan uang pelanggan" required>

                    <!-- KEMBALIAN -->
                    <input type="text" id="kembalian"
                        class="w-full border p-3 rounded-xl mb-4 bg-gray-100 font-bold text-center"
                        placeholder="Kembalian" readonly>

                    <!-- BUTTON -->
                    <button class="bg-green-600 hover:bg-green-700 text-white w-full py-3 rounded-xl font-bold shadow">
                        Bayar & Cetak Struk
                    </button>

                </form>

                <!-- BACK -->
                <a href="{{ url()->previous() }}"
                    class="block text-center mt-4 text-sm text-gray-500 hover:text-red-500">
                    ← Kembali
                </a>

            </div>

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {

        const bayarInput = document.getElementById('bayar');
        const kembalianInput = document.getElementById('kembalian');
        const total = parseInt(document.getElementById('total').value) || 0;

        bayarInput.addEventListener('input', function() {

            let bayar = parseInt(this.value) || 0;
            let kembali = bayar - total;

            if (this.value === '') {
                kembalianInput.value = '';
                return;
            }

            if (kembali < 0) {
                kembalianInput.value = "❌ Uang kurang!";
                kembalianInput.classList.remove("text-green-600");
                kembalianInput.classList.add("text-red-500");
            } else {
                kembalianInput.value = "Rp " + kembali.toLocaleString('id-ID');
                kembalianInput.classList.remove("text-red-500");
                kembalianInput.classList.add("text-green-600");
            }

        });

    });
    </script>

</body>

</html>