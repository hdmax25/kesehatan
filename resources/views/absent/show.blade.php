@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Presence
      </h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div id="warning" class="alert alert-warning alert-dismissible d-none">
        <h5><i class="icon fas fa-info"></i> Perhatian</h5>
        <span id="xx"></span>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" id="infoLocations" href="#"data-toggle="modal" data-target="#info"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="refresh" onclick="getLocation()" href="#"></a>
          </li>
      </div>
      <div class="modal fade" id="info">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Daftar Lokasi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body p-0">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>Posisi</th>
                    <th>Koordinat</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sites as $item)
                    <tr>
                      <td>{{ $item->name }}</td>
                      <td><a href="{{ url('https://www.google.com/maps/@'.$item->latitude.','.$item->longitude.',19z')}}" target="_blank">{{ $item->latitude.','.$item->longitude}}</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button onclick="getLocation()" type="button" class="btn btn-success" data-dismiss="modal">Refresh</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card card-danger card-outline">
        <div class="card-body box-profile">
          <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

          <p class="text-muted text-center">{{ Auth::user()->job }} {{ $user->department->department_name }}</p>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>NIP</b> <a class="float-right">{{ Auth::user()->username }}</a>
            </li>
            <li class="list-group-item">
              <b>Date</b> <a class="float-right">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</a>
            </li>
            <li class="list-group-item">
              <b>Time</b> <a class="float-right" id="clock"></a>
            </li>
            <li class="list-group-item">
              <b>Location</b> <a class="float-right" id="loc"><i class="fas fa-sync-alt fa-spin"></i></a>
            </li>
          </ul>
          <a href="#" id="show" class="btn btn-danger btn-block d-none" data-toggle="modal" data-target="#confirm"><b>{{ $attCount%2 == 0 ? 'IN' : 'OUT' }}</b></button></a>
            <div class="modal fade" id="confirm">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Konfirmasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                  </div>
                  <form action="{{ route('TblAttendanceLog.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                      @if($attCount%2 == 0)
                        Selamat bekerja Kak..
                        <br>Semoga harimu menyenangkan
                      @else
                        Lelah usai kerja, bersyukurlah. Karena diluar sana banyak yang lelah mencari kerja
                        <br>Selamat pulang, Hati2 dijalan!!
                      @endif
                      <span class="d-none">
                        <input id="site" name="location">
                        <input id="ipAddress" name="ipAddress">
                      </span>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button id="btnInOut" onclick="hideBtn()" type="submit" class="btn btn-success">Ya</button>
                      <span id="btnLoading" class="btn btn-success d-none"><i class="fas fa-sync-alt fa-spin"></i></span>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
        <div id="loading" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">Attendance log</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-sm table-nowarp">
            <thead>
              <tr>
                {{-- <th>Log</th> --}}
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $attLog as $item)
                <tr>
                  {{-- <td>{{ ($loop->index + $attCount) %2 == 0 ? 'OUT' : 'IN' }}</td> --}}
                  <td>{{ \Carbon\Carbon::parse($item->CreateDt)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->CreateDt)->format('H:i') }}</td>
                  <td>{{ $item->Machine }}<td>
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

  <!-- IP Detect -->
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 

  <script>
    // Run Away
    $(function() {
      startTime();
      getLocation();
    });

    //Live Clock
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

    //Hide Button
    function hideBtn() {
      document.getElementById("btnInOut").classList.add("d-none");
      document.getElementById("btnLoading").classList.remove("d-none");
    }

    // Find Location
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else { 
        xx.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      var x = position.coords.latitude.toFixed(3);
      var y = position.coords.longitude.toFixed(3);
      @foreach($sites as $item) {{ $item->id == $firstSite ? 'if' : 'else if'}} (x == {{ $item->latitude }} && y == {{ $item->longitude }}) {
          document.getElementById("warning").classList.add("d-none");
          loc.innerHTML = "{{ $item->name }}";
          document.getElementById("show").classList.remove("d-none");
          document.getElementById("site").value = "{{ $item->name }}";
          document.getElementById("loading").classList.add("d-none");
        } @endforeach else {
        xx.innerHTML = "Posisi anda tidak pada lokasi yang ditentukan <br>Posisi saat ini : " + x + ", " + y;
        infoLocations.innerHTML = "Daftar Lokasi";
        toastr.warning('Posisi belum tepat');
        refresh.innerHTML = "Perbarui Lokasi";
        document.getElementById("warning").classList.remove("d-none");
        document.getElementById("loading").classList.add("d-none");
      }
    }

    function showError(error) {
    switch(error.code) {
    case error.PERMISSION_DENIED:
      document.getElementById("warning").classList.remove("d-none"),
      xx.innerHTML = "Anda tidak bisa absen karena tidak mengizikan akses lokasi."
      break;
    case error.POSITION_UNAVAILABLE:
      document.getElementById("warning").classList.remove("d-none"),
      xx.innerHTML = "Informasi lokasi tidak tersedia."
      break;
    case error.TIMEOUT:
    document.getElementById("warning").classList.remove("d-none"),
      xx.innerHTML = "The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      document.getElementById("warning").classList.remove("d-none"),
      xx.innerHTML = "An unknown error occurred."
      break;
      }
    }

    $.getJSON("https://api.ipify.org?format=json", function(data) {
            $("#ipAddress").val(data.ip); 
    });

    $(function () {

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif
    });
  </script>
@endsection
