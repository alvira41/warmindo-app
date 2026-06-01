<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Warmindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="fixed inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAVBAR -->
        <nav class="sticky top-0 bg-red-800/90 backdrop-blur-md shadow-md">
            <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

                <div class="flex items-center gap-3">
                    <img src="{{ asset('/image/logo-indomie.png') }}" class="h-10">
                    <p class="text-white font-bold text-lg sm:text-xl">WARMINDO</p>
                </div>

                <a href="{{ url('/cart') }}" class="relative">
                    <img src="{{ asset('image/cart.png') }}" class="w-9 h-9 sm:w-10 sm:h-10">

                    @if(session('cart'))
                    <span class="absolute -top-2 -right-2 bg-yellow-400 text-black text-xs px-2 rounded-full">
                        {{ count(session('cart')) }}
                    </span>
                    @endif
                </a>

            </div>
        </nav>

        <!-- CONTENT -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

            <h1 class="text-2xl sm:text-4xl font-bold text-center text-white mb-6">
                Daftar Menu 🍜
            </h1>

            <!-- CATEGORY -->
            <div class="flex gap-2 overflow-x-auto pb-3 mb-6 scrollbar-hide">

                @foreach($categories as $category)

                <a href="{{ url('/menu/category/'.$category->id) }}"
                    class="whitespace-nowrap px-4 py-2 bg-red-700 text-white rounded-full
                      hover:bg-red-600 transition text-sm sm:text-base">
                    {{ $category->name }}
                </a>

                @endforeach

            </div>

            <!-- GRID MENU -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                @forelse($menus as $menu)

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:scale-[1.02] transition">

                    <div class="p-3">
                        <img src="{{ asset('image/'.$menu->image) }}"
                            class="w-full h-40 object-contain">

                        <h3 class="mt-3 font-semibold text-lg">
                            {{ $menu->name }}
                        </h3>

                        <p class="text-green-600 font-bold">
                            Rp {{ number_format($menu->price,0,',','.') }}
                        </p>

                        <p class="text-xs text-gray-500">
                            Stok: {{ $menu->stock }}
                        </p>
                    </div>

                    <!-- QTY CONTROL -->
                    <div class="flex items-center justify-between px-4 pb-4">

                        <!-- minus -->
                        <form action="{{ route('cart.minus', $menu->id) }}" method="POST">
                            @csrf
                            <button class="w-9 h-9 rounded-full bg-red-100 text-red-600 font-bold text-lg">
                                -
                            </button>
                        </form>

                        <!-- qty -->
                        <span class="font-semibold text-lg">
                            {{ session('cart')[$menu->id]['qty'] ?? 0 }}
                        </span>

                        <!-- plus -->
                        <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                            @csrf
                            <button class="w-9 h-9 rounded-full bg-green-600 text-white font-bold text-lg">
                                +
                            </button>
                        </form>

                    </div>

                </div>

                @empty

                <div class="col-span-full text-center text-white">
                    Menu kosong 😢
                </div>

                @endforelse

            </div>

        </div>

    </div>

</body>

</html>