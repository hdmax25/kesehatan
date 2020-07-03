@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Absent
      </h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <div class="card card-danger card-outline">
        <div class="card-body box-profile">
          <h3 class="profile-username text-center">{{ $user->name }}</h3>

          <p class="text-muted text-center">{{ $user->job }} {{ $user->department->department_name}}</p>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>NIP</b> <a class="float-right">{{ $user->username }}</a>
            </li>
            <!-- <li class="list-group-item">
              <b>Nama</b> <a class="float-right">{{ $user->name }}</a>
            </li>
            <li class="list-group-item">
              <b>Jabatan</b> <a class="float-right">{{ $user->job }}</a>
            </li>
            <li class="list-group-item">
              <b>Divisi</b> <a class="float-right">{{ $user->department->department_name}}</a>
            </li> -->
            <li class="list-group-item">
              <b>Phone</b> <a class="float-right">{{ $user->phone }}</a>
            </li>
            <li class="list-group-item">
              <b>Jam</b> <a class="float-right" id="clock"></a>
            </li>
          </ul>
          <a href="#" class="btn btn-danger btn-block"><b>Masuk</b></a>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">Absensi</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-sm">
            <thead class="text-center">

              <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td>#</td>
                  <td>#</td>
                  <td>#</td>
                </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
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
    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('clock').innerHTML =
      h + ":" + m + ":" + s;
      var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }
    </script>
@endsection
