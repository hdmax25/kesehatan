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
            <li class="list-group-item">
              <b>Phone</b> <a class="float-right">{{ $user->phone }}</a>
            </li>
            <li class="list-group-item">
              <b>Jam</b> <a class="float-right" id="clock"></a>
            </li>
          </ul>
          @if (!$todayCheck)
            <button type="submit" class="btn btn-danger btn-block" data-toggle="modal" data-target="#masuk"><b>Masuk</b></button></a>
            <div class="modal fade" id="masuk">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Masuk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      Pastikan posisi anda di Kantor/Workshop
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
                    <form action="{{ route('absent.store') }}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-danger btn-block"><b>Ya</b></button></a>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @else
            @if ($absentToday->attend == 0)
              <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#pulang"><b>Pulang</b></a>
              <div class="modal fade" id="pulang">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Pulang</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Lelah usai kerja, bersukurlah. Karena diluar sana banyak yang lelah mencari kerja</p>
                      <p>Selamat pulang Kak, Hati2 dijalan!!</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Gak Jadi</button>
                      <a href="{{ route('absent.update', $absentToday->id) }}" class="btn btn-warning">Iya</a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">Absensi</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-sm text-center">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Keluar</th>
              </tr>
            </thead>
            <tbody>
              @foreach($absent as $item)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}</td>
                  @if ($item->attend == 1)
                  <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}</td>
                  @endif
                </tr>
              @endforeach
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