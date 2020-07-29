@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Site
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Site
          </a>
        </li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Masukan Site</h3>
        </div>
        <form action="{{ route('site.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Site Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Site" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Address</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" value="{{ old('address') }}">
            </div>
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" placeholder="Latitude" value="{{ old('latitude') }}">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="form-group">
                  <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <button type="button" class="btn btn-danger btn-block" onclick="getLocation()"><i class="nav-icon fa fa-map-marker"></i> Get Location</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer justify-content-between">
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Site List</h3>
        </div>
        <div class="card-body table-responsive table-sm">
          <table id="report" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width: 10px">ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Location</th>
              <th class="text-center">Edit</th>
            </thead>
            <tbody>
            @foreach($sites as $item)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->address }}</td>
                <td><a href="{{ url('https://www.google.com/maps/@'.$item->latitude.','.$item->longitude.',20z')}}" target="_blank">{{ $item->latitude.','.$item->longitude}}</a></td>
                <td class="text-center">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-l{{ $item->id }}">
                  <i class="fas fa-edit"></i>
                  </button>
                  <a href="{{ route('site.destroy', $item->id) }}">
                    <button type="button" class="btn btn-danger btn-sm">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </a>
                </td>
              </tr>
              <div class="modal fade" id="modal-l{{ $item->id }}">
                <div class="modal-dialog modal-l">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Kondisi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{ route('site.update', $item->id) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Site</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ $item->name }}">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Address</label>
                          <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Address" name="address" value="{{ $item->address }}">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Longitude</label>
                          <input type="text" class="form-control @error('laditude') is-invalid @enderror" placeholder="Latitude" name="latitude" value="{{ $item->latitude }}">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Latitude</label>
                          <input type="text" class="form-control @error('longitude') is-invalid @enderror" placeholder="Longitude" name="longitude" value="{{ $item->longitude }}">
                        </div>
                        <div class="form-group">
                          <button type="button" class="btn btn-danger btn-block" onclick="getLocation()"><i class="nav-icon fa fa-map-marker"></i> Get Location</button>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('js')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

  <script>
    $(function () {
      $('#report').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      @error('name')
      toastr.warning('{{ $message }}')
      @enderror

      @error('address')
      toastr.warning('{{ $message }}')
      @enderror

      @error('latitude')
      toastr.warning('{{ $message }}')
      @enderror

      @error('longitude')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
  <script>
    var x = document.getElementById("latitude");
    var y = document.getElementById("longitude");
    
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }
    
    function showPosition(position) {
      x.value = position.coords.latitude.toFixed(3),
      y.value = position.coords.longitude.toFixed(3);
    }
    </script>
@endsection
