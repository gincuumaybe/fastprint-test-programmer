<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Status;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk.index', [
            'produk' => Produk::with(['kategori', 'status'])->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create', [
            'kategori' => Kategori::all(),
            'status'   => Status::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'kategori_id' => 'required',
            'status_id'   => 'required',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'harga.required'       => 'Harga wajib diisi',
            'harga.numeric'        => 'Harga harus berupa angka',
            'kategori_id.required' => 'Kategori wajib diisi',
            'status_id.required'   => 'Status wajib diisi',
        ]);

        Produk::create($validated);

        return redirect('/')->with('success', 'Produk berhasil ditambahkan');
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
        return view('produk.edit', [
            'produk'  => Produk::findOrFail($id),
            'kategori' => Kategori::all(),
            'status'  => Status::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'kategori_id' => 'required',
            'status_id'   => 'required',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'harga.required'       => 'Harga wajib diisi',
            'harga.numeric'        => 'Harga harus berupa angka',
        ]);

        $produk->update($validated);

        return redirect('/')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect('/')->with('success', 'Produk berhasil dihapus');
    }
}
