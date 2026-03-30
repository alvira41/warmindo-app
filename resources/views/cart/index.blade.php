    <!DOCTYPE html>
    <html>
    <head>
        <title>Keranjang</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="relative min-h-screen bg-[url('/storage/bg.png')] bg-cover bg-center bg-no-repeat">

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="relative z-10">
            <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('storage/logo-indomie.png') }}" alt="Logo" class="h-10 w-auto">
                        <p class="text-white font-bold text-2xl">WARMINDO</p>
                    </div>
                </div>
            </nav>

            <div class="flex justify-center items-start px-4 py-10">
                <div class="w-full max-w-4xl bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-10">

                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-extrabold text-gray-800">🛒 Keranjang</h1>
                    </div>

                    @if(!empty($cart) && count($cart) > 0)
                        @php $grandTotal = 0; @endphp

                        <div class="overflow-x-auto">
                            <table class="w-full text-center">
                                <thead class="bg-gray-100 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-3 rounded-l-lg text-left">Menu</th>
                                        <th class="px-3">Harga</th>
                                        <th class="px-3">Qty</th>
                                        <th class="px-3 rounded-r-lg text-right">Total</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y">
                                    @foreach($cart as $id => $item)
                                        @php 
                                            $total = $item['harga'] * $item['qty'];
                                            $grandTotal += $total;
                                        @endphp

                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-4 px-3 font-medium text-left">
                                                {{ $item['nama_menu'] }}
                                            </td>
                                            <td class="px-3 text-gray-600">
                                                Rp {{ number_format($item['harga'],0,',','.') }}
                                            </td>
                                            <td class="px-3">
                                                <div class="flex items-center justify-center gap-3">
                                                    <form action="{{ route('cart.min', $id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-red-100 text-red-600 px-2 rounded hover:bg-red-200 transition">-</button>
                                                    </form>
                                                    
                                                    <span class="font-bold w-6 text-center">{{ $item['qty'] }}</span>
                                                    
                                                    <form action="{{ route('cart.add', $id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="bg-green-100 text-green-600 px-2 rounded hover:bg-green-200 transition">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="px-3 font-semibold text-red-600 text-right">
                                                Rp {{ number_format($total,0,',','.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 text-right text-xl font-bold text-gray-800">
                            Total: <span class="text-red-600">Rp {{ number_format($grandTotal,0,',','.') }}</span>
                        </div>

                        <form action="{{ route('checkout') }}" method="POST" class="mt-10">
                            @csrf
                            <div class="mb-6 text-left">
                                <label class="block text-gray-700 font-bold mb-2">Catatan Pesanan (Opsional):</label>
                                <textarea name="notes" rows="2" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition" 
                                        placeholder="Contoh: Indomie Gorengnya pedas sedang ya..."></textarea>
                            </div>

                            <input type="hidden" name="total" value="{{ $grandTotal }}">

                            <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                                <a href="{{ url('/menus') }}" 
                                class="w-full md:w-auto bg-gray-500 text-white px-8 py-3 rounded-xl hover:bg-gray-600 transition shadow-md text-center">
                                    ⬅ Kembali ke Menu
                                </a>
                                
                                <button type="submit" 
                                        class="w-full md:w-auto bg-green-600 text-white px-10 py-3 rounded-xl hover:bg-green-700 transition shadow-lg font-bold text-lg">
                                    🚀 Pesan Sekarang
                                </button>
                            </div>
                        </form>

                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600 text-xl mb-8">Keranjang masih kosong 🥲</p>
                            <a href="{{ url('/menus') }}" 
                            class="inline-block bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 transition shadow-md">
                                ⬅ Lihat Menu Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
    </html>