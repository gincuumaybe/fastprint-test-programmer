<h2>Edit Produk</h2>

<form action="/produk/{{ $produk->id_produk }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}">

    <input type="number" name="harga" value="{{ $produk->harga }}">

    <select name="kategori_id">
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}" {{ $produk->kategori_id == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>

    <select name="status_id">
        @foreach ($status as $s)
            <option value="{{ $s->id_status }}" {{ $produk->status_id == $s->id_status ? 'selected' : '' }}>
                {{ $s->nama_status }}
            </option>
        @endforeach
    </select>

    <button type="submit">Update</button>
</form>
