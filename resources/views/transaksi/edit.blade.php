<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Transaksi | QueenStatic Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/Removebg.png') }}">
</head>

<style>
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(50px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeSlideRight {
        from { opacity: 0; transform: translateX(-100px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .hidden-before-anim { opacity: 0; }
    .animate-fadeSlideUp { animation: fadeSlideUp 1s ease forwards; }
    .animate-fadeSlideRight { animation: fadeSlideRight 1s ease forwards; }
</style>

<body class="bg-gray-100 text-black min-h-screen">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-300 flex flex-col justify-between shadow-md fixed top-0 left-0 h-full animate-fadeSlideRight">
            <div>
                <div class="p-10 border-b border-gray-300">
                    <h1 class="text-2xl font-bold tracking-wide mb-2">QueenStatic Shop</h1>

                    @if (auth()->check())
                        <span class="text-gray-600 text-sm">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                    @else
                        <span class="text-red-600 text-sm font-semibold">Kamu belum login!</span>
                        <script>
                            window.onload = () => {
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
                        <button onclick="toggleSubMenu()" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
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
                                <a href="{{ route('barang.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">📋 Daftar Barang</a>
                                <a href="{{ route('kategori.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">➕ Tambah Kategori</a>
                                <a href="{{ route('merek.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">🏷️ Tambah Merek</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('transaksi.index') }}" class="justify-between w-full px-4 py-2 rounded-lg bg-gray-200 font-semibold hover:bg-gray-300 transition">
                        🛍️ Transaksi
                    </a>
                </nav>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-gray-300">
                @csrf
                <button type="submit" class="w-full bg-black text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition">Logout</button>
            </form>
        </aside>

        <!-- Main content -->
        <main class="flex-1 ml-64 p-10 overflow-y-auto animate-fadeSlideUp">
            <h2 class="text-3xl font-bold text-center mb-8">Edit Transaksi</h2>

            <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST" id="formTransaksi">
                @csrf
                @method('PUT')

                <div class="bg-white p-6 rounded-xl shadow border border-gray-300 mb-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="font-semibold text-gray-700">ID Transaksi</label>
                            <input type="text" name="id_transaksi" value="{{ $transaksi->id_transaksi }}"
                                readonly class="w-full bg-gray-100 border border-gray-400 rounded-lg px-3 py-2 mt-1">
                        </div>

                        <div>
                            <label class="font-semibold text-gray-700">Tanggal</label>
                            <input type="datetime-local" name="tanggal_transaksi"
                                value="{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d\TH:i') }}"
                                class="w-full border border-gray-400 rounded-lg px-3 py-2 mt-1" required>
                        </div>
                    </div>
                </div>

                <!-- Keranjang -->
                <div class="bg-white p-6 rounded-xl shadow border border-gray-300 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-semibold">🛒 Keranjang Belanja</h3>
                        <button type="button" onclick="tambahProduk()"
                            class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">+ Tambah Produk</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden mb-4 text-sm">
                            <thead class="bg-gray-100 text-gray-700 uppercase">
                                <tr>
                                    <th class="py-3 px-4 text-left w-1/3">Nama Barang</th>
                                    <th class="py-3 px-4 text-right w-1/6">Harga</th>
                                    <th class="py-3 px-4 text-center w-1/6">Qty</th>
                                    <th class="py-3 px-4 text-right w-1/6">Subtotal</th>
                                    <th class="py-3 px-4 text-center w-1/12">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="keranjangBody" class="divide-y divide-gray-200">
                                @foreach($transaksi->detailTransaksis as $index => $detail)
                                    <tr>
                                        <td class="py-3 px-4 text-left align-middle">
                                            <select name="barang_id[]" onchange="onSelectChange(this)"
                                                class="w-full border border-gray-300 rounded-lg px-2 py-1">
                                                @foreach ($barangs as $b)
                                                    <option value="{{ $b->id_barang }}"
                                                        data-harga="{{ $b->harga }}"
                                                        data-stok="{{ $b->stok }}"
                                                        {{ $detail->barang_id == $b->id_barang ? 'selected' : '' }}>
                                                        {{ $b->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td class="py-3 px-4 text-right align-middle">
                                            <span class="harga block font-medium" data-harga="{{ $detail->barang->harga }}">
                                                Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-4 text-center align-middle">
                                            <input type="number" name="qty[]" min="1" value="{{ $detail->qty }}"
                                                class="w-20 text-center border border-gray-300 rounded px-2 py-1"
                                                oninput="updateSubtotal(this)">
                                        </td>

                                        <td class="py-3 px-4 text-right align-middle">
                                            <span class="subtotal block font-medium">
                                                Rp {{ number_format($detail->barang->harga * $detail->qty, 0, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-4 text-center align-middle">
                                            <button type="button" class="text-red-600 font-bold hover:underline"
                                                onclick="hapusProduk(this)">🗑️</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Ringkasan dan Pembayaran -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-xl shadow border border-gray-300">
                            <h3 class="text-xl font-semibold mb-4">📦 Ringkasan</h3>

                            <div class="flex justify-between text-gray-700 mb-2">
                                <span id="totalLabel">Total Harga Barang:</span>
                                <span id="totalHarga" class="font-semibold">
                                    Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                                </span>
                            </div>

                            <input type="hidden" name="total_biaya" id="total_biaya_hidden">

                             <div class="flex justify-between text-gray-700 mb-2">
                                <span>Total Bayar:</span>
                                <span id="totalBayar" class="font-semibold">Rp 0</span>
                            </div>

                            <div class="flex justify-between text-gray-700 mb-2">
                                <span>Kembalian:</span>
                                <span id="kembalian" class="font-semibold">Rp 0</span>
                            </div>

                        </div>

                        <div class="bg-white p-6 rounded-xl shadow border border-gray-300">
                            <h3 class="text-xl font-semibold mb-4">💰 Pembayaran</h3>
                            <label class="block mb-2 font-medium">Metode Pembayaran</label>
                            <select name="metode_transaksi" id="metode_transaksi"
                                class="w-full border border-gray-400 rounded-lg px-3 py-2 mb-4">
                                <option value="cash" {{ $transaksi->metode_transaksi == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="debit" {{ $transaksi->metode_transaksi == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="qris" {{ $transaksi->metode_transaksi == 'qris' ? 'selected' : '' }}>QRIS</option>
                            </select>

                            <label class="block mb-2 font-medium">Jumlah Bayar</label>
                            <input type="text" id="jumlah_bayar" name="jumlah_bayar"
                                value="{{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}"
                                class="w-full border border-gray-400 rounded-lg px-3 py-2 mb-4"
                                oninput="hitungKembalian()">

                                <script>
                                const bayarInput = document.getElementById('jumlah_bayar');

                                bayarInput.addEventListener('input', function (e) {
                                    let value = e.target.value.replace(/\D/g, '');
                                    e.target.value = new Intl.NumberFormat('id-ID').format(value);
                                });

                                bayarInput.form.addEventListener('submit', function () {
                                    bayarInput.value = bayarInput.value.replace(/\./g, '');
                                });
                            </script>

                            <div class="flex justify-between gap-4 mt-6">
                                <button type="submit"
                                    class="w-1/2 bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition font-semibold">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('transaksi.index') }}"
                                    class="w-1/2 bg-white text-black border border-gray-400 py-2 rounded-lg hover:bg-gray-200 transition text-center">
                                    Batalkan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

             <!-- popup stok -->
            <div id="stokPopup" class="hidden fixed left-1/2 transform -translate-x-1/2 bottom-20 z-50 w-full max-w-md">
                <div id="stokBox"
                    class="bg-black text-white rounded-xl shadow-2xl p-5 text-center border border-gray-600 opacity-0 scale-90 transition-all duration-300">
                    <h2 class="text-xl font-bold mb-2">⚠️ Stok Tidak Cukup</h2>
                    <p id="stokMessage" class="text-gray-300 mb-4 text-sm">Jumlah yang diminta melebihi stok tersedia.
                    </p>
                    <button id="closeStokPopup" type="button"
                        class="px-5 py-2 rounded-lg bg-white text-black font-semibold hover:bg-gray-200 transition">OK</button>
                </div>
            </div>

        </main>
    </div>

    <!-- scripts -->
    <script>
         const BARANGS = [
            @foreach($barangs as $b)
                {
                id: {{ $b->id_barang }},
                nama: {!! json_encode($b->nama_barang) !!},
                harga: {{ (int) $b->harga }}, 
                stok: {{ (int) $b->stok }}
                },
            @endforeach
    ];

        let rowNo = 0;

        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        function tambahProduk() {
            rowNo++;
            const tbody = document.getElementById('keranjangBody');

            let optionsHtml = '';
            BARANGS.forEach(b => {
                optionsHtml += `<option value="${b.id}" data-harga="${b.harga}" data-stok="${b.stok}">${b.nama}</option>`;
            });

            const tr = document.createElement('tr');
            tr.innerHTML = `
        <td class="py-3 px-4 text-left align-middle">
            <select name="barang_id[]" onchange="onSelectChange(this)"
                class="w-full border border-gray-300 rounded-lg px-2 py-1">
                ${optionsHtml}
            </select>
        </td>

        <td class="py-3 px-4 text-right align-middle">
            <span class="harga block font-medium" data-harga="">Rp 0</span>
        </td>

        <td class="py-3 px-4 text-center align-middle">
            <input type="number" name="qty[]" min="1" value="1"
                class="w-20 text-center border border-gray-300 rounded px-2 py-1"
                oninput="updateSubtotal(this)">
        </td>

        <td class="py-3 px-4 text-right align-middle">
            <span class="subtotal block font-medium">Rp 0</span>
        </td>

        <td class="py-3 px-4 text-center align-middle">
            <button type="button"
                class="text-red-600 font-bold hover:underline"
                onclick="hapusProduk(this)">🗑️</button>
        </td>
    `;
            tbody.appendChild(tr);

            const select = tr.querySelector('select');
            setRowPriceFromSelect(select);
            updateSubtotal(tr.querySelector('input[name="qty[]"]'));
        }

        function onSelectChange(selectEl) {
            setRowPriceFromSelect(selectEl);
            const row = selectEl.closest('tr');
            const qtyInput = row.querySelector('input[name="qty[]"]');
            updateSubtotal(qtyInput);
        }

        function setRowPriceFromSelect(selectEl) {
            const price = parseInt(selectEl.selectedOptions[0].dataset.harga) || 0;
            const stok = parseInt(selectEl.selectedOptions[0].dataset.stok) || 0;
            const hargaSpan = selectEl.closest('tr').querySelector('.harga');

            hargaSpan.dataset.harga = price;
            hargaSpan.innerText = formatRupiah(price);
        }

        function hapusProduk(btn) {
            btn.closest('tr').remove();
            hitungTotal();
        }

        function updateSubtotal(inputEl) {
            const row = inputEl.closest('tr');
            const qty = parseInt(inputEl.value) || 0;
            const harga = parseInt(row.querySelector('.harga').dataset.harga) || 0;

            const select = row.querySelector('select');
            const stok = parseInt(select.selectedOptions[0].dataset.stok) || 0;
            const namaBarang = select.selectedOptions[0].textContent;

            if (qty > stok) {
                inputEl.value = stok;
                showStokPopup(namaBarang, stok);
            }

            const subtotal = harga * (parseInt(inputEl.value) || 0);
            row.querySelector('.subtotal').innerText = formatRupiah(subtotal);

            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            let totalQty = 0;

            document.querySelectorAll('#keranjangBody tr').forEach(row => {
                const qtyInput = row.querySelector('input[name="qty[]"]');
                const hargaRaw = parseInt(row.querySelector('.harga').dataset.harga) || 0;
                const qty = parseInt(qtyInput.value) || 0;
                const subtotal = hargaRaw * qty;

                row.querySelector('.subtotal').innerText = formatRupiah(subtotal);

                total += subtotal;
                totalQty += qty;
            });

            document.getElementById('totalHarga').innerText = formatRupiah(total);
            document.getElementById('totalBayar').innerText = formatRupiah(total);

            const totalLabel = document.getElementById('totalLabel');
            if (totalLabel) totalLabel.innerText = `Total Harga Barang (${totalQty}):`;

            document.getElementById('total_biaya_hidden').value = total;

            // hitung kembalian
            hitungKembalian();
        }

        function hitungKembalian() {
            const totalBayarEl = document.getElementById('totalBayar');
            const total = parseInt(totalBayarEl.innerText.replace(/[^\d]/g, '')) || 0;
            const bayarInput = document.getElementById('jumlah_bayar');
            let bayar = 0;

            if (bayarInput && bayarInput.value) {
                bayar = parseInt(bayarInput.value.replace(/[^\d]/g, '')) || 0;
            }

            const kembalian = bayar - total;
            document.getElementById('kembalian').innerText = formatRupiah(kembalian > 0 ? kembalian : 0);
        }

        // Popup stok
        const stokPopup = document.getElementById('stokPopup');
        const stokBox = document.getElementById('stokBox');
        const closeStokPopup = document.getElementById('closeStokPopup');
        const stokMessage = document.getElementById('stokMessage');
        let stokTidakCukup = false;

        function showStokPopup(namaBarang, stok) {
            stokTidakCukup = true;
            stokMessage.textContent = `Stok "${namaBarang}" hanya tersisa ${stok} item.`;
            stokPopup.classList.remove('hidden');
            setTimeout(() => stokBox.classList.remove('opacity-0', 'scale-90'), 10);
        }

        closeStokPopup && closeStokPopup.addEventListener('click', () => {
            stokTidakCukup = false;
            stokBox.classList.add('opacity-0', 'scale-90');
            setTimeout(() => stokPopup.classList.add('hidden'), 200);
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

        
    window.addEventListener('DOMContentLoaded', () => {
    hitungTotal();

    const bayarInput = document.getElementById('jumlah_bayar');
    const totalBayarEl = document.getElementById('totalBayar');
    const kembalianEl = document.getElementById('kembalian');

    const totalBiaya = {{ (int) $transaksi->total_biaya }};
    const jumlahBayar = {{ (int) $transaksi->jumlah_bayar }};

    totalBayarEl.innerText = formatRupiah(totalBiaya);
    bayarInput.value = new Intl.NumberFormat('id-ID').format(jumlahBayar);

    const kembalian = jumlahBayar - totalBiaya;
    kembalianEl.innerText = formatRupiah(kembalian > 0 ? kembalian : 0);
});

    </script>
</body>
</html>
