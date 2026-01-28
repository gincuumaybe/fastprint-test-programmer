<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Status;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/produk.json'));
        $data = json_decode($json, true);
        $data = $data['data'];

        foreach ($data as $item) {

            $kategori = Kategori::firstOrCreate([
                'nama_kategori' => $item['kategori']
            ]);

            $status = Status::firstOrCreate([
                'nama_status' => $item['status']
            ]);

            Produk::updateOrCreate(
                ['id_produk' => $item['id_produk']],
                [
                    'nama_produk' => $item['nama_produk'],
                    'harga' => $item['harga'],
                    'kategori_id' => $kategori->id_kategori,
                    'status_id' => $status->id_status
                ]
            );
        }
    }
}
