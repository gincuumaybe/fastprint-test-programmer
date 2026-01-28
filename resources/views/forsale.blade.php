<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>tes</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="judul">
        <h2>Dashboard</h2>
    </div>

    <div class="all-produk">
        <div class="produk-list">
            <h4>Produk List</h4>
            <div class="isi-produk">
                <ul>
                    <li class="produk-header">
                        <span>Nama Produk</span>
                        <span>Harga</span>
                    </li>
                    @foreach ($produk as $item)
                        <li class="produk-item">
                            <span>{{ $item->nama_produk }}</span>
                            <span>{{ $item->harga }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="diklik">
            <a href="/bisa-dijual" class="btn btn-primary">
                Bisa Dijual
            </a>

            <a href="/" class="btn btn-secondary">
                Semua Produk
            </a>
        </div>
        </>
</body>

</html>
