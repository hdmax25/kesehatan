@extends('layouts.login')

@section('content')
  <div class="login-logo">
    <a href="{{ url('/') }}">
      <img src="{{ asset('dist/img/logo.jpg') }}" class="login-logo img-circle elevation-2" style="width: 300px;" alt="logo">
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="card elevation-2">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login</p>
      <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Masukan NIP">
          <div class="input-group-append">
            <div class="input-group-text">
              <div class="fas fa-user"></div>
            </div>
          </div>
          @error('username')
          <div class="text-danger" role="alert">
            <small>{{ $message }}</small>
          </div>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Default Password : user">
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
          <div class="col-8"></div>
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">
              Login
            </button>
          </div>
        </div>
      </form>

    </div>
  </div>
@endsection