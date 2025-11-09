@extends('layouts.app')

@section('title', 'Tambah Destinasi')

@section('card-header', 'Tambah Destinasi Wisata')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('destinasi.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Nama Destinasi</label>
                        <input type="text" name="nama_destinasi" class="form-control" value="{{ old('nama_destinasi') }}" placeholder="Contoh: Gunung Fuji" required>
                        @error('nama_destinasi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" placeholder="Ceritakan tentang destinasi ini..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Tokyo, Jepang" required>
                                @error('lokasi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori</label>
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
                                <label>Rating (0-5)</label>
                                <input type="number" name="rating" class="form-control" value="{{ old('rating') }}" min="0" max="5" step="0.1" placeholder="4.5" required>
                                @error('rating')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Gambar <small class="text-muted">(opsional)</small></label>
                                <input type="text" name="gambar_url" class="form-control" value="{{ old('gambar_url') }}" placeholder="https://example.com/gambar.jpg">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
