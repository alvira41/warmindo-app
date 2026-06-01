<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Warmindo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative min-h-screen bg-[url('/image/bg.png')] bg-cover bg-center bg-no-repeat">

    <!-- overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4">

        <div class="w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 p-8">

            <!-- TITLE -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-extrabold text-gray-800">
                    🍜 WARMINDO
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Admin Login
                </p>
            </div>

            <!-- ERROR -->
            @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-xl border border-red-200 text-sm text-center">
                {{ session('error') }}
            </div>
            @endif

            <!-- INFO ATTEMPT -->
            @if(session('login_attempts') && !session('login_lock_time'))
            <div class="bg-yellow-100 text-yellow-700 p-3 mb-4 rounded-xl border border-yellow-200 text-sm text-center">
                Kesempatan login: {{ 3 - session('login_attempts') }} kali lagi
            </div>
            @endif

            <!-- LOCK INFO -->
            @if(session('login_lock_time') && now()->lessThan(session('login_lock_time')))
            <div class="bg-gray-200 text-gray-700 p-3 mb-4 rounded-xl border text-sm text-center">
                🔒 Akun dikunci sementara
            </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
                        placeholder="Masukkan email"
                        required>
                </div>

                <!-- PASSWORD -->
                <div class="relative">
                    <label class="text-sm font-semibold text-gray-700">Password</label>

                    <input type="password" name="password" id="password"
                        class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2 pr-12 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition"
                        placeholder="Masukkan password"
                        required>

                    <!-- TOGGLE -->
                    <button type="button"
                        onclick="togglePassword()"
                        class="absolute right-3 top-9 text-gray-500 hover:text-gray-700 text-lg">
                        👁️
                    </button>
                </div>

                <!-- BUTTON -->
                @if(session('login_lock_time') && now()->lessThan(session('login_lock_time')))
                <button disabled
                    class="w-full bg-gray-400 text-white font-bold py-2.5 rounded-xl shadow-md cursor-not-allowed">
                    Akun Dikunci
                </button>
                @else
                <button
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-md transition">
                    Login
                </button>
                @endif

            </form>

            <!-- FOOTER -->
            <p class="text-center text-xs text-gray-400 mt-6">
                © Warmindo Kasir System
            </p>

        </div>

    </div>

    <!-- SCRIPT -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');

            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>

</body>

</html>