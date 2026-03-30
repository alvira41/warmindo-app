<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/storage/bg.png')]  bg-cover bg-center bg-no-repeat">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10">
        <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('storage/logo-indomie.png') }}" alt="Logo" class="h-10 w-auto">
                    <p class="text-white font-bold text-2xl tracking-tighter">
                        WARMINDO <span class="font-light text-sm bg-yellow-400 text-red-800 px-2 py-0.5 rounded ml-2">KASIR</span>
                    </p>
                </div>
                <a href="{{ url('/menus') }}" class="text-white hover:text-yellow-400 transition text-sm font-medium">
                    Lihat Menu →
                </a>
            </div>
        </nav>

        <div class="flex justify-center items-start px-4 py-10">
            <div class="w-full max-w-6xl bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-10 border border-white/20">
                
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <h1 class="text-3xl font-extrabold text-gray-800">
                        📋 Pesanan Masuk
                    </h1>
                    <div class="bg-red-50 text-red-700 px-4 py-2 rounded-lg border border-red-100 text-sm font-bold">
                        Total Pesanan: {{ $orders->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="py-4 px-3 rounded-l-xl">No</th>
                                <th class="px-3 text-left">Pelanggan & Waktu</th>
                                <th class="px-3 text-left">Catatan Khusus</th>
                                <th class="px-3">Total Tagihan</th>
                                <th class="px-3">Status</th>
                                <th class="px-3 rounded-r-xl">Update Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach($orders as $index => $order)
                                @php
                                    $badgeColor = [
                                        'pending'  => 'bg-gray-500',
                                        'diproses' => 'bg-amber-400 text-black',
                                        'selesai'  => 'bg-emerald-600',
                                    ][$order->status] ?? 'bg-gray-400';
                                @endphp
                                
                                <tr class="hover:bg-red-50/50 transition-colors group">
                                    <td class="px-4 py-5 text-center text-sm text-gray-400 font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-4 py-5 text-left">
                                        <div class="text-sm font-extrabold text-gray-900">ID #{{ $order->id }}</div>
                                        <div class="text-[10px] text-gray-400 flex items-center gap-1">
                                            🕒 {{ $order->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-5 text-left">
                                        <p class="text-sm italic text-gray-600 bg-gray-50 p-2 rounded-lg border border-dashed border-gray-200">
                                            "{{ $order->notes ?? 'Tidak ada catatan' }}"
                                        </p>
                                    </td>
                                    <td class="px-4 py-5 text-center">
                                        <span class="text-sm font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            Rp {{ number_format($order->total, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-5 text-center">
                                        <span class="inline-block text-white text-[10px] uppercase font-black px-3 py-1 rounded-full shadow-sm {{ $badgeColor }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-5">
                                        <form action="{{ route('admin.order.update', $order->id) }}" method="POST">
                                            @csrf
                                            <select name="status" 
                                                    onchange="this.form.submit()" 
                                                    class="cursor-pointer border border-gray-300 rounded-xl px-3 py-2 text-xs font-bold w-full focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all shadow-sm bg-white hover:border-red-400">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                                                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>🔥 Dimasak</option>
                                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->isEmpty())
                    <div class="text-center py-20">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-gray-400 font-medium">Belum ada pesanan yang masuk.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</body>
</html>