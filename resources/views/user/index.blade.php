@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Daftar Pegawai
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
          <h3 class="card-title">Daftar Pegawai</h3>
        </div>
        <div class="card-body table-responsive table-sm">
          <table id="report" class="table table-bordered table-striped">
            <thead class="text-center">
            <tr>
              <th>Role</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Jabatan</th>
              <th>Divisi</th>
              <th>Phone</th>
              <th>Alamat</th>
              <th><i class="fas fa-trash-alt"></i></th>
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
                <a href="{{ route('user.edit', $item->id) }}"><i class="fas fa-edit"></i>{{ $item->username }}</a>
              </td>
              <td><a href="{{ route('user.show', $item->id) }}">{{ $item->name }}</a></td>
              <td>{{ $item->job }}</td>
              <td>{{ $item->department ? $item->department->department_name : '' }}</td>
              <td>{{ $item->phone }}</td>
              <td>{{ $item->ktpaddress }}</td>
              <td><button class="btn btn-danger btn-block btn-sm" data-toggle="modal" data-target="#modal-sm{{ $item->id }}"><i class="fas fa-trash-alt"></i></button></td>
              </tr>
              <div class="modal fade" id="modal-sm{{ $item->id }}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Kick Pegawai!!</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Yakin {{ $item->name }} mau di Kick??
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Gak Jadi</button>
                      <a class="btn btn-danger" href="{{ route('user.destroy', $item->id) }}">Iya</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          <a target="_blank" href="{{ route('user.export') }}"><button type="submit" class="btn btn-danger">Export</button></a>
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
