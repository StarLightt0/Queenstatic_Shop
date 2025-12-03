<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Transaksi</title>
  <style>
    * {
      font-family: "Courier New", monospace;
      font-size: 12px;
      color: #000;
    }

    body {
      width: 250px; 
      margin: auto;
      padding: 10px;
      border: 1px dashed #999;
      position: relative;
    }

    .center { text-align: center; }
    .bold { font-weight: bold; }
    .line { border-top: 1px dashed #000; margin: 4px 0; }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td { vertical-align: top; }
    .right { text-align: right; }

    .btn-container {
      margin-top: 12px;
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .btn {
      border: none;
      padding: 6px 12px;
      font-size: 12px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.2s ease, transform 0.1s ease;
      color: white;
    }

    .btn-print { background-color: #0b8f2c; }
    .btn-print:hover {
      background-color: #11b13c;
      transform: scale(1.03);
    }

    .btn-back { background-color: #000; }
    .btn-back:hover {
      background-color: #333;
      transform: scale(1.03);
    }

    @media print {
      @page {
        size: 58mm auto;
        margin: 5mm;
      }

      body {
        width: 58mm;
        border: none;
        margin: 0;
        padding: 0;
      }

      .btn-container {
        display: none;
      }

      * {
        -webkit-print-color-adjust: exact !important;
        color-adjust: exact !important;
      }
    }
  </style>
</head>

<body>

  @if (auth()->check())
    <div class="center text-gray-600 text-sm">
      Halo, <strong>{{ auth()->user()->name }}</strong>
    </div>
  @else

    <script>
      window.onload = function () {
        alert("⚠️ Kamu belum login! Silakan login dulu ya~");
        window.location.href = "{{ route('login') }}";
      };
    </script>
  @endif

  <div class="center bold">QueenStatic Shop</div>
  <div class="center">Jl. Alma'as 03 Blok 25</div>
  <div class="center">{{ auth()->user()->name ?? 'Kasir' }}</div>
  <div class="line"></div>

  <table>
    <tr>
      <td>ID Transaksi</td>
      <td class="right">{{ $transaksi->id_transaksi }}</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td class="right">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y - H:i') }}</td>
    </tr>
  </table>

  <div class="line"></div>
  <table>
    <tr>
      <td colspan="2" class="bold">Daftar Barang</td>
    </tr>
    @foreach ($transaksi->detail as $detail)
      <tr>
        <td>{{ $detail->barang->nama_barang }} (x{{ $detail->qty }})</td>
        <td class="right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
      </tr>
    @endforeach
  </table>

  <div class="line"></div>
  <table>
    <tr>
      <td>Total Harga</td>
      <td class="right bold">Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Tunai</td>
      <td class="right">Rp {{ number_format($transaksi->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
      <td>Kembalian</td>
      <td class="right bold">
        Rp {{ number_format(($transaksi->jumlah_bayar ?? 0) - $transaksi->total_biaya, 0, ',', '.') }}
      </td>
    </tr>
  </table>

  <div class="line"></div>
  <div class="center">Terima Kasih Telah Berbelanja!</div>
  <div class="center">💖QueenStatic Shop 💖<iv>
      <div class="center">Barang yang sudah dibeli tidak dapat dikembalikan</div>

      <div class="btn-container">
        <button class="btn btn-print" onclick="window.print()">🖨 Cetak</button>
        <button class="btn btn-back" onclick="window.location.href='{{ route('transaksi.index') }}'">← Batal</button>
      </div>
</body>

</html>