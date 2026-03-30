<!DOCTYPE html>
<html>
<head>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
</head>
<body class="relative min-h-screen 
             bg-[url('/image/bg.png')] 
             bg-cover bg-center bg-no-repeat">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50 "></div>

    <div class="relative z-10">

<nav class="w-full bg-red-800 shadow-md top-0 z-30 rounded-b-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 
                flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('/image/logo-indomie.png') }}" 
                 alt="Logo"
                 class="h-8 sm:h-10 md:h-12 w-auto">
            <p class="text-white font-bold 
                      text-lg sm:text-xl md:text-2xl">
                WARMINDO
            </p>
        </div>
        <a href="{{ url('/cart') }}" 
           class="relative">
            <img 
                src="{{ asset('image/cart.png') }}" 
                alt="Cart"
                class="w-8 sm:w-10 md:w-12 h-8 sm:h-10 md:h-12 cursor-pointer hover:scale-110 transition duration-200">
        </a>

    </div>
</nav>

<div class="max-w-7xl mx-auto px-6 py-10">
    
    <h1 class="text-3xl font-bold text-gray-800 py-10 text-center">
        Daftar Menu
    </h1>

    <!-- Tombol Kategori (Tidak Perlu Foreach) -->
    <div class="flex flex-wrap gap-3 mb-6 justify-center md:justify-start">
        <a href="{{ url('/menu/category/1') }}" 
           class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-700">
            Mie Kuah
        </a>

        <a href="{{ url('/menu/category/2') }}" 
           class="bg-amber-500 text-white px-4 py-2 rounded hover:bg-amber-500 transition">
            Mie Goreng
        </a>

        <a href="{{ url('/menu/category/3') }}" 
           class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Toping
        </a>

        <a href="{{ url('/menu/category/4') }}" 
           class="bg-amber-700 text-white px-4 py-2 rounded hover:bg-amber-700 transition">
            Minuman hangat
        </a>

        <a href="{{ url('/menu/category/5') }}" 
           class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Minuman Dingin
        </a>
    </div>

    <!-- Grid Menu -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($menus as $menu)
            <div class="bg-white p-4 rounded-xl shadow-md">
                <img src="{{ asset('image/'.$menu->image) }}" 
                     class="w-full h-40 object-contain rounded-lg">

                <h3 class="mt-3 font-semibold text-lg">
                    {{ $menu->nama_menu }}
                </h3>

                <p class="text-green-600 font-bold">
                    Rp {{ number_format($menu->harga,0,',','.') }}
                </p>
<div class="mt-3 flex items-center gap-2">

    <!-- Tombol Kurang -->
    <form action="{{ route('cart.min', $menu->id) }}" method="POST">
        @csrf
        <button type="submit"
                class="bg-gray-300 px-3 py-1 rounded">
            -
        </button>
    </form>

    <!-- Qty -->
    <span class="font-semibold">
        {{ session('cart')[$menu->id]['qty'] ?? 0 }}
    </span>

    <!-- Tombol Tambah -->
    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
        @csrf
        <button type="submit"
                class="bg-red-700 text-white px-3 py-1 rounded">
            +
        </button>
    </form>

</div>
            </div>
        @empty
        @endforelse

    </div>
       <div class="pt-10 ml-6">
       <a href="/landingpage"
        class="w-12 h-12 bg-red-800 rounded-full flex items-center justify-center text-white text-2xl  hover:bg-red-700 transition">
    ←
  </a>
</div>
</div>

</body>
</html>
