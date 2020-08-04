@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Profile
      </h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-info alert-dismissible">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
          Fitur foto sementara dinonaktifkan, karena dalam masa pengembangan
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-danger card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar5.png') }}" alt="User profile picture">
          </div>

          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->job }} {{ $user->department->department_name}}</p>

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
            @if ($user->ktpaddress !== ($domicile ? $domicile->domicile : ''))
            <li class="list-group-item">
              <b>Domisili</b> <a class="float-right">{{ $domicile ? $domicile->domicile : 'Belum di isi' }}</a>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link {{ $errors->isEmpty() ? 'active' : '' }}" href="#timeline" data-toggle="tab"><i class="far fa-clock"></i> History</a></li>
            @if ( \Illuminate\Support\Facades\Auth::user()->username == $user->username)
              <li class="nav-item"><a class="nav-link {{ $errors->isEmpty() ? '' : 'active' }}" href="#settings" data-toggle="tab"><i class="far fa-edit"></i> Edit Profile</a></li>
            @endif
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane {{ $errors->isEmpty() ? 'active' : '' }}" id="timeline">
              <div class="timeline timeline-inverse">
                @foreach($report as $item)
                  <div class="time-label">
                  <span class="bg-primary">
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                  </span>
                  </div>
                  <div>
                    <i class="fas fa-heartbeat bg-{{ $item->disease->penyakit_name != 'Sehat' ? 'warning' : 'success' }}"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</span>
                      <h3 class="timeline-header"><a href="#">{{ $item->disease ? $item->disease->penyakit_name : "?" }}</a> di {{ $item->position ? $item->position : "?" }}</h3>
                      <div class="timeline-body">
                        Keluhan {!! $item->deatail !!}
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
              <form action="{{ route('user.updateImage', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                  <div class="col-sm-2 text-center">
                    <img id="imageView" class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/avatar5.png') }}" alt="User profile picture">
                  </div>
                  <div class="col-sm-10">
                    <label for="name">Foto</label>
                    <small>Max. 2Mb, Disarankan rasio 1:1</small>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <button type="submit" class="input-group-text">Upload</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <form class="form-horizontal" action="{{ route('user.updateProfile', $user->id) }}" method="post">
                @csrf
                <div class="form-group row">
                  <label for="name" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <small>Ganti nama silakan 
                      <a href="https://api.whatsapp.com/send?phone=628980028222&text=Tolong%20ganti%20nama%20saya%21%0ANIP%20%3A%20{{ $user->username }}%0ANama%20Lama%20%3A%20{{ $user->name }}%0ANama%20Baru%20%3A&source=&data=&app_absent=">
                        <i class="fab fa-whatsapp mr-2"></i>Hubungi Admin
                      </a>
                    </small>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="" style="text-transform:uppercase" value="{{ old('name') ? old('name') : $user->name }}" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                    <small>Wajib diawali dengan 62</small>
                    <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="" style="text-transform:uppercase" value="{{ old('phone') ? old('phone') : $user->phone }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label">Pasword</label>
                  <div class="col-sm-10">
                    <small>Kosongi jika tidak diubah</small>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="" value="{{ old('password') }}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Alamat" style="text-transform:uppercase">{{ old('address') ? old('address') : $user->ktpaddress }}</textarea>
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
  <!-- bs-custom-file-input -->
  <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
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

      @error('image')
      toastr.warning('{{ $message }}')
      @enderror

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif

      function readURL(input) {
        if (input.files && input.files[0]) {
          let reader = new FileReader();

          reader.onload = function (e) {
            $('#imageView').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#image").change(function () {
        readURL(this);
        let fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
      });
    });
  </script>
@endsection
