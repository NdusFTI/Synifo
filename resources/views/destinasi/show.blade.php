@extends('layouts.app')
@section('title', $destinasi->nama_destinasi . ' - Synifo')
@section('content')
  <div class="container py-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent px-0">
        @auth
          <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Dashboard</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('destinasi.index') }}">Destinasi</a>
          </li>
        @endauth
        @guest
          <li class="breadcrumb-item">
            <a href="{{ route('visitor.search.destination') }}">Destinasi Wisata</a>
          </li>
        @endguest
        <li class="breadcrumb-item active">{{ $destinasi->nama_destinasi }}</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-lg-8 mb-4">
        <div class="card">
          <div class="show-img-wrapper">
            <img src="{{
              $destinasi->gambar_url
                ? asset($destinasi->gambar_url)
                : '/storage/poster/NoImage.png'
            }}" alt="{{ $destinasi->nama_destinasi }}" class="img-fluid w-100 show-img" />
          </div>

          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <h2 class="mb-0">{{ $destinasi->nama_destinasi }}</h2>
              <span class="badge badge-info badge-show-kategori">
                {{ $destinasi->kategori }}
              </span>
            </div>

            <div class="mb-4">
              <div class="d-inline-flex align-items-center mr-4 mb-2">
                <i class="bi bi-pin-map-fill text-danger mr-2 icon-lg"></i>
                <span><strong>{{ $destinasi->lokasi }}</strong></span>
              </div>
              <div class="d-inline-flex align-items-center mb-2">
                <i class="bi bi-star-fill text-warning mr-2 icon-lg"></i>
                <span class="text-warning mr-2">
                  @for ($i = 0; $i < floor($destinasi->rating); $i++)
                    <i class="bi bi-star-fill"></i>
                  @endfor
                  @if ($destinasi->rating - floor($destinasi->rating) >= 0.5)
                    <i class="bi bi-star-half"></i>
                  @endif
                </span>
                <strong>{{ number_format($destinasi->rating, 1) }}</strong>
                / 5.0
              </div>
            </div>

            <hr />

            <h5 class="mb-3">Deskripsi</h5>
            <p class="text-muted deskripsi-text">
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
              <span class="badge badge-info badge-info-kategori">
                {{ $destinasi->kategori }}
              </span>
            </div>

            <div class="mb-3 pb-3 border-bottom">
              <small class="text-muted d-block mb-1">Lokasi</small>
              <strong>
                <i class="bi bi-pin-map text-danger"></i>
                {{ $destinasi->lokasi }}
              </strong>
            </div>

            <div class="mb-0">
              <small class="text-muted d-block mb-1">Rating</small>
              <div class="text-warning rating-info">
                @for ($i = 0; $i < floor($destinasi->rating); $i++)
                  <i class="bi bi-star-fill"></i>
                @endfor
                @if ($destinasi->rating - floor($destinasi->rating) >= 0.5)
                  <i class="bi bi-star-half"></i>
                @endif
                <strong class="text-dark ml-2">
                  {{ number_format($destinasi->rating, 1) }}
                </strong>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection