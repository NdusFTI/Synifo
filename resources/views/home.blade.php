@extends('layouts.app')

@section('title', 'Dashboard - Synifo')

@section('card-header', 'Dashboard Synifo - Explore Japan')

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-geo-alt text-danger" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalDestinasi }}</h2>
                <small class="text-muted">Destinasi Wisata</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-map text-primary" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalLokasi }}</h2>
                <small class="text-muted">Lokasi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-tags text-success" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ $totalKategori }}</h2>
                <small class="text-muted">Kategori</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-star text-warning" style="font-size: 2.5rem;"></i>
                <h2 class="mt-2 mb-0">{{ number_format($rataRating, 1) }}</h2>
                <small class="text-muted">Rating</small>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-star-fill text-warning"></i> Top 5 Destinasi</h5>
                @if(count($destinasiPopuler) > 0)
                    @foreach($destinasiPopuler as $index => $destinasi)
                    <div class="d-flex mb-3 pb-3 {{ $index < 4 ? 'border-bottom' : '' }}">
                        <div class="mr-3">
                            @if($destinasi->gambar_url)
                                <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="rounded" width="100" height="70" style="object-fit: cover;">
                            @else
                                <div style="width: 100px; height: 70px; background: #f0f0f0;" class="rounded d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $destinasi->nama_destinasi }}</h6>
                            <p class="mb-1 text-muted small">{{ substr($destinasi->deskripsi, 0, 60) }}...</p>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-info mr-2">{{ $destinasi->kategori }}</span>
                                <small class="text-muted"><i class="bi bi-pin-map"></i> {{ $destinasi->lokasi }}</small>
                                <span class="ml-auto text-warning">
                                    @for($i = 0; $i < floor($destinasi->rating); $i++)<i class="bi bi-star-fill"></i>@endfor
                                    <small class="text-muted ml-1">{{ number_format($destinasi->rating, 1) }}</small>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-muted py-4">Belum ada data</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <h5 class="mb-3"><i class="bi bi-tags text-success"></i> Kategori</h5>
                @if(count($kategoriBadges) > 0)
                    @foreach($kategoriBadges as $kat)
                    <span class="badge badge-primary mr-1 mb-2">{{ $kat['kategori'] }} ({{ $kat['total'] }})</span>
                    @endforeach
                @else
                    <p class="text-muted">Belum ada kategori</p>
                @endif
            </div>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <a href="{{ route('destinasi.create') }}" class="btn btn-danger btn-block mb-2">
                    <i class="bi bi-plus-circle"></i> Tambah Destinasi
                </a>
                <a href="{{ route('destinasi.index') }}" class="btn btn-primary btn-block">
                    <i class="bi bi-list-ul"></i> Lihat Semua
                </a>
            </div>
        </div>
    </div>
</div>
@endsection