<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_produk',
        'nama_produk',
        'harga',
        'kategori_id',
        'status_id'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id_status');
    }

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',   // foreign key di tabel produk
            'id_kategori'    // primary key di tabel kategori
        );
    }
}
