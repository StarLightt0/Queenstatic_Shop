<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;

        $totalHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->sum('total_biaya');
        $totalBulanIni = Transaksi::whereMonth('tanggal_transaksi', $bulanIni)->sum('total_biaya');
        $jumlahTransaksiHariIni = Transaksi::whereDate('tanggal_transaksi', $hariIni)->count();

        $bestSeller = DetailTransaksi::selectRaw('barang_id, SUM(qty) as total_terjual')
            ->groupBy('barang_id')
            ->orderByDesc('total_terjual')
            ->with('barang')
            ->take(5)
            ->get();

        $stokHabis = Barang::where('stok', '<=', 1)->get();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $filteredTotal = 0;
        $filteredTransaksi = 0;

        if ($startDate && $endDate) {
            $endDatePlusOne = Carbon::parse($endDate)->addDay();
            $filteredTotal = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDatePlusOne])
                ->sum('total_biaya');

            $filteredTransaksi = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDatePlusOne])
                ->count();
        }

        return view('dashboard', compact(
            'totalHariIni',
            'totalBulanIni',
            'jumlahTransaksiHariIni',
            'bestSeller',
            'stokHabis',
            'filteredTotal',
            'filteredTransaksi',
            'startDate',
            'endDate'
        ));
    }
}
