<!DOCTYPE html>
<html>
<head>
    <title>Daftar Meja</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-gray-100">

    <h1 class="text-3xl font-bold mb-8 text-center">
        Daftar QR Meja
    </h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach($mejas as $meja)

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="font-bold mb-4 text-lg">
                    Meja {{ $meja->nomor_meja }}
                </h2>

                {!! QrCode::size(200)->generate(url('/menu/'.$meja->id)) !!}

                <p class="mt-3 text-sm text-gray-600">
                    Scan untuk memesan
                </p>
            </div>

        @endforeach

    </div>

</body>
</html>