@extends('layouts.login')

@section('content')
  <div class="login-logo">
    <small>Monitoring Kesehatan Pegawai</small>
    <a href="{{ url('/') }}">
      <img src="{{ asset('dist/img/logo.png') }}" class="login-logo" style="width: 300px;" alt="logo">
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="card elevation-2">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login dengan NIP</p>
      <form action="{{ route('login') }}" method="post">
        @csrf
        @error('username')
          <div class="text-danger" role="alert">
            <small>{{ $message }}</small>
          </div>
        @enderror
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control @error('username')is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Masukkan NIP">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukan Katasandi">
          <div class="input-group-append">
            <div class="input-group-text">
              <div class="fas fa-lock"></div>
            </div>
          </div>
          @error('password')
          <div class="text-danger" role="alert">
            <small>{{ $message }}</small>
          </div>
          @enderror
        </div>

        <div class="row">
        <div class="col-8">
            <div class="icheck-danger">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">
              Login
            </button>
          </div>
        </div>
      </form>
      <div class="social-auth-links text-center mb-3">
        <p>- Tidak bisa login -</p>
        <a href="https://docs.google.com/document/d/e/2PACX-1vSvYNZ7I3wv04R8JadMADkzrmaUWhe50I3KbX3nJxd7VXtFpkI8Z4up340hHU-Q-0w7Gb9gcrrY1xPX/pub" target="_blank" class="btn btn-block btn-primary">
          <i class="fa fa-book mr-2"></i> Baca Panduan
        </a>
        <a href="https://api.whatsapp.com/send?phone=628980028222&text=Saya%20tidak%20bisa%20login%20mohon%20dibantu%0ANIP%20%3A%20{{ old('username') }}%0ANama%20lengkap%20%3A%0ATerimakasih&source=&data=&app_absent=" class="btn btn-block btn-success">
          <i class="fab fa-whatsapp mr-2"></i> Hubungi Admin
        </a>
      </div>
    </div>
  </div>
@endsection