<!DOCTYPE html>
<html>

<head>
    <title>Data Produk</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <h2>Data Produk</h2>

    {{-- notif sukses --}}
    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <a href="/produk/create">+ Tambah Produk</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->nama_produk }}</td>
                    <td>{{ number_format($p->harga) }}</td>
                    <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $p->status->nama_status ?? '-' }}</td>
                    <td>
                        <a href="/produk/{{ $p->id_produk }}/edit">Edit</a>

                        <form action="/produk/{{ $p->id_produk }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Data kosong</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin hapus produk?',
                    text: 'Data yang sudah dihapus tidak bisa dikembalikan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

</body>

</html>
