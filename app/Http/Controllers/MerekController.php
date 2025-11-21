<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mereks = Merek::all();
        return view('merek.index', compact('mereks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merek.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        Merek::create($request->only('nama_merek'));

        return redirect()->route('merek.index')->with('success', 'Merek berhasil ditambahkan!');
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
    public function edit(string $id)
    {
        $merek = Merek::findOrFail($id);    
        return view('merek.edit', compact('merek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        $merek = Merek::findOrFail($id);

        $merek->update($request->only('nama_merek'));

        return redirect()->route('merek.index')->with('success', 'Merek berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $merek = Merek::findOrFail($id);

        $merek->delete();

        return redirect()->route('merek.index')->with('success', 'Merek berhasil dihapus!');
    }
}
