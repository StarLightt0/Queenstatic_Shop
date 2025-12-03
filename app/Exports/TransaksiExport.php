<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransaksiExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id_transaksi)
    {
        $this->id = $id_transaksi;
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Qty',
            'Harga',
            'Subtotal',
            'Tanggal',
            'Metode Transaksi'
        ];
    }

    public function collection()
    {
        $transaksi = Transaksi::with('detail.barang')->find($this->id);

        return $transaksi->detail->map(function ($item) use ($transaksi) {
            return [
                $item->barang->nama_barang,
                $item->qty,
                $item->barang->harga,
                $item->subtotal,
                $transaksi->tanggal_transaksi,
                $transaksi->metode_transaksi
            ];
        });
    }
}
