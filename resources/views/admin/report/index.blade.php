<!DOCTYPE html>
<html>

<head>
    <title>Laporan Aktivitas Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<script>
setInterval(() => {
    location.reload();
}, 10000); // refresh tiap 10 detik
</script>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAVBAR -->
        <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-3">
                <img src="{{ asset('/image/logo-indomie.png') }}" class="h-10">
                <p class="text-white font-bold text-2xl tracking-tighter">
                    WARMINDO
                    <span class="font-light text-sm bg-yellow-400 text-red-800 px-2 py-0.5 rounded ml-2">
                        KASIR
                    </span>
                </p>
            </div>
        </nav>

        <!-- CONTENT -->
        <div class="max-w-7xl mx-auto mt-10 px-4">

            <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 border border-white/20">

                <h1 class="text-2xl font-extrabold text-gray-800 mb-6">
                    📊 Laporan Aktivitas
                </h1>

                <!-- ================= FILTER ================= -->
                <form method="GET" class="flex flex-wrap gap-3 mb-6 items-end">

                    <div>
                        <label class="text-sm text-gray-600">Pilih Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}"
                            class="border p-2 rounded-xl focus:ring-2 focus:ring-red-500">
                    </div>

                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow">
                        Filter
                    </button>

                </form>

                <!-- ================= SUMMARY ================= -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

                    <div class="bg-green-100 p-4 rounded-xl text-center shadow">
                        <p class="text-sm text-gray-600">Pendapatan</p>
                        <h2 class="font-black text-lg text-green-700">
                            Rp {{ number_format($income ?? 0,0,',','.') }}
                        </h2>
                    </div>

                    <div class="bg-blue-100 p-4 rounded-xl text-center shadow">
                        <p class="text-sm text-gray-600">Transaksi</p>
                        <h2 class="font-black text-lg text-blue-700">
                            {{ $totalTransaksi ?? 0 }}
                        </h2>
                    </div>

                    <div class="bg-yellow-100 p-4 rounded-xl text-center shadow">
                        <p class="text-sm text-gray-600">Profit</p>
                        <h2 class="font-black text-lg text-yellow-700">
                            Rp {{ number_format($profit ?? 0,0,',','.') }}
                        </h2>
                    </div>

                    <div class="bg-purple-100 p-4 rounded-xl text-center shadow">
                        <p class="text-sm text-gray-600">Barang Terjual</p>
                        <h2 class="font-black text-lg text-purple-700">
                            {{ $totalBarangTerjual ?? 0 }}
                        </h2>
                    </div>

                </div>

               <!-- ================= AKTIVITAS ================= -->
<h2 class="text-lg font-bold mb-2">📋 Aktivitas Sistem</h2>

<div class="overflow-x-auto mb-8 rounded-xl border">
    <table class="w-full text-sm">

        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
            <tr class="text-center">
                <th class="p-3">Tanggal</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Metode</th>
                <th>Qty</th>
                <th>Nominal</th>
            </tr>
        </thead>

        <tbody>
            @forelse($activities as $item)

            <tr class="border-t text-center hover:bg-red-50 transition">

                <!-- TANGGAL -->
                <td class="p-2">
                    {{ \Carbon\Carbon::parse($item['tanggal'])->format('Y-m-d H:i') }}
                </td>

                <!-- JENIS -->
                <td>
                    <span class="
                        @if($item['jenis'] == 'Penjualan')
                            text-purple-600 font-bold
                        @elseif($item['jenis'] == 'Tambah Stok')
                            text-green-600 font-bold
                        @elseif($item['jenis'] == 'Stok Berkurang')
                            text-red-600 font-bold
                        @endif
                    ">
                        {{ $item['jenis'] }}
                    </span>
                </td>

                <!-- DESKRIPSI -->
                <td>
                    {{ $item['deskripsi'] }}
                </td>

                <!-- METODE PEMBAYARAN -->
                <td>

                    @if(isset($item['payment_method']) && $item['payment_method'])

                        <span class="
                            @if($item['payment_method'] == 'qris')
                                text-blue-600
                            @else
                                text-green-600
                            @endif
                            font-bold
                        ">
                            {{ strtoupper($item['payment_method']) }}
                        </span>

                    @else
                        -
                    @endif

                </td>

                <!-- QTY -->
                <td>
                    {{ $item['qty'] ?? '-' }}
                </td>

                <!-- NOMINAL -->
                <td>

                    @if($item['nominal'])
                        Rp {{ number_format($item['nominal'],0,',','.') }}
                    @else
                        -
                    @endif

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="6" class="text-center p-4 text-gray-400">
                    Tidak ada data
                </td>
            </tr>

            @endforelse
        </tbody>

    </table>
</div>
                <!-- ================= INCOME ================= -->
                <h2 class="text-lg font-bold mb-2">📈 Income Harian</h2>

                <div class="overflow-x-auto mb-8 rounded-xl border">
                    <table class="w-full text-sm">

                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr class="text-center">
                                <th class="p-3">Tanggal</th>
                                <th>Total Pendapatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($incomeHarian as $date => $total)
                            <tr class="border-t text-center hover:bg-green-50 transition">
                                <td class="p-2">{{ $date }}</td>
                                <td class="font-bold text-green-700">
                                    Rp {{ number_format($total,0,',','.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center p-4 text-gray-400">
                                    Tidak ada data
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- ================= ACTION BUTTON ================= -->
                <div class="flex gap-3">

                    <!-- BACK -->
                    <a href="{{ route('admin.menu') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl shadow">
                        ← Kembali
                    </a>

                    <!-- PREVIEW PDF -->
                    <a href="{{ route('admin.report.preview', ['date' => $date]) }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow">
                        👁 Preview PDF
                    </a>

                    <!-- DOWNLOAD PDF -->
                    <a href="{{ route('admin.report.download', ['date' => $date]) }}"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow">
                        ⬇ Download PDF
                    </a>

                </div>

            </div>
        </div>

    </div>

</body>

</html>