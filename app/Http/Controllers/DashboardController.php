<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Status;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'kategori' => Kategori::all(),
            'status'   => Status::all(),
            'produk'   => Produk::all(),
        ]);
    }

    public function bisadijual()
    {
        $produk = Produk::whereHas('status', function ($q) {
            $q->where('nama_status', 'bisa dijual');
        })->get();

        return view('forsale', [
            // 'kategori' => Kategori::all(),
            // 'status'   => Status::all(),
            'produk'   => $produk,
        ]);
    }
}
