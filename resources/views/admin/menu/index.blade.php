<!DOCTYPE html>
<html>

<head>
    <title>Kelola Menu - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAVBAR (SAMA PERSIS DASHBOARD) -->
        <nav class="w-full bg-red-800 shadow-md rounded-b-xl">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('/image/logo-indomie.png') }}" class="h-10 w-auto">
                    <p class="text-white font-bold text-2xl tracking-tighter">
                        WARMINDO
                        <span class="font-light text-sm bg-yellow-400 text-red-800 px-2 py-0.5 rounded ml-2">
                            MENU
                        </span>
                    </p>
                </div>

            </div>
        </nav>

        <!-- MAIN -->
        <div class="flex justify-center px-4 py-10">

            <div class="w-full max-w-6xl bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl p-6 md:p-10 border border-white/20">

                <!-- HEADER -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">

                    <h1 class="text-3xl font-extrabold text-gray-800">
                        🍜 Kelola Menu & Stok
                    </h1>

                    <div class="flex gap-3">

                        <a href="{{ route('admin.menu.create') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl shadow font-semibold transition">
                            + Tambah Menu
                        </a>

                        <a href="{{ route('admin.category.create') }}"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl shadow font-semibold transition">
                            + Tambah Category
                        </a>

                    </div>

                </div>

                <!-- SUCCESS ALERT -->
                @if(session('success'))
                <div class="mb-5 bg-green-100 text-green-700 p-3 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
                @endif

                <!-- TABLE -->
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="p-4 text-left rounded-l-xl">Image</th>
                                <th class="p-4 text-left">Nama</th>
                                <th class="p-4 text-left">Kategori</th>
                                <th class="p-4 text-left">Harga Jual</th>
                                <th class="p-4 text-left">Harga Beli</th>
                                <th class="p-4 text-center">Stok</th>
                                <th class="p-4 text-center">Tambah</th>
                                <th class="p-4 text-center rounded-r-xl">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach($menus as $menu)

                            <tr class="hover:bg-red-50/40 transition">


                                <!-- IMAGE -->
                                <td class="p-10">

                                    <form action="{{ route('admin.menu.updateImage', $menu->id) }}"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="flex items-start gap-3">

                                        @csrf

                                        <!-- Preview -->
                                        <img src="{{ asset('image/' . $menu->image) }}?v={{ time() }}"
                                            class="w-12 h-12 rounded-lg object-cover border shadow">

                                        <!-- Form Upload -->
                                        <div class="flex flex-col gap-2">

                                            <input type="file"
                                                name="image"
                                                accept="image/*"
                                                class="text-xs border rounded-lg p-1 w-36">

                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                                                Save
                                            </button>

                                        </div>

                                    </form>

                                </td>

                                <!-- NAMA -->
                                <td class="p-3">
                                    <form action="{{ route('admin.menu.updateName', $menu->id) }}" method="POST"
                                        class="flex gap-2 items-center">
                                        @csrf

                                        <input type="string"
                                            name="name"
                                            value="{{ $menu->name }}"
                                            class="w-24 border rounded-lg px-2 py-1 text-center">

                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs">
                                            Save
                                        </button>
                                    </form>
                                </td>

                                <!-- KATEGORI -->
                                <td class="p-4 text-gray-600">
                                    {{ $menu->category->name ?? '-' }}
                                </td>

                                <!-- HARGA -->
                                <!-- HARGA JUAL -->
                                <td class="p-4">
                                    <form action="{{ route('admin.menu.updatePrice', $menu->id) }}" method="POST"
                                        class="flex gap-2 items-center">
                                        @csrf

                                        <input type="number"
                                            name="price"
                                            value="{{ $menu->price }}"
                                            class="w-24 border rounded-lg px-2 py-1 text-center">

                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs">
                                            Save
                                        </button>
                                    </form>
                                </td>

                                <!-- HARGA BELI -->
                                <td class="p-4">
                                    <form action="{{ route('admin.menu.harga_beli', $menu->id) }}" method="POST"
                                        class="flex gap-2 items-center">
                                        @csrf

                                        <input type="number"
                                            name="harga_beli"
                                            value="{{ $menu->harga_beli }}"
                                            class="w-24 border rounded-lg px-2 py-1 text-center">

                                        <button class="bg-blue-500 text-white px-3 py-1 rounded-lg text-xs">
                                            Save
                                        </button>
                                    </form>
                                </td>

                                <!-- STOK -->
                                <td class="p-4 text-center font-bold text-gray-800">
                                    {{ $menu->stock }}
                                </td>

                                <!-- TAMBAH STOK -->
                                <td class="p-4">

                                    <form method="POST"
                                        action="/admin/menu/update-stock/{{ $menu->id }}"
                                        class="flex justify-center gap-2">

                                        @csrf

                                        <input type="number"
                                            name="stock"
                                            min="1"
                                            class="w-16 border rounded-lg px-2 py-1 text-center focus:ring-2 focus:ring-green-500">

                                        <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg">
                                            +
                                        </button>

                                    </form>

                                </td>

                                <!-- AKSI -->
                                <td class="p-4 text-center">

                                    <form action="{{ route('admin.menu.delete', $menu->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus menu ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @if($menus->isEmpty())
                <div class="text-center py-20 text-gray-400">
                    🍽️ Belum ada menu
                </div>
                @endif

            </div>

        </div>
        <div class="flex gap-3 pb-7">

            <a href="{{ route('admin.report') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl shadow font-semibold transition ml-7">
                Laporan
            </a>

        </div>
    </div>

</body>

</html>