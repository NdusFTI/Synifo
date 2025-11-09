<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css">

    <title>@yield("title", "Synifo - Destinasi Wisata Jepang")</title>
    
    <style>
      body { background: #f8f9fa; }
      .navbar-brand { font-weight: bold; font-size: 1.5rem; }
      .card { border-radius: 8px; }
      .nav-link { border-radius: 6px; margin-bottom: 4px; color: #6c757d !important; }
      .nav-link:hover { background: #e9ecef; color: #495057 !important; }
      .nav-link.active { background: #dc3545 !important; color: white !important; }
      .table td { vertical-align: middle; }
      .shadow-sm { box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.075) !important; }
      .btn-group-sm .btn { margin-right: 4px; }
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <!-- Header -->
      <div class="row">
        <div class="col-md-12 py-3 bg-danger shadow-sm">
          <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
              <div class="text-white">
                <span class="navbar-brand mb-0">🗾 Synifo</span>
                <small class="ml-2">Destinasi Wisata Jepang</small>
              </div>
              <div class="text-white">
                <small><i class="bi bi-clock"></i> {{ date('d M Y, H:i') }} WIB</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="row">
        <div class="col-md-2 bg-white shadow-sm" style="min-height: 100vh;">
          <div class="nav flex-column nav-pills mt-3 px-2" role="tablist">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">
              <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->is('destinasi*') ? 'active' : '' }}" href="{{ route('destinasi.index') }}">
              <i class="bi bi-geo-alt"></i> Destinasi Wisata
            </a>
          </div>
        </div>

        <div class="col-md-10 p-4">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
              <h5 class="mb-0 text-danger">@yield('card-header', 'Dashboard Synifo')</h5>
            </div>
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <i class="bi bi-check-circle"></i> {{ session('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    
    @stack('scripts')
  </body>
</html>