@extends('layouts.app')
@section('title', 'Users - Synifo')
@section('content')
  <div class="container container-destinasi py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1">👥 Semua Users</h2>
      </div>
      <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Tambah User
      </a>
    </div>

    @if (count($users) > 0)
      <div class="row">
        @foreach ($users as $item)
          <div class="col-md-4 col-lg-3 col-xl-2-4 mb-4">
            <div class="card destination-card h-100">
              <div class="card-img-wrapper">
                @if ($item->photo)
                  <img src="{{ asset($item->photo) }}" class="card-img-top" alt="{{ $item->name }}" />
                @else
                  <div class="empty-img-placeholder d-flex align-items-center justify-content-center">
                    <i class="bi bi-image empty-img-icon"></i>
                  </div>
                @endif
              </div>

              <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-2">{{ $item->name }}</h5>
                <p class="card-text text-muted small mb-3 flex-grow-1">
                  {{ $item->email }}
                </p>

                <div class="mb-3">
                  <small class="text-muted">
                    <i class="bi bi-calendar"></i>
                    Bergabung: {{ $item->created_at->format('d M Y') }}
                  </small>
                </div>

                <div class="row">
                  <div class="col-4">
                    <button type="button"
                      class="btn btn-sm btn-block btn-action-delete d-flex align-items-center justify-content-center"
                      onclick="confirmDelete({{ $item->id }})" title="Hapus">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </div>

                <form id="delete-form-{{ $item->id }}" action="{{ route('users.destroy', $item->id) }}"
                  method="POST" style="display: none">
                  @csrf
                  @method('DELETE')
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="card">
        <div class="card-body text-center py-5">
          <i class="bi bi-inbox empty-state-icon"></i>
          <h4 class="mt-4 text-muted">Belum ada users</h4>
          <p class="text-muted">
            Mulai tambahkan user baru
          </p>
          <a href="{{ route('users.create') }}" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i>
            Tambah User Pertama
          </a>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
  <script>
    function confirmDelete(id) {
      if (confirm("Apakah Anda yakin ingin menghapus user ini?")) {
        document.getElementById("delete-form-" + id).submit();
      }
    }
  </script>
@endpush