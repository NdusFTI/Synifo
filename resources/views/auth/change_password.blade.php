@extends('layouts.app')

@section('title', 'Change Password - Synifo')

@section('content')
  <div class="container py-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent px-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Change Password</li>
      </ol>
    </nav>

    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="card">
          <div class="card-body">
            <h3 class="mb-4">✏️ Change Password</h3>
            @if(session('alert'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill mr-2"></i>
                <strong>{{ session('alert') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <form action="{{ route('change.password.post') }}" method="POST">
              @csrf

              <div class="form-group">
                <label><strong>Current Password</strong> <span class="text-danger">*</span></label>
                <input type="password" name="current_password" class="form-control form-control-lg" required>
                @error('current_password')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label><strong>New Password</strong> <span class="text-danger">*</span></label>
                <input type="password" name="new_password" class="form-control form-control-lg" required>
                @error('new_password')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary">
                <i class="bi bi-save mr-2"></i>Simpan Perubahan
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection