<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi | QueenStatic Shop</title>
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

<body class="bg-gray-100 text-black min-h-screen flex">

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
                <a href="/dashboard" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
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
        <h2 class="text-3xl font-bold text-center mb-8">Riwayat Transaksi</h2>

        @if(session('success'))
            <div
                class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg text-center z-50 animate-fadeIn">
                {{ session('success') }}
            </div>

            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translate(-50%, -20px);
                    }

                    to {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }
                }

                .animate-fadeIn {
                    animation: fadeIn 0.4s ease-out;
                }
            </style>

            <script>
                setTimeout(() => {
                    const alertBox = document.querySelector('.fixed.bg-green-600');
                    if (alertBox) {
                        alertBox.style.transition = 'opacity 0.5s';
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 500);
                    }
                }, 3000);
            </script>
        @endif

        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <a href="{{ route('transaksi.create') }}"
                class="bg-black text-white px-6 py-3 rounded-lg shadow hover:bg-gray-800 transition font-semibold">
                + Buat Transaksi
            </a>

            <form action="{{ route('transaksi.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
                <label for="tanggal" class="font-medium"></label>
                <input type="date" name="tanggal" id="tanggal" value="{{ request('tanggal') }}"
                    class="flex-1 min-w-[200px] sm:min-w-[250px] lg:min-w-[910px] border border-gray-400 rounded-lg px-3 py-2 focus:ring-2 focus:ring-black outline-none">
                <button type="submit" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead>
                    <tr>
                        <th class="px-6 py-3 font-semibold">ID Transaksi</th>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Metode</th>
                        <th class="px-6 py-3 font-semibold">Total</th>
                        <th class="px-6 py-3 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-gray-800 font-medium">
                                {{ $transaksi->id_transaksi }}
                            </td>
                            <td class="px-6 py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('m d Y - H:i') }}
                            </td>
                            <td class="px-6 py-3 text-gray-700">
                                {{ ucfirst($transaksi->metode_transaksi) }}
                            </td>
                            <td class="px-6 py-3 text-gray-800 font-semibold">
                                Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3 text-center flex items-center justify-center gap-2">
                                <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}" target="_blank"
                                    class="inline-flex items-center justify-center hover:opacity-75 transition">
                                    <img src="https://img.icons8.com/?size=100&id=sInQvCXvQM2I&format=png&color=000000"
                                        alt="Cetak" class="w-8 h-8" />
                                </a>
                                <a href="{{ route('transaksi.show', $transaksi->id_transaksi) }}"
                                    class="bg-black text-white px-3 py-1 rounded-lg shadow hover:bg-gray-800 transition">
                                    Detail
                                </a>

                                <a href="{{ route('transaksi.edit', $transaksi->id_transaksi) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600 transition">
                                    Edit
                                </a>

                                <form action="{{ route('transaksi.destroy', $transaksi->id_transaksi) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus transaksi ini? 😢')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="showDeletePopup('{{ route('transaksi.destroy', $transaksi->id_transaksi) }}', '{{ $transaksi->id_transaksi }}')"
                                        class="bg-red-600 text-white px-3 py-1 rounded-lg shadow hover:bg-red-700 transition">
                                        Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- delete popup -->

    <div id="deletePopup" class="hidden fixed left-1/2 transform -translate-x-1/2 bottom-20 z-50 w-full max-w-md">
        <div class="bg-black text-white rounded-xl shadow-2xl p-6 text-center border border-gray-600 opacity-0 scale-90 transition-all duration-300"
            id="popupBox">
            <h2 class="text-xl font-bold mb-2">Hapus Riwayat Transaksi</h2>
            <p id="popupMessage" class="text-gray-300 mb-5 text-sm">Apakah kamu yakin ingin menghapus riwayat transaksi
                ini?</p>
            <div class="flex justify-center gap-4">
                <button id="cancelDelete"
                    class="px-5 py-2 rounded-lg bg-white text-black text-bold hover:bg-gray-200 transition">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-white text-black text-bold hover:bg-gray-200 transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script>

        //popup delete
        const deletePopup = document.getElementById('deletePopup');
        const popupBox = document.getElementById('popupBox');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteForm');
        const popupMessage = document.getElementById('popupMessage');

        function showDeletePopup(actionUrl, idTransaksi) {
            deleteForm.action = actionUrl;
            popupMessage.textContent = `Kamu yakin ingin menghapus transaksi dengan ID "${idTransaksi}"?`;
            deletePopup.classList.remove('hidden');
            setTimeout(() => popupBox.classList.remove('opacity-0', 'scale-90'), 10);
        }

        cancelDelete.addEventListener('click', () => {
            popupBox.classList.add('opacity-0', 'scale-90');
            setTimeout(() => deletePopup.classList.add('hidden'), 200);
        });

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