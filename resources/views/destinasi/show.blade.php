@extends('layouts.app')

@section('title', $destinasi->nama_destinasi . ' - Synifo')

@section('content')
<div class="container py-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}">Destinasi</a></li>
      <li class="breadcrumb-item active">{{ $destinasi->nama_destinasi }}</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8 mb-4">
      <div class="card">
        <div style="overflow: hidden; max-height: 500px;">
          @if($destinasi->gambar_url)
            <img src="{{ asset($destinasi->gambar_url) }}" alt="{{ $destinasi->nama_destinasi }}" class="img-fluid w-100" style="object-fit: cover;">
          @else
            <div style="height: 400px; background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);" class="d-flex align-items-center justify-content-center">
              <i class="bi bi-image" style="font-size: 6rem; color: #999;"></i>
            </div>
          @endif
        </div>
        
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <h2 class="mb-0">{{ $destinasi->nama_destinasi }}</h2>
            <span class="badge badge-info" style="font-size: 1rem; padding: 8px 16px;">{{ $destinasi->kategori }}</span>
          </div>
          
          <div class="mb-4">
            <div class="d-inline-flex align-items-center mr-4 mb-2">
              <i class="bi bi-pin-map-fill text-danger mr-2" style="font-size: 1.2rem;"></i>
              <span><strong>{{ $destinasi->lokasi }}</strong></span>
            </div>
            <div class="d-inline-flex align-items-center mb-2">
              <i class="bi bi-star-fill text-warning mr-2" style="font-size: 1.2rem;"></i>
              <span class="text-warning mr-2">
                @for($i = 0; $i < floor($destinasi->rating); $i++)
                  <i class="bi bi-star-fill"></i>
                @endfor
                @if($destinasi->rating - floor($destinasi->rating) >= 0.5)
                  <i class="bi bi-star-half"></i>
                @endif
              </span>
              <strong>{{ number_format($destinasi->rating, 1) }}</strong> / 5.0
            </div>
          </div>
          
          <hr>
          
          <h5 class="mb-3">Deskripsi</h5>
          <p class="text-muted" style="line-height: 1.8; text-align: justify;">
            {{ $destinasi->deskripsi }}
          </p>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="mb-3">Informasi</h5>
          
          <div class="mb-3 pb-3 border-bottom">
            <small class="text-muted d-block mb-1">Kategori</small>
            <span class="badge badge-info" style="font-size: 0.9rem;">{{ $destinasi->kategori }}</span>
          </div>
          
          <div class="mb-3 pb-3 border-bottom">
            <small class="text-muted d-block mb-1">Lokasi</small>
            <strong><i class="bi bi-pin-map text-danger"></i> {{ $destinasi->lokasi }}</strong>
          </div>
          
          <div class="mb-0">
            <small class="text-muted d-block mb-1">Rating</small>
            <div class="text-warning" style="font-size: 1.1rem;">
              @for($i = 0; $i < floor($destinasi->rating); $i++)
                <i class="bi bi-star-fill"></i>
              @endfor
              @if($destinasi->rating - floor($destinasi->rating) >= 0.5)
                <i class="bi bi-star-half"></i>
              @endif
              <strong class="text-dark ml-2">{{ number_format($destinasi->rating, 1) }}</strong>
            </div>
          </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body">
          <h5 class="mb-3">Aksi</h5>
          
          <a href="{{ route('destinasi.edit', $destinasi->id) }}" class="btn btn-warning btn-block mb-2">
            <i class="bi bi-pencil"></i> Edit Destinasi
          </a>
          
          <form action="{{ route('destinasi.destroy', $destinasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus destinasi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-block mb-3">
              <i class="bi bi-trash"></i> Hapus Destinasi
            </button>
          </form>
          
          <a href="{{ route('destinasi.index') }}" class="btn btn-secondary btn-block">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection