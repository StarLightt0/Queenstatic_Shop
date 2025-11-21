<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Merek;
use Illuminate\Http\Request;
use App\Models\Kategori;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        $mereks = Merek::all();
        return view('barang.create', compact('kategoris', 'mereks'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_merek' => 'nullable|integer|exists:mereks,id_merek',
            'id_kategori' => 'required|integer|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Barang::create([
            'nama_barang' => $data['nama_barang'],
            'id_merek' => $data['id_merek'] ?? null,
            'id_kategori' => $data['id_kategori'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan! Stok saat ini: ' . $data['stok']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        $mereks = Merek::all();
        return view('barang.edit', compact('barang', 'kategoris', 'mereks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_merek' => 'nullable|integer|exists:mereks,id_merek',
            'id_kategori' => 'required|integer|exists:kategoris,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $barang->update([
            'nama_barang' => $data['nama_barang'],
            'id_merek' => $data['id_merek'] ?? null,
            'id_kategori' => $data['id_kategori'],
            'harga' => $data['harga'],
            'stok' => $data['stok'],
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui! Stok saat ini: ' . $barang->stok);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
