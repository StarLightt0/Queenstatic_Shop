<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id_transaksi', 'tanggal_transaksi', 'total_biaya', 'metode_transaksi', 'jumlah_bayar', 'jumlah_kembalian'];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi', );
    }

    public function detailTransaksis()
{
    return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
}
}
