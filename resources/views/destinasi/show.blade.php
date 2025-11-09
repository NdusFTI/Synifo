@extends('layouts.app')

@section('title', 'Detail Destinasi')

@section('card-header', 'Detail Destinasi Wisata')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        @if($destinasi->gambar_url)
                            <img src="{{ $destinasi->gambar_url }}" alt="{{ $destinasi->nama_destinasi }}" class="img-fluid rounded">
                        @else
                            <div style="width: 100%; height: 200px; background: #f0f0f0;" class="rounded d-flex align-items-center justify-content-center">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h3>{{ $destinasi->nama_destinasi }}</h3>
                        <p class="text-muted mb-3">{{ $destinasi->deskripsi }}</p>
                        
                        <div class="mb-2">
                            <i class="bi bi-pin-map text-danger"></i> 
                            <strong>Lokasi:</strong> {{ $destinasi->lokasi }}
                        </div>
                        
                        <div class="mb-2">
                            <i class="bi bi-tags text-info"></i> 
                            <strong>Kategori:</strong> 
                            <span class="badge badge-info">{{ $destinasi->kategori }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <i class="bi bi-star-fill text-warning"></i> 
                            <strong>Rating:</strong> 
                            <span class="text-warning">
                                @for($i = 0; $i < floor($destinasi->rating); $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                @if($destinasi->rating - floor($destinasi->rating) >= 0.5)
                                    <i class="bi bi-star-half"></i>
                                @endif
                            </span>
                            {{ number_format($destinasi->rating, 1) }}/5
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('destinasi.edit', $destinasi->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('destinasi.destroy', $destinasi->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
