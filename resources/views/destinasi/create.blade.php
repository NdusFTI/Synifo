@extends('layouts.app')

@section('title', 'Tambah Destinasi - Synifo')

@section('content')
<div class="container py-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent px-0">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('destinasi.index') }}">Destinasi</a></li>
      <li class="breadcrumb-item active">Tambah Destinasi</li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card">
        <div class="card-body">
          <h3 class="mb-4">✨ Tambah Destinasi Wisata Baru</h3>
          
          <form action="{{ route('destinasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
              <label><strong>Nama Destinasi</strong> <span class="text-danger">*</span></label>
              <input type="text" name="nama_destinasi" class="form-control form-control-lg" value="{{ old('nama_destinasi') }}" placeholder="Contoh: Gunung Fuji" required>
              @error('nama_destinasi')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label><strong>Deskripsi</strong> <span class="text-danger">*</span></label>
              <textarea name="deskripsi" class="form-control" rows="5" placeholder="Ceritakan tentang keindahan dan keunikan destinasi ini..." required>{{ old('deskripsi') }}</textarea>
              @error('deskripsi')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Lokasi</strong> <span class="text-danger">*</span></label>
                  <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Tokyo, Jepang" required>
                  @error('lokasi')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Kategori</strong> <span class="text-danger">*</span></label>
                  <select name="kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Kuil" {{ old('kategori') == 'Kuil' ? 'selected' : '' }}>Kuil</option>
                    <option value="Gunung" {{ old('kategori') == 'Gunung' ? 'selected' : '' }}>Gunung</option>
                    <option value="Taman" {{ old('kategori') == 'Taman' ? 'selected' : '' }}>Taman</option>
                    <option value="Museum" {{ old('kategori') == 'Museum' ? 'selected' : '' }}>Museum</option>
                    <option value="Pantai" {{ old('kategori') == 'Pantai' ? 'selected' : '' }}>Pantai</option>
                    <option value="Kastil" {{ old('kategori') == 'Kastil' ? 'selected' : '' }}>Kastil</option>
                  </select>
                  @error('kategori')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Rating</strong> <span class="text-danger">*</span></label>
                  <input type="number" name="rating" class="form-control" value="{{ old('rating') }}" min="0" max="5" step="0.1" placeholder="4.5" required>
                  <small class="text-muted">Nilai antara 0 - 5</small>
                  @error('rating')
                    <small class="text-danger d-block">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label><strong>Gambar</strong> <small class="text-muted">(opsional)</small></label>
                  <input type="file" name="gambar" class="form-control-file" accept="image/*">
                  <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                  @error('gambar')
                    <small class="text-danger d-block">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>

            <hr class="my-4">
            
            <div class="d-flex justify-content-between">
              <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan Destinasi
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection