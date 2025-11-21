<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori | QueenStatic Shop</title>
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
        <aside
            class="w-64 bg-white border-r border-gray-300 flex flex-col justify-between shadow-md animate-fadeSlideRight">
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

                    <div>
                        <button onclick="toggleSubMenu()"
                            class="flex items-center justify-between w-full px-4 py-2 rounded-lg bg-gray-200 font-semibold hover:bg-gray-300 transition">
                            <span class="flex items-center gap-2">
                                <span>📦</span> Kelola Barang
                            </span>
                            <svg id="arrowIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor"
                                class="w-5 h-5 transform transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="subMenu" class="overflow-hidden max-h-0 transition-all duration-500 ease-in-out ml-8">
                            <div class="flex flex-col gap-1 mt-1">
                                <a href="{{ route('barang.index') }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    📋 Daftar Barang
                                </a>
                                <a href="{{ route('kategori.index') }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    ➕ Tambah Kategori
                                </a>
                                <a href="{{ route('merek.index') }}"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                    🏷️ Tambah Merek
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        🛍️ Transaksi
                    </a>
                </nav>

            </div>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-300">
                @csrf
                <button type="submit"
                    class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition">
                    Logout
                </button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10">
            <div
                class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-300 animate-fadeSlideUp">
                <h2 class="text-3xl font-bold mb-6 text-center">Edit Kategori</h2>

                @if($errors->any())
                    <div class="bg-red-600 text-white p-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold mb-2">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                            class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-black"
                            placeholder="Masukkan nama kategori..." required>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('kategori.index') }}" class="text-gray-500 hover:text-black transition">
                            ← Kembali
                        </a>

                        <button type="submit"
                            class="bg-black hover:bg-gray-800 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // submenu toggle    
        let isOpen = false;

        function toggleSubMenu() {
            const subMenu = document.getElementById('subMenu');
            const arrow = document.getElementById('arrowIcon');

            if (isOpen) {
                subMenu.style.maxHeight = "0px";
                arrow.classList.remove('rotate-180');
            } else {
                subMenu.style.maxHeight = subMenu.scrollHeight + "px";
                arrow.classList.add('rotate-180');
            }

            isOpen = !isOpen;
        }
    </script>
</body>

</html>