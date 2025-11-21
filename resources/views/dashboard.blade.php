<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | QueenStatic Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/Removebg.png') }}">

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
            animation: fadeSlideUp 3s ease forwards;
        }

        .animate-fadeSlideRight {
            animation: fadeSlideRight 3s ease forwards;
        }
    </style>
</head>

<body class="bg-gray-100 text-black min-h-screen">

    <div class="flex min-h-screen">

        <!-- sidebar -->
        <aside
            class="w-64 bg-white border-r border-gray-300 flex flex-col justify-between shadow-md fixed top-0 left-0 h-full animate-fadeSlideRight">
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
                        class="justify-between w-full px-5 py-2 rounded-lg bg-gray-200 font-semibold hover:bg-gray-300 transition">
                        <span>🏠</span> Dashboard
                    </a>

                    <div>
                        <button onclick="toggleSubMenu()"
                            class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
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
                    class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition transform hover:scale-105">
                    Logout
                </button>
            </form>
        </aside>

        <!-- main content -->
        <main class="flex-1 p-10 ml-64 overflow-y-auto">
            <h2 class="text-3xl font-bold mb-6 animate-fadeSlideUp">Selamat Datang di Dashboard</h2>

            <!-- statistik ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 animate-fadeSlideUp delay-1 hover:shadow-xl hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Pendapatan Hari Ini</h3>
                    <p class="text-2xl font-bold text-black-600">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 animate-fadeSlideUp delay-2 hover:shadow-xl hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Pendapatan Bulan Ini</h3>
                    <p class="text-2xl font-bold text-black-600">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 animate-fadeSlideUp delay-3 hover:shadow-xl hover:scale-105 transition">
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">Transaksi Hari Ini</h3>
                    <p class="text-2xl font-bold text-black-600">{{ $jumlahTransaksiHariIni }} Transaksi</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- top 5 best seller -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 animate-fadeSlideUp delay-4 hover:shadow-xl transition transform hover:scale-105">
                    <h3 class="text-2xl font-bold mb-4">Top 5 Best Seller</h3>
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="p-3 border border-gray-300">Peringkat</th>
                                <th class="p-3 border border-gray-300">Merek</th>
                                <th class="p-3 border border-gray-300">Total Terjual (pcs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bestSeller as $index => $item)
                                <tr class="hover:bg-gray-100 transition transform hover:scale-[1.02]">
                                    <td class="p-3 border border-gray-300 font-semibold">{{ $item->barang->nama_barang }}
                                    </td>
                                    <td class="p-3 border border-gray-300">
                                        {{ $item->barang->merek->nama_merek ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="p-3 border border-gray-300">{{ $item->total_terjual }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 p-4">Belum ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- analisis stok hampir habis -->
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 animate-fadeSlideUp delay-5 hover:shadow-xl transition transform hover:scale-105">
                    <h3 class="text-2xl font-bold mb-4 text-black-600">(Analisis Stok Hampir Habis)</h3>
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="p-3 border border-gray-300">Nama Barang</th>
                                <th class="p-3 border border-gray-300">Merek</th>
                                <th class="p-3 border border-gray-300">Sisa Stok (pcs)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stokHabis as $barang)
                                <tr class="hover:bg-gray-100 transition transform hover:scale-[1.02]">
                                    <td class="p-3 border border-gray-300">{{ $barang->nama_barang }}</td>
                                    <td class="p-3 border border-gray-300">{{ $barang->merek->nama_merek }}</td>
                                    <td class="p-3 border border-gray-300 text-red-600 font-semibold">{{ $barang->stok }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 p-4">Semua stok masih aman 👍</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- filter-->
            <div
                class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 mb-8 mt-10 animate-fadeSlideUp hover:shadow-xl transition">
                <h3 class="text-2xl font-bold mb-4 text-gray-700">Filter Pendapatan</h3>
                <form method="GET" action="{{ route('dashboard') }}"
                    class="flex flex-col md:flex-row items-center justify-start gap-8">
                    <div class="flex flex-col">
                        <label for="start_date" class="text-sm text-gray-600">Dari Tanggal:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('startDate') }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                    </div>
                    <div class="flex flex-col">
                        <label for="end_date" class="text-sm text-gray-600">Sampai Tanggal:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('endDate') }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                    </div>
                    <button type="submit"
                        class="bg-black text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-800 transition transform hover:scale-105 mt-4 md:mt-6">
                        Tampilkan
                    </button>
                </form>

                @if (request('start_date') && request('end_date'))
                    <div class="mt-6 border-t border-gray-300 pt-4 animate-fadeSlideUp">
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Rentang:
                            <span class="text-black">{{ \Carbon\Carbon::parse($startDate)->format('M d Y') }}</span> -
                            <span class="text-black">{{ \Carbon\Carbon::parse($endDate)->format('M d Y') }}</span>
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="bg-gray-100 p-4 rounded-lg border border-gray-300">
                                <p class="text-gray-600 text-sm font-semibold">Total Pendapatan:</p>
                                <p class="text-2xl font-bold text-black">Rp {{ number_format($filteredTotal, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg border border-gray-300">
                                <p class="text-gray-600 text-sm font-semibold">Jumlah Transaksi:</p>
                                <p class="text-2xl font-bold text-black">{{ $filteredTransaksi }} Transaksi</p>
                            </div>
                        </div>
                    </div>
                @endif
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