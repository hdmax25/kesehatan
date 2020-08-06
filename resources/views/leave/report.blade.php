@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
       Leave request report
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Leave Request
          </a>
        </li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
<form action="{{ route('leave.find') }}" method="post">
  <div class="row">
      @csrf
      <div class="col-md-10">
        <div class="form-group">
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $date }}" onkeydown="return false">
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-danger btn-block">Find</button>
      </div>
  </div>
</form>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered text-center">
        <thead>
          <tr class="table-primary">
            <th colspan="4">Leave Request</th>
          </tr>
          <tr>
            <th style="width: 25%;">Peding</th>
            <th style="width: 25%;">Approved</th>
            <th style="width: 25%;">Canceled</th>
            <th style="width: 25%;">Expired</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>{{ $pendingCount }}</td>
              <td>{{ $approvedCount }}</td>
              <td>{{ $canceledCount }}</td>
              <td>{{ $expiredCount }}</td>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="text-center">
          <tr>
            <th>#</th>
            <th>Izin</th>
            <th>Divisi</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Tujuan</th>
            <th>Keterangan</th>
            <th>Status</th>
          </tr>
          </thead>
          <tbody>
              @foreach($leave as $item)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  @if ($item->type == 0)
                    <td>Dinas</td>
                    @else
                    <td>Pribadi</td>
                  @endif
                  <td>{{ $item->department->department_name }}</td>
                  <td>{{ $item->user->username }}</td>
                  <td>{{ $item->user->name }}</td>
                  <td>{{ $item->date }}</td>
                  <td>{{ $item->start }} - {{ $item->end !== '23:59' ? $item->end : 'Selesai' }}</td>
                  <td>{{ $item->destination }}</td>
                  <td>{{ $item->detail }}</td>
                  @if ($item->type == 0 && $item->date >= \Carbon\Carbon::now()->format('d/m/Y'))
                    <td>Pending</td>
                    @elseif ($item->type == 0 && $item->date < \Carbon\Carbon::now()->format('d/m/Y'))
                    <td>Expired</td>
                    @else
                    <td>Approved</td>
                  @endif
                </tr>
              @endforeach
          </tbody>
        </table>
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

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    
    <!-- daterange picker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
  
    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  

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
    });

    $('#reservationdate').datetimepicker({
          format: 'DD/MM/YYYY',
      });
  </script>

@endsection