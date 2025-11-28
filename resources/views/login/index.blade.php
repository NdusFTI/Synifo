<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Synifo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <style>
      body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-md-6 col-lg-5">
          <div class="card shadow-sm border-0">
            <div class="card-body p-5">
              <div class="text-center mb-4">
                <div class="display-4 mb-3">🗾</div>
                <h2 class="font-weight-bold text-primary">Synifo</h2>
                <p class="text-muted">Masuk ke akun Anda</p>
              </div>

              @if(session('alert'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <i class="bi bi-info-circle-fill mr-2"></i>
                  <strong>{{ session('alert') }}</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div class="form-group">
                  <label for="email" class="font-weight-semibold">Email</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white">
                        <i class="bi bi-envelope"></i>
                      </span>
                    </div>
                    <input type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="nama@example.com"
                        required 
                        autofocus>
                    @error('email')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="password" class="font-weight-semibold">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white">
                        <i class="bi bi-lock"></i>
                      </span>
                    </div>
                    <input type="password" 
                          class="form-control @error('password') is-invalid @enderror" 
                          id="password" 
                          name="password"
                          placeholder="Masukkan password"
                          required>
                    @error('password')
                      <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="form-group d-flex justify-content-between align-items-center">
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Lupa Password?</a>
                  @endif
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg mt-4">
                  <i class="bi bi-box-arrow-in-right mr-2"></i>Masuk
                </button>
              </form>
            </div>
          </div>

          <div class="text-center mt-4">
            <small class="text-muted">&copy; 2024 Synifo. All rights reserved.</small>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
      integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>