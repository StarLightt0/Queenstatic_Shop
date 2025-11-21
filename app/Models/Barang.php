<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{

    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'id_merek',
        'id_kategori',
        'harga',
         'stok',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function merek()
{
    return $this->belongsTo(Merek::class, 'id_merek', 'id_merek');
}
}
