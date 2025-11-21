<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | QueenStatic Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out forwards;
        }
    </style>

    <link rel="icon" type="image/png" href="{{ asset('images/Removebg.png') }}">

</head>

<body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen flex items-center justify-center">

    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-2xl w-96 fade-in">
        <h2 class="text-3xl font-bold text-center text-white mb-6 tracking-wide">QueenStatic Shop</h2>

        @if ($errors->any())
            <div class="bg-red-500/20 text-red-200 p-3 rounded mb-4 border border-red-400">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-300 font-medium mb-2">Email</label>
                <input type="email" name="email"
                    class="w-full px-4 py-2 border border-gray-500 rounded-lg bg-gray-900 text-white placeholder-gray-500 focus:ring-2 focus:ring-white outline-none transition"
                    placeholder="contoh@email.com" required>
            </div>

            <div>
                <label class="block text-gray-300 font-medium mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-2 border border-gray-500 rounded-lg bg-gray-900 text-white placeholder-gray-500 focus:ring-2 focus:ring-white outline-none transition"
                    placeholder="••••••••" required>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="bg-white text-gray-900 font-semibold px-20 py-2 rounded-lg shadow-lg hover:bg-gray-200 transition duration-300">
                    Login
                </button>
            </div>

        </form>
    </div>

    <footer class="absolute bottom-3 text-gray-500 text-sm">
        © {{ date('Y') }} QueenStatic Shop
    </footer>

</body>

</html>