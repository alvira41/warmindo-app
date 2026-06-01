<!DOCTYPE html>
<html>

<head>
    <title>Keranjang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center">

    <!-- overlay -->
    <div class="fixed inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAV -->
        <nav class="sticky top-0 bg-red-800/90 backdrop-blur-md shadow-md">
            <div class="max-w-5xl mx-auto px-4 py-4 flex items-center gap-3">
                <img src="{{ asset('image/logo-indomie.png') }}" class="h-10">
                <p class="text-white font-bold text-xl">WARMINDO</p>
            </div>
        </nav>

        <!-- CONTENT -->
        <div class="max-w-3xl mx-auto px-4 py-6">

            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl p-5">

                <h1 class="text-xl sm:text-2xl font-bold text-center mb-6">
                    🛒 Keranjang Kamu
                </h1>

                @php $cart = $cart ?? []; @endphp

                @if(count($cart) > 0)

                @php $grandTotal = 0; @endphp

                <!-- ITEM LIST (CARD STYLE) -->
                <div class="space-y-4">

                    @foreach($cart as $id => $item)

                    @php
                    $price = $item['price'] ?? 0;
                    $qty = $item['qty'] ?? 0;
                    $total = $price * $qty;
                    $grandTotal += $total;
                    @endphp

                    <div class="bg-white border rounded-xl p-4 shadow-sm">

                        <!-- nama + harga -->
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-base sm:text-lg">
                                    {{ $item['name'] ?? '-' }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Rp {{ number_format($price,0,',','.') }}
                                </p>
                            </div>

                            <p class="font-bold text-green-600 text-sm sm:text-base">
                                Rp {{ number_format($total,0,',','.') }}
                            </p>
                        </div>

                        <!-- qty control -->
                        <div class="flex items-center justify-between mt-4">

                            <div class="flex items-center gap-3">

                                <form action="{{ route('cart.minus', $id) }}" method="POST">
                                    @csrf
                                    <button class="w-9 h-9 rounded-full bg-red-100 text-red-600 font-bold text-lg">
                                        -
                                    </button>
                                </form>

                                <span class="font-semibold text-lg">
                                    {{ $qty }}
                                </span>

                                <form action="{{ route('cart.add', $id) }}" method="POST">
                                    @csrf
                                    <button class="w-9 h-9 rounded-full bg-green-600 text-white font-bold text-lg">
                                        +
                                    </button>
                                </form>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>

                <!-- TOTAL BOX -->
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>Rp {{ number_format($grandTotal,0,',','.') }}</span>
                    </div>
                </div>

                <!-- CHECKOUT -->
                <form action="{{ route('checkout') }}" method="POST" class="mt-6 space-y-4">
                    @csrf

                    <textarea name="notes"
                        class="w-full border rounded-xl p-3 text-sm"
                        placeholder="Catatan pesanan..."></textarea>

                    <input type="hidden" name="total_bayar" value="{{ $grandTotal }}">

                    <div class="flex gap-3">

                        <a href="{{ url('/menu') }}"
                            class="flex-1 text-center bg-gray-500 text-white py-3 rounded-xl">
                            Kembali
                        </a>

                        <button type="submit"
                            class="flex-1 bg-green-600 text-white py-3 rounded-xl font-semibold">
                            Checkout
                        </button>

                    </div>
                </form>

                @else

                <p class="text-center text-gray-600 py-10">
                    Keranjang masih kosong 🥲
                </p>

                <div class="text-center">
                    <a href="{{ url('/menu') }}"
                        class="inline-block mt-4 bg-red-600 text-white px-6 py-2 rounded-xl">
                        Mulai Belanja
                    </a>
                </div>

                @endif

            </div>
        </div>

    </div>

</body>

</html>