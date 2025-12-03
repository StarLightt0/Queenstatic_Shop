<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $transaksis = $query->latest()->paginate(10);
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('transaksi.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'metode_transaksi' => 'required|string',
            'barang_id' => 'required|array|min:1',
            'qty' => 'required|array|min:1',
        ]);

        $transaksi = Transaksi::create([
            'id_transaksi' => $request->id_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_transaksi' => $request->metode_transaksi,
            'total_biaya' => 0,
            'jumlah_bayar' => $request->jumlah_bayar,

        ]);

        $total = 0;

        foreach ($request->barang_id as $i => $barang_id) {
            $barang = Barang::find($barang_id);
            if (!$barang)
                continue;

            $qty = (int) $request->qty[$i];
            $subtotal = $barang->harga * $qty;
            $total += $subtotal;

            $transaksi->detail()->create([
                'barang_id' => $barang_id,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ]);

            $barang->decrement('stok', $qty);
        }

        $jumlah_bayar = $request->jumlah_bayar ?? 0;
        $jumlah_kembalian = $jumlah_bayar - $total;

        $transaksi->update([
            'total_biaya' => $total,
            'jumlah_bayar' => $jumlah_bayar,
            'jumlah_kembalian' => $jumlah_kembalian,
        ]);

        return redirect()->route('transaksi.index', $transaksi->id_transaksi)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('detailTransaksis')->findOrFail($id);
        $barangs = Barang::all();

        return view('transaksi.edit', compact('transaksi', 'barangs'));
    }

    public function update(Request $request, $id)
    {

        $request->merge([
            'jumlah_bayar' => str_replace('.', '', $request->jumlah_bayar),
        ]);

        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'metode_transaksi' => 'required|string|max:50',
            'barang_id' => 'required|array',
            'barang_id.*' => 'exists:barangs,id_barang',
            'qty' => 'required|array',
            'qty.*' => 'integer|min:1',
            'total_biaya' => 'required|numeric|min:0',
            'jumlah_bayar' => 'nullable|numeric|min:0',
            'jumlah_kembalian' => 'nullable|numeric|min:0',
        ]);

        $transaksi = Transaksi::where('id_transaksi', $id)->firstOrFail();

        foreach ($transaksi->detailTransaksis as $detail) {
            $barang = Barang::find($detail->barang_id);
            if ($barang) {
                $barang->increment('stok', $detail->qty);
            }
        }

        $transaksi->detailTransaksis()->delete();
        $total = 0;

        foreach ($request->barang_id as $i => $barangId) {
            $barang = Barang::find($barangId);
            if (!$barang)
                continue;

            $qty = (int) $request->qty[$i];
            $subtotal = $barang->harga * $qty;
            $total += $subtotal;

            $transaksi->detailTransaksis()->create([
                'barang_id' => $barangId,
                'qty' => $qty,
                'subtotal' => $subtotal,
            ]);

            $barang->decrement('stok', $qty);
        }

        $jumlah_bayar = $request->jumlah_bayar ?? 0;
        $jumlah_kembalian = $jumlah_bayar - $total;

        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_transaksi' => $request->metode_transaksi,
            'total_biaya' => $total,
            'jumlah_bayar' => $jumlah_bayar,
            'jumlah_kembalian' => $jumlah_kembalian,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui');

    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('detail.barang')->findOrFail($id);
        return view('transaksi.cetak', compact('transaksi'));
    }

    public function export($id)
{
    return Excel::download(new TransaksiExport($id), 'Transaksi_' . $id . '.xlsx');
}

public function exportBulan()
{
    return Excel::download(new \App\Exports\TransaksiBulananExport, 'Transaksi_Bulan_Ini.xlsx');
}
    
}
