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
          <h3 class="card-title">Tambah User</h3>
        </div>
        <form role="form">
          <div class="card-body">
            <div class="form-group">
                <label for="x">Hak akses</label>
                <select id="x" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                  <option value="1">Admin</option>
                  <option value="2">Kadiv</option>
                  <option value="3">User</option>
                </select>
              </div>
            <div class="form-group">
              <label for="exampleInputEmail1">NIP</label>
              <input type="text" class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="text" class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Nama</label>
              <input type="text" class="form-control" placeholder="">
            </div>
            <div class="form-group">
                <label for="x">Unit Kerja</label>
                <select id="x" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                  <option value="#">#</option>
                  <option value="#">#</option>
                  <option value="#">#</option>
                </select>
              </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Phone</label>
              <input type="text" class="form-control" placeholder="">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Alamat KTP</label>
              <input type="text" class="form-control" placeholder="">
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
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
  @admin
  <script>
    $(function () {

    });
  </script>
  @endadmin
@endsection
