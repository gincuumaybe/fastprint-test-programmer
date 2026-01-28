<h2>Tambah Produk</h2>

<form action="/produk" method="POST">
    @csrf

    <input type="text" name="nama_produk" placeholder="Nama Produk" value="{{ old('nama_produk') }}">

    <input type="number" name="harga" placeholder="Harga" value="{{ old('harga') }}" min="0" step="1">

    <select name="kategori_id">
        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
        @foreach ($kategori as $k)
            <option value="{{ $k->id_kategori }}" {{ old('kategori_id') == $k->id_kategori ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>

    <select name="status_id">
        <option value="" disabled {{ old('status_id') ? '' : 'selected' }}>-- Pilih Status --</option>
        @foreach ($status as $s)
            <option value="{{ $s->id_status }}" {{ old('status_id') == $s->id_status ? 'selected' : '' }}>
                {{ $s->nama_status }}
            </option>
        @endforeach
    </select>

    <button type="submit">Simpan</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Form masih salah',
            html: `
        <ul style="text-align:left; margin:0; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    `
        });
    </script>
@endif
