<!-- <!DOCTYPE html>
<html>

<head>
    <title>Preview Laporan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-2xl font-bold">
                 <!-- 📄 Preview Laporan Warmindo -->
                </h1>

                <p class="text-gray-500">
                    Tanggal:
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </p>
            </div>

            <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl">
                🖨 Print
            </button>

        </div>

        <!-- SUMMARY -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-green-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">Pendapatan</p>
                <p class="font-bold text-green-700">
                    Rp {{ number_format($income,0,',','.') }}
                </p>
            </div>

            <div class="bg-blue-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">Transaksi</p>
                <p class="font-bold text-blue-700">
                    {{ $totalTransaksi }}
                </p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">Profit</p>
                <p class="font-bold text-yellow-700">
                    Rp {{ number_format($profit,0,',','.') }}
                </p>
            </div>

            <div class="bg-purple-100 p-4 rounded-xl">
                <p class="text-sm text-gray-600">Barang Terjual</p>
                <p class="font-bold text-purple-700">
                    {{ $totalBarangTerjual }}
                </p>
            </div>

        </div>

        <!-- TOP MENU -->
        <h2 class="text-lg font-bold mb-3">
            🔥 Top Menu
        </h2>

        <table class="w-full border mb-6">

            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Menu</th>
                    <th class="border p-2">Terjual</th>
                </tr>
            </thead>

            <tbody>
                @foreach($topMenus as $menu)
                <tr>
                    <td class="border p-2">
                        {{ $menu->menu->name ?? '-' }}
                    </td>

                    <td class="border p-2 text-center">
                        {{ $menu->total }}
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- ACTIVITY -->
        <h2 class="text-lg font-bold mb-3">
            📋 Aktivitas
        </h2>

        <table class="w-full border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Jenis</th>
                    <th class="border p-2">Deskripsi</th>
                    <th class="border p-2">Qty</th>
                    <th class="border p-2">Nominal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($activities as $act)
                <tr>

                    <td class="border p-2">
                        {{ $act['jenis'] }}
                    </td>

                    <td class="border p-2">
                        {{ $act['deskripsi'] }}
                    </td>

                    <td class="border p-2 text-center">
                        {{ $act['qty'] ?? '-' }}
                    </td>

                    <td class="border p-2">
                        @if($act['nominal'])
                        Rp {{ number_format($act['nominal'],0,',','.') }}
                        @else
                        -
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</body>

</html> -->