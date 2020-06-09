
@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-danger">
      <div class="card-header">
          <h3 class="card-title">Download Excel</h3>
      </div>
      <form action="{{ route('findSDM') }}" method="post">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-{{ Auth::user()->role == 1 ? '6' : '12' }}">
                <div class="form-group">
                  <label for="reservation">Tanggal</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" name="date" id="reservation">
                  </div>
                </div>
              </div>
            @admin
              <div class="col-md-6">
                <div class="form-group">
                  <label for="department">Department</label>
                  <select id="department" name="department" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                    @foreach($department as $item)
                      <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            @endadmin
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-danger">Find</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Data Keshetan</h3>
        </div>
        <div class="card-body">
            <table id="report" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Department</th>
                        <th>Tidak Mengisi</th>
                        <th>Sakit</th>
                </thead>
                <tbody>
                @foreach($report as $item)
                    <tr>
                    <td>{{ $item->user->username }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->department->department_name }}</td>
                    <td>2</td>
                    <td>1</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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

  <script>
    $(function () {
      //Date range picker
      $('#reservation').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        }
      });

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
      $('.select2').select2({width: 'resolve'});
      
    });
  </script>
@endsection