<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori | QueenStatic Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>

         <link rel="icon" type="image/png" href="{{ asset('images/Removebg.png') }}">

</head>

<style>
    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeSlideRight {
        from {
            opacity: 0;
            transform: translateX(-100px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }


    .hidden-before-anim {
        opacity: 0;
    }

    .animate-fadeSlideUp {
        animation: fadeSlideUp 1s ease forwards;
    }

    .animate-fadeSlideRight {
        animation: fadeSlideRight 1s ease forwards;
    }
</style>

<body class="bg-gray-100 text-black min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-300 flex flex-col justify-between shadow-md animate-fadeSlideRight">
            <div>
                <div class="p-10 border-b border-gray-300">
                    <h1 class="text-2xl font-bold tracking-wide mb-2">QueenStatic Shop</h1>

                    @if (auth()->check())
                        <span class="text-gray-600 text-sm">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                    @else
                        <span class="text-red-600 text-sm font-semibold">Kamu belum login!</span>
                        <script>
                            window.onload = function () {
                                alert("⚠️ Kamu belum login! Silakan login dulu ya~");
                                window.location.href = "{{ route('login') }}";
                            };
                        </script>
                    @endif
                    
                </div>

                <nav class="mt-6 flex flex-col gap-2 px-4">
                    <a href="/dashboard"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        <span>🏠</span> Dashboard
                    </a>
                    
                    <a href="{{ route('barang.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 font-semibold hover:bg-gray-300 transition">
                        <span>📦</span> Kelola Barang
                    </a>

                    <a href="{{ route('transaksi.index') }}" class="fex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        <span>🛍️</span> Transaksi
                    </a>
                </nav>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-300">
                @csrf
                <button type="submit"
                    class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition">Logout</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-300 animate-fadeSlideUp">
                <h2 class="text-3xl font-bold mb-6 text-center">Tambah Kategori</h2>

                <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold mb-2">Nama Kategori</label>
                        <input 
                            type="text" 
                            id="nama_kategori" 
                            name="nama_kategori" 
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Masukkan nama kategori..." 
                            required>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('kategori.index') }}" 
                           class="text-gray-500 hover:text-black transition">← Kembali</a>

                        <button 
                            type="submit" 
                            class="bg-black hover:bg-gray-800 text-white font-semibold px-5 py-2 rounded-lg transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
