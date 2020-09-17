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
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">Absent</h3>
        </div>
        <div class="card-body table-responsive table-sm">
          <table id="report" class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jam</th>
                <th>Log</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $absent as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $item->EmpCode }}</td>
                  <td>{{ $item->user ? $item->user->name : '' }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->CreateDt)->format('H:i') }}</td>
                  <td>{{ $item->City }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Presence</span>
          <span class="info-box-number">{{ $absent->count() }} / {{ $user }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-6 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Absent</span>
          <span class="info-box-number">{{  $user - $absent->count()  }} / {{ $user }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
@endsection

@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('js')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <script>
    $(function () {
      $('#report').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>

@endsection
