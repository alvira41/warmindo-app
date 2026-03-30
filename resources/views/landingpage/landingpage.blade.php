<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warmindo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen overflow-x-hidden
             bg-[url('image/bg.png')] 
             bg-cover bg-center bg-no-repeat">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10">

        <!-- NAVBAR -->
        <nav class="w-full bg-red-800 shadow-md sticky top-0 z-30 rounded-b-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 sm:py-4 
                        flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('image/logo-indomie.png') }}" 
                         alt="Logo"
                         class="h-8 sm:h-10 md:h-12 w-auto">
                    <p class="text-white font-bold text-lg sm:text-xl md:text-2xl">
                        WARMINDO
                    </p>
                </div>
            </div>
        </nav>

        <!-- IMAGE -->
        <div class="w-full">
            <img src="{{ asset('image/warung.png') }}"
                 alt="warung"
                 class="w-full h-auto shadow-xl object-cover">
        </div>

        <!-- DESCRIPTION -->
        <div class="w-full bg-red-800 text-center px-4 py-4 sm:py-5">
            <p class="text-lg sm:text-lg md:text-md text-white px-8 py-4">
                Web ini adalah web pemesanan makanan di Warmindo.
                Ini akan mempermudah kamu untuk melakukan pemesanan
                dengan cepat dan praktis.
            </p>
        </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-12 
                        flex flex-col items-center text-center bg-white">

                <h2 class="text-xl sm:text-3xl md:text-4xl 
                           font-semibold mb-6">
                    KLIK FOR ORDER
                </h2>

                <a href="{{ url('/menu/category/{id}') }}"
                   class="px-6 py-3 bg-red-800 text-white 
                          font-semibold rounded-lg 
                          hover:bg-red-700 transition duration-300">
                    Menu
                </a>
            </div>

    </div>

</body>
</html>