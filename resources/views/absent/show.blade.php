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
      <div id="warning" class="alert alert-warning">
        <h5><i class="icon fas fa-info"></i> Perhatian</h5>
          <span id="xx"></span>
          <br><a id="infoLocations" href="#"data-toggle="modal" data-target="#info"></a>
      </div>
      <div class="modal fade" id="info">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Site List</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>#<th>
                    <th>Name</th>
                    <th>Posisi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sites as $item)
                    <tr>
                      <td>{{ $item->id }}<td>
                      <td>{{ $item->name }}</td>
                      <td><a href="{{ url('https://www.google.com/maps/@'.$item->latitude.','.$item->longitude.',19z')}}" target="_blank">{{ $item->latitude.','.$item->longitude}}</a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              Silakan berpindah ke lokasi yang ditentukan, lalu klik refresh
            </div>
            <div class="modal-footer justify-content-between">
              <a href="{{ route('absent.show', Auth::user()->id) }}" class="btn btn-success">Refresh</a>
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
            <li id="locContainer" class="list-group-item">
              <b>Location</b> <a class="float-right" id="loc"></a>
            </li>
          </ul>
            @if ($checkToday < 3)
              @if ($check == 0 || $check % 2 == 0)
                <a href="#" id="show" class="btn btn-danger btn-block" data-toggle="modal" data-target="#masuk"><b>Masuk</b></button></a>
                <div class="modal fade" id="masuk">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Masuk</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <form action="{{ route('absent.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p>Awali setiap pekerjaan dengan Bismillah, semoga setiap tetesan keringatmu menjadi ibadah, dan senantiasa mendapat rezeki yang penuh dengan berkah.</p>
                            <span class="d-none">
                              <input id="site" name="location">
                              <input id="ipaddress" name="ipaddress">
                            </span>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="submit" class="btn btn-success">Aamiin</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              @else
                <a href="#" id="show" class="btn btn-danger btn-block" data-toggle="modal" data-target="#pulang"><b>Pulang</b></a>
                <div class="modal fade" id="pulang">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Pulang</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                      </div>
                      <form action="{{ route('absent.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                          <p>Lelah usai kerja, bersukurlah. Karena diluar sana banyak yang lelah mencari kerja</p>
                          <p>Selamat pulang, Hati2 dijalan!!</p>
                          <span class="d-none">
                            <input id="site" name="location">
                            <input id="ipaddress" name="ipaddress">
                          </span>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="submit" class="btn btn-success">Ya</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                        </div>
                      </form>
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
          <table class="table table-hover table-sm text-center">
            <thead>
              <tr>
                <th>#<th>
                <th>Log</th>
                <th>Date and Time</th>
                <th>Location</th>
              </tr>
            </thead>
            <tbody>
              @foreach($absent as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}<td>
                  <td>{{ $item->attend == 0 ? 'In' : 'Out' }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                  <td>{{ $item->site->name }}<td>
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

  <!-- Jam -->
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
  
  <!-- Cari Lokasi -->
  <script>    
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
      @foreach($sites as $item)
        @if ($item->id == 1)
        if (x == {{ $item->latitude }} && y == {{ $item->longitude }}) {
          document.getElementById("warning").classList.add("d-none"),
          loc.innerHTML = "{{ $item->name }}",
          document.getElementById("site").value = "{{ $item->id }}";
        }
        @else
        else if (x == {{ $item->latitude }} && y == {{ $item->longitude }}) {
          document.getElementById("warning").classList.add("d-none"),
          loc.innerHTML = "{{ $item->name }}",
          document.getElementById("site").value = "{{ $item->id }}";
        }
        @endif
      @endforeach
      else {
        xx.innerHTML = "Posisi anda tidak Di Kantor/Wokshop <br>Posisi saat ini : " + position.coords.latitude.toFixed(3) + ", " + position.coords.longitude.toFixed(3),
        infoLocations.innerHTML = "Klik disini untuk melihat posisi absen",
        document.getElementById("locContainer").classList.add("d-none"),
        document.getElementById("show").classList.add("d-none");
      }
    }

    function showError(error) {
    switch(error.code) {
    case error.PERMISSION_DENIED:
      xx.innerHTML = "Anda tidak bisa absen karena tidak mengizikan akses lokasi."
      break;
    case error.POSITION_UNAVAILABLE:
      xx.innerHTML = "Informasi lokasi tidak tersedia."
      break;
    case error.TIMEOUT:
      xx.innerHTML = "The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      xx.innerHTML = "An unknown error occurred."
      break;
      }
    }

    $.getJSON("https://api.ipify.org?format=json", function(data) {
            $("#ipaddress").val(data.ip); 
    });

    $(function () {

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif
    });
  </script>
@endsection
