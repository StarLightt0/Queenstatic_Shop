<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang | QueenStatic Shop</title>
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
                    class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition">Logout</button>
            </form>
        </aside>

        <!-- main content -->
        <main class="flex-1 ml-64 p-10 overflow-y-auto animate-fadeSlideUp">
            <div class="max-w-5xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-300">
                <h1 class="text-3xl font-bold mb-6 text-center">Daftar Barang</h1>

                <div class="flex gap-2 mb-4">
                    <a href="{{ route('barang.create') }}"
                        class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition">+ Tambah Barang</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full bor    der border-gray-300 rounded-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-3">#</th>
                                <th class="py-2 px-3">Nama Barang</th>
                                <th class="py-2 px-3">Merek</th>
                                <th class="py-2 px-3">Kategori</th>
                                <th class="py-2 px-3">Harga</th>
                                <th class="py-2 px-3">Stok</th>
                                <th class="py-2 px-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $barang)
                                <tr class="border-t border-gray-300 hover:bg-gray-100 transition transform hover:scale-[1.02]">
                                    <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-3">{{ $barang->nama_barang }}</td>
                                    <td class="py-2 px-3">{{ $barang->merek->nama_merek ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                    <td class="py-2 px-3">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>

                                    <td class="py-2 px-3 text-center">
                                        @if($barang->stok <= 1)
                                            <span class="text-red-600 font-semibold">{{ $barang->stok }}</span>
                                        @else
                                            {{ $barang->stok }}
                                        @endif
                                    </td>

                                    <td class="py-2 px-3 text-center">
                                        <a href="{{ route('barang.edit', $barang->id_barang) }}"
                                            class="text-gray-800 font-semibold hover:underline">Edit</a> |
                                        <button type="button"
                                            onclick="showDeletePopup('{{ route('barang.destroy', $barang->id_barang) }}', '{{ $barang->nama_barang }}')"
                                            class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">Belum ada barang.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- delete popup -->
    <div id="deletePopup" class="hidden fixed left-1/2 transform -translate-x-1/2 bottom-20 z-50 w-full max-w-md">
        <div class="bg-black text-white rounded-xl shadow-2xl p-6 text-center border border-gray-600 opacity-0 scale-90 transition-all duration-300"
            id="popupBox">
            <h2 class="text-xl font-bold mb-2">Hapus Barang?</h2>
            <p id="popupMessage" class="text-gray-300 mb-5 text-sm">Apakah kamu yakin ingin menghapus barang ini?</p>
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

        // delete popup 
        const deletePopup = document.getElementById('deletePopup');
        const popupBox = document.getElementById('popupBox');
        const cancelDelete = document.getElementById('cancelDelete');
        const deleteForm = document.getElementById('deleteForm');
        const popupMessage = document.getElementById('popupMessage');

        function showDeletePopup(actionUrl, namaBarang) {
            deleteForm.action = actionUrl;
            popupMessage.textContent = `Kamu yakin ingin menghapus "${namaBarang}"?`;
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