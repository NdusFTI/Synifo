@extends('layouts.app')

@section('title', 'Data Destinasi Wisata')

@section('card-header', 'Data Destinasi Wisata')

@section('content')
<div class="mb-3">
    <a href="{{ route('destinasi.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-circle"></i> Tambah Destinasi
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tableDestinasi" class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($destinasi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->gambar_url)
                                <img src="{{ $item->gambar_url }}" alt="{{ $item->nama_destinasi }}" class="rounded" width="60" height="45" style="object-fit: cover;">
                            @else
                                <div style="width: 60px; height: 45px; background: #f0f0f0;" class="rounded d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->nama_destinasi }}</strong>
                            <br><small class="text-muted">{{ substr($item->deskripsi, 0, 50) }}...</small>
                        </td>
                        <td>
                            <i class="bi bi-pin-map text-danger"></i> {{ $item->lokasi }}
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $item->kategori }}</span>
                        </td>
                        <td>
                            <span class="text-warning">
                                @for($i = 0; $i < floor($item->rating); $i++)<i class="bi bi-star-fill"></i>@endfor
                            </span>
                            <br><small>{{ number_format($item->rating, 1) }}</small>
                        </td>
                        <td>
                            <a href="{{ route('destinasi.show', $item->id) }}" class="btn btn-sm btn-info" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('destinasi.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('destinasi.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin hapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableDestinasi').DataTable({
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data",
            "infoFiltered": "(dari _MAX_ data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "›",
                "previous": "‹"
            }
        },
        "pageLength": 10,
        "order": [[5, 'desc']]
    });
});
</script>
@endpush
