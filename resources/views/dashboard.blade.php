@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- ================= SUMMARY ================= --}}
    <section class="summary">
        <div class="summary-item">
            <h4>Total Kategori</h4>
            <p>{{ $kategori->count() }}</p>
        </div>
        <div class="summary-item">
            <h4>Total Status</h4>
            <p>{{ $status->count() }}</p>
        </div>
        <div class="summary-item">
            <h4>Total Produk</h4>
            <p>{{ $produk->count() }}</p>
        </div>
    </section>

    {{-- ================= GRID ================= --}}
    <section class="grid">

        {{-- ===== KATEGORI ===== --}}
        <section class="card kategori">
            <h3>Kategori Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Data kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- ===== STATUS ===== --}}
        <section class="card status">
            <h3>Status Produk</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($status as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">Data kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        {{-- ===== PRODUK ===== --}}
        <section class="card produk">
            <h3>List Produk</h3>

            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $item)
                        <tr data-status="{{ strtolower($item->status->nama_status ?? '') }}">
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->harga }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->status->nama_status ?? '-' }}</td>
                            <td>
                                <button type="button" class="btn-edit-produk" data-id="{{ $item->id_produk }}"
                                    data-nama="{{ $item->nama_produk }}" data-harga="{{ $item->harga }}"
                                    data-kategori="{{ $item->kategori_id }}" data-status="{{ $item->status_id }}">
                                    Edit
                                </button>

                                <form action="/produk/{{ $item->id_produk }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Data kosong</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="actions">
                <button id="filter-bisa-dijual">Bisa Dijual</button>
                <button id="filter-all">Semua Produk</button>
                <a href="#" id="btn-tambah-produk">Tambah Produk</a>
            </div>
        </section>
    </section>

    {{-- ================= MODAL TAMBAH ================= --}}
    <div id="modal-tambah-produk" class="modal hidden">
        <div class="modal-content">
            <h2>Tambah Produk</h2>

            <form action="/produk" method="POST">
                @csrf
                <input type="text" name="nama_produk" placeholder="Nama Produk" value="{{ old('nama_produk') }}">
                <input type="number" name="harga" placeholder="Harga" value="{{ old('harga') }}">
                <select name="kategori_id">
                    <option disabled selected>-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <select name="status_id">
                    <option disabled selected>-- Pilih Status --</option>
                    @foreach ($status as $s)
                        <option value="{{ $s->id_status }}">{{ $s->nama_status }}</option>
                    @endforeach
                </select>
                <div class="modal-actions">
                    <button type="submit">Simpan</button>
                    <button type="button" id="btn-close-modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= MODAL EDIT ================= --}}
    <div id="modal-edit-produk" class="modal hidden">
        <div class="modal-content">
            <h2>Edit Produk</h2>

            <form id="form-edit-produk" method="POST">
                @csrf @method('PUT')
                <input id="edit-nama-produk" name="nama_produk">
                <input id="edit-harga-produk" name="harga">
                <select id="edit-kategori-produk" name="kategori_id">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
                <select id="edit-status-produk" name="status_id">
                    @foreach ($status as $s)
                        <option value="{{ $s->id_status }}">{{ $s->nama_status }}</option>
                    @endforeach
                </select>
                <div class="modal-actions">
                    <button type="submit">Update</button>
                    <button type="button" id="btn-close-edit-modal">Batal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // FILTER
            document.getElementById('filter-bisa-dijual')?.addEventListener('click', () => {
                document.querySelectorAll('.card.produk tbody tr')
                    .forEach(r => r.style.display = r.dataset.status === 'bisa dijual' ? '' : 'none');
            });

            document.getElementById('filter-all')?.addEventListener('click', () => {
                document.querySelectorAll('.card.produk tbody tr')
                    .forEach(r => r.style.display = '');
            });

            // MODAL TAMBAH
            toggleModal('btn-tambah-produk', 'modal-tambah-produk', 'btn-close-modal');

            // MODAL EDIT
            document.querySelectorAll('.btn-edit-produk').forEach(btn => {
                btn.addEventListener('click', () => {
                    formEdit.action = `/produk/${btn.dataset.id}`;
                    editNama.value = btn.dataset.nama;
                    editHarga.value = btn.dataset.harga;
                    editKategori.value = btn.dataset.kategori;
                    editStatus.value = btn.dataset.status;
                    modalEdit.classList.remove('hidden');
                });
            });

            document.getElementById('btn-close-edit-modal')
                ?.addEventListener('click', () => modalEdit.classList.add('hidden'));

            // KONFIRMASI UPDATE
            const formEdit = document.getElementById('form-edit-produk');
            formEdit.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin update produk?',
                    text: 'Perubahan akan disimpan',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Update',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // DELETE
            document.querySelectorAll('.btn-hapus').forEach(btn => {
                btn.addEventListener('click', () => {
                    const form = btn.closest('form');
                    Swal.fire({
                        title: 'Yakin hapus?',
                        icon: 'warning',
                        showCancelButton: true
                    }).then(r => r.isConfirmed && form.submit());
                });
            });

            // ALERT
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Form masih salah, Harap diisi dengan benar!'
                });
                document.getElementById('modal-tambah-produk').classList.remove('hidden');
            @endif

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}'
                });
            @endif
        });

        // HELPER FUNCTION
        function toggleModal(openId, modalId, closeId) {
            document.getElementById(openId)?.addEventListener('click', e => {
                e.preventDefault();
                document.getElementById(modalId).classList.remove('hidden');
            });
            document.getElementById(closeId)?.addEventListener('click', () => {
                document.getElementById(modalId).classList.add('hidden');
            });
        }

        const modalEdit = document.getElementById('modal-edit-produk');
        const formEdit = document.getElementById('form-edit-produk');
        const editNama = document.getElementById('edit-nama-produk');
        const editHarga = document.getElementById('edit-harga-produk');
        const editKategori = document.getElementById('edit-kategori-produk');
        const editStatus = document.getElementById('edit-status-produk');
    </script>
@endsection
