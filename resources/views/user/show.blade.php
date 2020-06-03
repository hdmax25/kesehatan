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

          <ul class="nav flex-column">
            <li class="nav-item">
              <div class="nav-link">
                NIP <span class="float-right">{{ $user->username }}</span>
              </div>
            </li>
            <li class="nav-item">
              <div class="nav-link">
                Phone <span class="float-right">{{ $user->phone }}</span>
              </div>
            </li>
            <li class="nav-item">
              <div class="nav-link">
                Alamat <span class="float-right">{{ $user->ktpaddress }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">History</a></li>
            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active" id="timeline">
              <div class="timeline timeline-inverse">
                <div class="time-label">
                  <span class="bg-success">
                    10 Februari 2020
                  </span>
                </div>
                <div>
                  <i class="fas fa-heartbeat bg-success"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="far fa-clock"></i> 12:05</span>

                    <h3 class="timeline-header">Penyakit - di Posisi</h3>

                    <div class="timeline-body">
                      Keluhan
                    </div>
                    <div class="timeline-footer">
                    </div>
                  </div>
                </div>
                <div>
                  <i class="far fa-clock bg-gray"></i>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="settings">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputName" placeholder="Nama">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Pasword</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="Password" placeholder="Name">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputExperience" class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="inputExperience" placeholder="Alamat">KTP ADDRESS</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="offset-sm-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Data sudah benar
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
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('js')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

  <!-- daterange picker -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@endsection
