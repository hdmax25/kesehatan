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
    <div class="col-md-12">
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Beta Testing!</h5>
        Menu ini masih dalam tahap beta testing, silakan dicoba dulu!
      </div>
    </div>
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
            @if ($checkToday < 3)
              @if ($check == 0 || $check % 2 == 0)
                <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#masuk"><b>Masuk</b></button></a>
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
                        <form action="{{ route('absent.store') }}" method="post">
                          @csrf
                          <button type="submit" class="btn btn-success btn-block"><b>Ya</b></button></a>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                      </div>
                    </div>
                  </div>
                </div>
              @else
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
                        <a href="{{ route('absent.update') }}" class="btn btn-success">Ya</a>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button>
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
          <h3 class="card-title">Attendance log</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap table-sm text-center">
            <thead>
              <tr>
                <th>#<th>
                <th>Log</th>
                <th>Date and Time</th>
              </tr>
            </thead>
            <tbody>
              @foreach($absent as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}<td>
                  <td>{{ $item->attend == 0 ? 'In' : 'Out' }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
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
