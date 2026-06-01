<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warmindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen overflow-x-hidden bg-[url('image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="fixed inset-0 bg-black/60"></div>

    <div class="relative z-10">

        <!-- NAVBAR -->
        <nav class="sticky top-0 z-50 bg-red-800/90 backdrop-blur-md shadow-md">
            <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0">

                <!-- logo -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo-indomie.png') }}"
                        class="h-9 sm:h-12 w-auto" alt="logo">

                    <h1 class="text-white font-bold text-lg sm:text-2xl tracking-wide text-center sm:text-left">
                        WARMINDO
                    </h1>
                </div>

                <!-- login -->
                <a href="{{ url('/login') }}"
                    class="w-full sm:w-auto text-center px-6 sm:px-8 py-2 sm:py-3 bg-white/10 text-white font-semibold 
                          rounded-xl border border-white/20 hover:bg-white/20 
                          transition duration-300">
                    Admin Access
                </a>

            </div>
        </nav>

        <!-- HERO -->
        <section class="max-w-6xl mx-auto px-4 py-8 sm:py-16 text-center">

            <!-- image -->
            <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10">
                <img src="{{ asset('image/warung.png') }}"
                    class="w-full h-[180px] sm:h-[350px] object-cover"
                    alt="warung">
            </div>

            <!-- text -->
            <div class="mt-6 sm:mt-8 bg-white/10 backdrop-blur-md rounded-2xl p-5 sm:p-10 text-white shadow-lg">

                <h2 class="text-xl sm:text-4xl font-bold mb-3 sm:mb-4">
                    Makan Enak, Order Cepat ⚡
                </h2>

                <p class="text-sm sm:text-base text-white/90 leading-relaxed">
                    Web ini adalah platform pemesanan makanan di Warmindo.
                    Kamu bisa pesan dengan lebih cepat, praktis, dan tanpa ribet.
                </p>

                <p class="text-sm sm:text-base text-white/90 leading-relaxed mt-2">
                    Buka setiap hari 24 JAM
                </p>

                <!-- CTA -->
                <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">

                    <a href="{{ route('menu') }}"
                        class="w-full sm:w-auto text-center px-6 sm:px-8 py-3 bg-red-600 text-white font-semibold 
                          rounded-xl shadow-md hover:bg-red-500 hover:scale-105 
                          transition duration-300">
                        Lihat Menu 🍜
                    </a>

                </div>

            </div>

        </section>

    </div>

</body>

</html>