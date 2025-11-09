@extends('layouts.app')

@section('title', 'Edit Destinasi')

@section('card-header', 'Edit Destinasi Wisata')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('destinasi.update', $destinasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Nama Destinasi</label>
                        <input type="text" name="nama_destinasi" class="form-control" value="{{ old('nama_destinasi', $destinasi->nama_destinasi) }}" required>
                        @error('nama_destinasi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $destinasi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $destinasi->lokasi) }}" required>
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
                                    <option value="Kuil" {{ old('kategori', $destinasi->kategori) == 'Kuil' ? 'selected' : '' }}>Kuil</option>
                                    <option value="Gunung" {{ old('kategori', $destinasi->kategori) == 'Gunung' ? 'selected' : '' }}>Gunung</option>
                                    <option value="Taman" {{ old('kategori', $destinasi->kategori) == 'Taman' ? 'selected' : '' }}>Taman</option>
                                    <option value="Museum" {{ old('kategori', $destinasi->kategori) == 'Museum' ? 'selected' : '' }}>Museum</option>
                                    <option value="Pantai" {{ old('kategori', $destinasi->kategori) == 'Pantai' ? 'selected' : '' }}>Pantai</option>
                                    <option value="Kastil" {{ old('kategori', $destinasi->kategori) == 'Kastil' ? 'selected' : '' }}>Kastil</option>
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
                                <input type="number" name="rating" class="form-control" value="{{ old('rating', $destinasi->rating) }}" min="0" max="5" step="0.1" required>
                                @error('rating')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Gambar <small class="text-muted">(opsional)</small></label>
                                <input type="text" name="gambar_url" class="form-control" value="{{ old('gambar_url', $destinasi->gambar_url) }}">
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('destinasi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-save"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
