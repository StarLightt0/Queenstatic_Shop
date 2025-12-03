<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class TransaksiBulananExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Metode',
            'Total',
        ];
    }

    public function collection()
    {
        return Transaksi::whereMonth('tanggal_transaksi', Carbon::now()->month)
            ->whereYear('tanggal_transaksi', Carbon::now()->year)
            ->orderBy('tanggal_transaksi', 'DESC')
            ->select('id_transaksi', 'tanggal_transaksi', 'metode_transaksi', 'total_biaya')
            ->get();
    }
}
