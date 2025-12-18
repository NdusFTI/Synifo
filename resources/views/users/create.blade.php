@extends('layouts.app')

@section('title', 'Tambah User - Synifo')

@section('content')
  <div class="container py-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent px-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card">
          <div class="card-body">
            <h3 class="mb-4">✨ Tambah User Baru</h3>

            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                <label><strong>Nama</strong> <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-control-lg"
                  placeholder="Contoh: John Doe" required>
                @error('name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label><strong>Email</strong> <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control form-control-lg"
                  placeholder="contoh@email.com" required>
                @error('email')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label><strong>Password</strong> <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" 
                  placeholder="Minimal 8 karakter" required>
                <small class="text-muted">Minimal 8 karakter</small>
                @error('password')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label><strong>Foto Profil</strong> <small class="text-muted">(opsional)</small></label>
                <input type="file" name="photo" class="form-control-file" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                @error('photo')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
              </div>

              <hr class="my-4">

              <div class="d-flex justify-content-between">
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Simpan User
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection