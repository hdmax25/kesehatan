@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Home
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Home
          </a>
        </li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="card card-danger card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar5.png') }}" alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->department ? $user->department->name : '' }}</p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>NIP</b> <a class="float-right">{{ $user->username }}</a>
            </li>
            <li class="list-group-item">
              <b>Phone</b> <a class="float-right">{{ $user->phone }}</a>
            </li>
            <li class="list-group-item">
              <b>Alamat</b> <a class="float-right">{{ $user->ktpaddress }}</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link {{ $errors->isEmpty() ? 'active' : '' }}" href="#timeline" data-toggle="tab">History</a></li>
            <li class="nav-item"><a class="nav-link {{ $errors->isEmpty() ? '' : 'active' }}" href="#settings" data-toggle="tab">Edit</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane {{ $errors->isEmpty() ? 'active' : '' }}" id="timeline">
              <div class="timeline timeline-inverse">
                @foreach($report as $item)
                  <div class="time-label">
                  <span class="bg-success">
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                  </span>
                  </div>
                  <div>
                    <i class="fas fa-heartbeat bg-success"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</span>
                      <h3 class="timeline-header">{{ $item->disease ? $item->disease->penyakit_name : "?" }}</h3>
                      <div class="timeline-body">
                        {!! $item->deatail !!}
                      </div>
                      <div class="timeline-footer">
                      </div>
                    </div>
                  </div>
                @endforeach
                <div>
                  <i class="far fa-clock bg-gray"></i>
                </div>
              </div>
            </div>
            <div class="tab-pane {{ $errors->isEmpty() ? '' : 'active' }}" id="settings">
              <form class="form-horizontal" action="{{ route('user.updateProfile', $user->id) }}" method="post">
                @csrf
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="" value="{{ old('name') ? old('name') : $user->name }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="" value="{{ old('phone') ? old('phone') : $user->phone }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label">Pasword <small>Kosongi jika tidak diubah</small></label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="" value="{{ old('password') }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Alamat">{{ old('address') ? old('address') : $user->ktpaddress }}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="check" name="check" class="">
                        <span class="@error('check') text-danger @enderror">
                          Data sudah benar
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css')
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('js')
  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

  <script>
    $(function () {
      @error('password')
      toastr.warning('{{ $message }}')
      @enderror

      @error('phone')
      toastr.warning('{{ $message }}')
      @enderror

      @error('name')
      toastr.warning('{{ $message }}')
      @enderror

      @error('check')
      toastr.warning('{{ $message }}')
      @enderror

      @error('address')
      toastr.warning('{{ $message }}')
      @enderror

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif

    });
  </script>
@endsection
