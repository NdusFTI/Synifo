@extends('layouts.app')

@section('title', 'Destinasi Wisata - Synifo')

@section('content')
<div class="container py-4" style="max-width: 1400px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="mb-1">✈️ Semua Destinasi Wisata</h2>
      <p class="text-muted mb-0">Jelajahi {{ count($destinasi) }} destinasi wisata Jepang</p>
    </div>
    <a href="{{ route('destinasi.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Tambah Destinasi
    </a>
  </div>

  @if(count($destinasi) > 0)
    <div class="row">
      @foreach($destinasi as $item)
      <div class="col-md-4 col-lg-3 col-xl-2-4 mb-4">
        <div class="card destination-card h-100">
          <div style="position: relative; overflow: hidden;">
            @if($item->gambar_url)
              <img src="{{ $item->gambar_url }}" class="card-img-top" alt="{{ $item->nama_destinasi }}">
            @else
              <div style="height: 220px; background: linear-gradient(135deg, #f0f0f0 0%, #fafafa 100%);" class="d-flex align-items-center justify-content-center">
                <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
              </div>
            @endif
            <div style="position: absolute; top: 10px; right: 10px;">
              <span class="badge badge-info" style="font-size: 0.85rem;">{{ $item->kategori }}</span>
            </div>
          </div>
          
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2">{{ $item->nama_destinasi }}</h5>
            <p class="card-text text-muted small mb-3 flex-grow-1">
              {{ substr($item->deskripsi, 0, 85) }}{{ strlen($item->deskripsi) > 85 ? '...' : '' }}
            </p>
            
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div style="color: #ffc107;">
                  @for($i = 0; $i < floor($item->rating); $i++)<i class="bi bi-star-fill"></i>@endfor
                  @if($item->rating - floor($item->rating) >= 0.5)<i class="bi bi-star-half"></i>@endif
                  <small class="text-muted ml-1">{{ number_format($item->rating, 1) }}</small>
                </div>
              </div>
              <small class="text-muted">
                <i class="bi bi-pin-map" style="color: #f5b5c7;"></i> {{ $item->lokasi }}
              </small>
            </div>
            
            <div class="row">
              <div class="col-4">
                <a href="{{ route('destinasi.show', $item->id) }}" class="btn btn-sm btn-block d-flex align-items-center justify-content-center" style="background: #5DADE2; border: none; color: white; padding: 8px;" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
              </div>
              <div class="col-4">
                <a href="{{ route('destinasi.edit', $item->id) }}" class="btn btn-sm btn-block d-flex align-items-center justify-content-center" style="background: #FFA726; border: none; color: white; padding: 8px;" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
              </div>
              <div class="col-4">
                <button type="button" class="btn btn-sm btn-block d-flex align-items-center justify-content-center" style="background: #EF5350; border: none; color: white; padding: 8px;" onclick="confirmDelete({{ $item->id }})" title="Hapus">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
            
            <form id="delete-form-{{ $item->id }}" action="{{ route('destinasi.destroy', $item->id) }}" method="POST" style="display: none;">
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
        <i class="bi bi-inbox" style="font-size: 5rem; color: #ddd;"></i>
        <h4 class="mt-4 text-muted">Belum ada destinasi wisata</h4>
        <p class="text-muted">Mulai tambahkan destinasi wisata Jepang favorit Anda</p>
        <a href="{{ route('destinasi.create') }}" class="btn btn-primary mt-3">
          <i class="bi bi-plus-circle"></i> Tambah Destinasi Pertama
        </a>
      </div>
    </div>
  @endif
</div>

<style>
@media (min-width: 1400px) {
  .col-xl-2-4 {
    flex: 0 0 20%;
    max-width: 20%;
  }
}
</style>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
  if(confirm('Apakah Anda yakin ingin menghapus destinasi ini?')) {
    document.getElementById('delete-form-' + id).submit();
  }
}
</script>
@endpush