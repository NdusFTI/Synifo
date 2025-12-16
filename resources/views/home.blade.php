@extends('layouts.app')
@section('title', 'Dashboard - Synifo')
@section('content')
  @if(session('alert'))
    <div class="alert alert-warning alert-dismissible fade show border-0 mb-0" role="alert" style="border-radius: 0; padding: 1rem 0;">
      <div class="container">
        <div class="d-flex align-items-center">
          <i class="bi bi-info-circle-fill mr-3" style="font-size: 1.25rem;"></i>
          <div class="flex-grow-1">
            <strong>{{ session('alert') }}</strong>
          </div>
          <button type="button" class="close m-0 p-0 d-flex align-items-center justify-content-center" data-dismiss="alert" aria-label="Close" style="width: 24px; height: 24px; opacity: 0.7;">
            <span aria-hidden="true" style="line-height: 1;">&times;</span>
          </button>
        </div>
      </div>
    </div>
  @endif

  <div class="hero-section">
    <div class="container text-center">
      <h1>🗾 Explore Japan</h1>
      <p>Temukan destinasi wisata terbaik di Jepang</p>
    </div>
  </div>

  <div class="container pb-5">
    <div class="row mb-4">
      <div class="col-md-3 mb-3">
        <div class="stat-card">
          <i class="bi bi-geo-alt"></i>
          <h2>{{ $totalDestinasi }}</h2>
          <p class="mb-0">Destinasi Wisata</p>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-pink">
          <i class="bi bi-map"></i>
          <h2>{{ $totalLokasi }}</h2>
          <p class="mb-0">Lokasi</p>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-green">
          <i class="bi bi-tags"></i>
          <h2>{{ $totalKategori }}</h2>
          <p class="mb-0">Kategori</p>
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <div class="stat-card stat-card-orange">
          <i class="bi bi-star-fill"></i>
          <h2>{{ number_format($rataRating, 1) }}</h2>
          <p class="mb-0">Rata-rata Rating</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h4 class="mb-0">
                <i class="bi bi-star-fill text-warning"></i>
                Top Destinasi
              </h4>
              <a href="{{ route('destinasi.index') }}" class="btn btn-sm btn-primary">
                Lihat Semua
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>

            @if (count($destinasiPopuler) > 0)
              <div class="row">
                @foreach ($destinasiPopuler as $destinasi)
                  <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card destination-card h-100"
                      onclick="window.location.href='{{ route('destinasi.show', $destinasi->id) }}'">
                      <img src="{{
                        $destinasi->gambar_url
                          ? asset($destinasi->gambar_url)
                          : 'storage/poster/NoImage.png'
                      }}" class="card-img-top" alt="{{ $destinasi->nama_destinasi }}" />
                      <div class="card-body">
                        <h5 class="card-title mb-2">
                          {{ $destinasi->nama_destinasi }}
                        </h5>
                        <p class="card-text text-muted small mb-3">
                          {{ substr($destinasi->deskripsi, 0, 100) }}...
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <span class="badge badge-info">
                            {{ $destinasi->kategori }}
                          </span>
                          <div class="text-warning">
                            @for ($i = 0; $i < floor($destinasi->rating); $i++)
                              <i class="bi bi-star-fill"></i>
                            @endfor
                            <small class="text-muted ml-1">
                              {{ number_format($destinasi->rating, 1) }}
                            </small>
                          </div>
                        </div>
                        <div>
                          <small class="text-muted">
                            <i class="bi bi-pin-map text-danger"></i>
                            {{ $destinasi->lokasi }}
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @else
              <div class="text-center py-5">
                <i class="bi bi-inbox empty-img-icon"></i>
                <p class="text-muted mt-3">Belum ada destinasi wisata</p>
                <a href="{{ route('destinasi.create') }}" class="btn btn-primary">
                  <i class="bi bi-plus-circle"></i>
                  Tambah Destinasi Pertama
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    @if (count($kategoriBadges) > 0)
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h5 class="mb-3">
                <i class="bi bi-tags text-success"></i>
                Kategori Populer
              </h5>
              <div>
                @foreach ($kategoriBadges as $kat)
                  <span class="badge badge-primary badge-kategori-populer mr-2 mb-2">
                    {{ $kat['kategori'] }}
                    <span class="badge badge-light ml-1">{{ $kat['total'] }}</span>
                  </span>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection