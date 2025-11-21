<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi | QueenStatic Shop</title>
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
                        class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
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
                        class="justify-between w-full px-4 py-2 rounded-lg bg-gray-200 font-semibold hover:bg-gray-300 transition">
                        🛍️ Transaksi
                    </a>
                </nav>

            </div>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-300">
                @csrf
                <button type="submit"
                    class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition">Logout</button>
            </form>
        </aside>

        <!-- main content -->
        <main class="flex-1 ml-64 p-10 overflow-y-auto animate-fadeSlideUp">
            <h2 class="text-3xl font-bold text-center mb-8">Detail Transaksi</h2>

            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 max-w-4xl mx-auto">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">ID Transaksi</p>
                        <p class="font-semibold text-lg">{{ $transaksi->id_transaksi }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tanggal Transaksi</p>
                        <p class="font-semibold text-lg">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('m d Y - H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Metode Transaksi</p>
                        <p class="font-semibold text-lg">{{ ucfirst($transaksi->metode_transaksi) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Kasir</p>
                        <p class="font-semibold text-lg">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h3 class="text-xl font-semibold mb-3">Detail Barang</h3>

                <table class="min-w-full text-sm border border-gray-300 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b text-left font-semibold">Nama Barang</th>
                            <th class="px-4 py-2 border-b text-center font-semibold">Quantity</th>
                            <th class="px-4 py-2 border-b text-right font-semibold">Harga(barang)</th>
                            <th class="px-4 py-2 border-b text-right font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->detail as $detail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $detail->barang->nama_barang ?? '-' }}</td>
                                <td class="px-4 py-2 border-b text-center">{{ $detail->qty }}</td>
                                <td class="px-4 py-2 border-b text-right">
                                    Rp {{ number_format($detail->barang->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 border-b text-right">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 border-t pt-4 space-y-2 text-right">
                    <p class="text-lg"><strong>Total:</strong>
                        Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                    </p>
                    <p class="text-lg"><strong>Jumlah Bayar:</strong>
                        Rp {{ number_format($transaksi->jumlah_bayar ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-lg"><strong>Kembalian:</strong>
                        Rp {{ number_format(($transaksi->jumlah_bayar ?? 0) - $transaksi->total_biaya, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('transaksi.index') }}"
                        class="bg-gray-800 text-white px-5 py-2 rounded-lg shadow hover:bg-gray-700 transition">
                        ← Kembali
                    </a>

                    <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}" target="_blank"
                        class="bg-black text-white px-5 py-2 rounded-lg shadow hover:bg-gray-800 transition flex items-center gap-2">
                        🖨️ Cetak Struk
                    </a>
                </div>
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