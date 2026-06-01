<!DOCTYPE html>
<html>

<head>
    <title>Tambah Menu - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">

        <div class="w-full max-w-xl bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-8">

            <!-- TITLE -->
            <h1 class="text-2xl font-extrabold text-gray-800 mb-6 text-center">
                🍜 Tambah Menu
            </h1>

            <!-- FORM -->
            @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="space-y-4">

                @csrf

                <!-- NAMA -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama Menu</label>

                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                        placeholder="Contoh: Indomie Goreng"
                        required>
                </div>

                <!-- HARGA JUAL -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Harga Jual</label>

                    <input type="number" name="price"
                        value="{{ old('price') }}"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                        placeholder="Contoh: 12000"
                        required>
                </div>

                <!-- HARGA BELI -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Harga Beli</label>

                    <input type="number" name="harga_beli"
                        value="{{ old('harga_beli') }}"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        placeholder="Contoh: 3000"
                        required>
                </div>

                <!-- STOCK -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Stok</label>

                    <input type="number" name="stock"
                        value="{{ old('stock') }}"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none"
                        placeholder="Jumlah stok"
                        required>
                </div>

                <!-- CATEGORY -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Kategori</label>

                    <select name="category_id"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                        required>

                        <option value="">-- Pilih Kategori --</option>

                        @forelse($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @empty
                        <option disabled>Tidak ada kategori</option>
                        @endforelse

                    </select>

                    <div>
                        <div class="text-center py-6 px-4 border border-dashed border-gray-300 rounded-xl bg-gray-50">

                            <!-- ICON -->
                            <div class="text-sm text-gray-500 border-0">

                                <span>Kategori tidak ada</span>

                                <button type="button"
                                    onclick="document.getElementById('modalKategori').classList.remove('hidden')"
                                    class="text-red-600 hover:underline ml-1 border-0 bg-transparent">
                                    + Tambah
                                </button>

                            </div>
                        </div>

                        <!-- IMAGE -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Foto Menu</label>
                            <input type="file" name="image"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 bg-white">
                        </div>

                        <!-- BUTTON -->
                        <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-md transition">
                            Simpan Menu
                        </button>

            </form>
        </div>
    </div>

    <!-- ================= MODAL KATEGORI ================= -->
    <div id="modalKategori" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-md rounded-xl p-6 shadow-xl">

            <h2 class="text-lg font-bold mb-4">Tambah Kategori</h2>

            <form method="POST" action="{{ route('admin.category.store') }}">
                @csrf

                <input type="text" name="name"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 mb-4"
                    placeholder="Nama kategori"
                    required>

                <div class="flex justify-end gap-2">
                    <button type="button"
                        onclick="document.getElementById('modalKategori').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 rounded-lg">
                        Batal
                    </button>

                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</body>

</html>