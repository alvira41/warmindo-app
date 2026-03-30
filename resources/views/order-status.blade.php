<!DOCTYPE html>
<html>
<head>
    <title>Status Pesanan - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/public/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10">
        <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('/public/image/logo-indomie.png') }}" alt="Logo" class="h-10 w-auto">
                    <p class="text-white font-bold text-2xl">WARMINDO</p>
                </div>
                <a href="{{ url('/menus') }}" class="text-white text-sm hover:underline">Tambah Pesanan</a>
            </div>
        </nav>

        <div class="flex justify-center items-start px-4 py-10">
            <div class="w-full max-w-2xl bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-6 md:p-10">
                
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black text-gray-800 tracking-tight">STUK PESANAN</h1>
                    <p class="text-gray-500 text-sm">Pantau pesananmu di sini ya!</p>
                </div>

                <div class="space-y-6">
                    @forelse($orders as $order)
                        @php
                            $badgeStyle = [
                                'pending'  => 'bg-gray-100 text-gray-600 border-gray-200',
                                'diproses' => 'bg-amber-100 text-amber-700 border-amber-200',
                                'selesai'  => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            ][$order->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp

                        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-black text-lg text-gray-800">#{{ $order->id }}</h3>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y | H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $badgeStyle }}">
                                    {{ $order->status }}
                                </span>
                            </div>

                            <div class="border-t border-dashed border-gray-200 pt-4 flex justify-between items-end">
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Catatan:</p>
                                    <p class="text-sm italic text-gray-600">"{{ $order->notes ?? 'Tidak ada catatan' }}"</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Total Bayar:</p>
                                    <p class="text-xl font-black text-red-600">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-400">Belum ada riwayat pesanan.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-10 pt-6 border-t border-gray-100">
                    <p class="text-center text-[10px] text-gray-400 italic">
                        *Silakan lakukan pembayaran di kasir saat pesanan berstatus SELESAI.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>