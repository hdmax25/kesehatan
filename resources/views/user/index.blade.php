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
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Daftar User</h3>
        </div>
        <div class="card-body table-responsive">
          <table id="report" class="table table-bordered table-striped text-center">
            <thead>
            <tr>
              <th>Hak Akses</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Department</th>
              <th>Phone</th>
              <th>Alamat</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Action</button>
                  <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                    <div class="dropdown-menu" role="menu" style="">
                      <a class="dropdown-item" href="#">Edit</a>
                      <a class="dropdown-item" href="#">Delete</a>
                    </div>
                  </button>
                </div>
              </td>
            </tr>
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

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
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

  <script>
    $(function () {
      //Date range picker
      $('#reservation').daterangepicker();

      $('#report').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      //Initialize Select2 Elements
      $('.select2').select2();
    });
  </script>
@endsection
