@extends('layouts.app')
@section('title', 'Destinasi Wisata - Synifo')
@section('content')
  <div class="container container-destinasi py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">✈️ Jelajahi Destinasi Wisata Jepang</h2>
        <p class="text-muted mb-0">
          @if(isset($keyword) && $keyword)
            Hasil pencarian untuk "{{ $keyword }}" - {{ count($destinasi) }} destinasi ditemukan
          @else
            Temukan {{ count($destinasi) }} destinasi wisata menarik di Jepang
          @endif
        </p>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <form action="{{ route('visitor.act') }}" method="GET" class="d-flex align-items-center">
          <input type="text" 
                class="form-control flex-grow-1" 
                name="keyword" 
                placeholder="Cari destinasi wisata (nama, lokasi, kategori)..." 
                value="{{ $keyword ?? '' }}">
          <button class="btn btn-primary ml-2 flex-shrink-0" type="submit">
            <i class="bi bi-search"></i> Cari
          </button>
          @if(isset($keyword) && $keyword)
            <a href="{{ route('visitor.search.destination') }}" class="btn btn-secondary ml-2 flex-shrink-0">
              <i class="bi bi-x-circle"></i> Reset
            </a>
          @endif
        </form>
      </div>
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
                  <div class="col-12">
                    <a href="{{ route('destinasi.show', $item->id) }}" class="btn btn-sm btn-block btn-action-detail">
                      <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="card">
        <div class="card-body text-center py-5">
          <i class="bi bi-inbox empty-state-icon"></i>
          <h4 class="mt-4 text-muted">
            @if(isset($keyword) && $keyword)
              Tidak ada destinasi ditemukan
            @else
              Belum ada destinasi wisata
            @endif
          </h4>
          <p class="text-muted">
            @if(isset($keyword) && $keyword)
              Coba gunakan kata kunci lain untuk pencarian Anda
            @else
              Belum ada data destinasi wisata tersedia
            @endif
          </p>
          @if(isset($keyword) && $keyword)
            <a href="{{ route('visitor.search.destination') }}" class="btn btn-primary mt-3">
              <i class="bi bi-arrow-left"></i>
              Kembali ke Semua Destinasi
            </a>
          @endif
        </div>
      </div>
    @endif
  </div>
@endsection
