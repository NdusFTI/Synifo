@extends('layouts.app')
@section('title', 'Destinasi Wisata - Synifo')
@section('content')
  <div class="container container-destinasi py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">✈️ Semua Destinasi Wisata</h2>
        <p class="text-muted mb-0">
          Jelajahi {{ count($destinasi) }} destinasi wisata Jepang
        </p>
      </div>
      <a href="{{ route('destinasi.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah Destinasi
      </a>
    </div>

    @if (count($destinasi) > 0)
      <div class="row">
        @foreach ($destinasi as $item)
          <div class="col-md-4 col-lg-3 col-xl-2-4 mb-4">
            <div class="card destination-card h-100">
              <div class="card-img-wrapper">
                @if ($item->gambar_url)
                  <img src="{{ asset($item->gambar_url) }}" class="card-img-top" alt="{{ $item->nama_destinasi }}" />
                @else
                  <div class="empty-img-placeholder d-flex align-items-center justify-content-center">
                    <i class="bi bi-image empty-img-icon"></i>
                  </div>
                @endif
                <div class="card-badge-overlay">
                  <span class="badge badge-info badge-kategori">
                    {{ $item->kategori }}
                  </span>
                </div>
              </div>

              <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-2">{{ $item->nama_destinasi }}</h5>
                <p class="card-text text-muted small mb-3 flex-grow-1">
                  {{ substr($item->deskripsi, 0, 85) }}{{ strlen($item->deskripsi) > 85 ? '...' : '' }}
                </p>

                <div class="mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="rating-stars">
                      @for ($i = 0; $i < floor($item->rating); $i++)
                        <i class="bi bi-star-fill"></i>
                      @endfor
                      @if ($item->rating - floor($item->rating) >= 0.5)
                        <i class="bi bi-star-half"></i>
                      @endif
                      <small class="text-muted ml-1">
                        {{ number_format($item->rating, 1) }}
                      </small>
                    </div>
                  </div>
                  <small class="text-muted">
                    <i class="bi bi-pin-map location-icon"></i>
                    {{ $item->lokasi }}
                  </small>
                </div>

                <div class="row">
                  <div class="col-4">
                    <a href="{{ route('destinasi.show', $item->id) }}"
                      class="btn btn-sm btn-block btn-action-detail d-flex align-items-center justify-content-center"
                      title="Detail">
                      <i class="bi bi-eye"></i>
                    </a>
                  </div>
                  <div class="col-4">
                    <a href="{{ route('destinasi.edit', $item->id) }}"
                      class="btn btn-sm btn-block btn-action-edit d-flex align-items-center justify-content-center"
                      title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                  </div>
                  <div class="col-4">
                    <button type="button"
                      class="btn btn-sm btn-block btn-action-delete d-flex align-items-center justify-content-center"
                      onclick="confirmDelete({{ $item->id }})" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>

                <form id="delete-form-{{ $item->id }}" action="{{ route('destinasi.destroy', $item->id) }}"
                  method="POST" style="display: none">
                  @csrf
                  @method('DELETE')
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="card">
        <div class="card-body text-center py-5">
          <i class="bi bi-inbox empty-state-icon"></i>
          <h4 class="mt-4 text-muted">Belum ada destinasi wisata</h4>
          <p class="text-muted">
            Mulai tambahkan destinasi wisata Jepang favorit Anda
          </p>
          <a href="{{ route('destinasi.create') }}" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i>
            Tambah Destinasi Pertama
          </a>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
  <script>
    function confirmDelete(id) {
      if (confirm("Apakah Anda yakin ingin menghapus destinasi ini?")) {
        document.getElementById("delete-form-" + id).submit();
      }
    }
  </script>
@endpush

