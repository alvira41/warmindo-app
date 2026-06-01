<!DOCTYPE html>
<html>

<head>
    <title>Kategori - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-10">

        <div class="w-full max-w-3xl bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-8">

            <!-- TITLE -->
            <h1 class="text-2xl font-extrabold text-gray-800 text-center mb-6">
                📂 Kelola Kategori
            </h1>

            <!-- ALERT -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-xl text-center">
                {{ session('success') }}
            </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('admin.category.store') }}" class="space-y-4 mb-8">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama Kategori</label>
                    <input type="text" name="name"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2
                           focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
                        placeholder="Contoh: Makanan, Minuman, Snack"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl shadow-md transition">
                    Simpan Kategori
                </button>
            </form>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border rounded-xl overflow-hidden">

                    <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                        <tr>
                            <th class="p-3">No</th>
                            <th class="p-3">Nama Kategori</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($categories as $index => $category)

                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">{{ $index + 1 }}</td>

                            <td class="p-3 font-semibold text-gray-800">
                                {{ $category->name }}
                            </td>

                            <td class="p-3 text-center">

                                <form action="{{ route('admin.category.delete', $category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus kategori ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm shadow">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3" class="text-center p-4 text-gray-500">
                                Belum ada kategori
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <!-- BACK BUTTON -->
            <div class="mt-6 text-center">
                <a href="{{ route('admin.menu') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded-xl shadow">
                    ← Kembali ke Menu
                </a>
            </div>

        </div>

    </div>

</body>

</html>