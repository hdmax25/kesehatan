@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Daftar User
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Daftar User
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
          <h3 class="card-title">Daftar User</h3>
        </div>
        <div class="card-body table-responsive">
          <table id="report" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Role</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Divisi</th>
              <th>Phone</th>
              <th>Alamat</th>
              <th class="no-print">Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($user as $item)
            <tr>
            @if ($item->role == 1)
              <td>Admin</td>
              @elseif ($item->role == 2)
              <td>Kadiv</td>
              @else
              <td>User</td>
            @endif
              <td>
                <a href="{{ route('user.show', $item->id) }}">{{ $item->username }}</a>
              </td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->department ? $item->department->department_name : '' }}</td>
              <td>{{ $item->phone }}</td>
              <td>{{ $item->ktpaddress }}</td>
              <td class="no-print">
                <a href="{{ route('user.edit', $item->id) }}" type="button" class="btn btn-primary btn-sm btn-block">
                  <i class="fas fa-edit"></i>
                </a>
              </td>
            </tr>
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
