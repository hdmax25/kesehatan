@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Laporan
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Laporan
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
          <h3 class="card-title">Setting Tanggal</h3>
        </div>
        <form action="{{ Auth::user()->role == 1 ? route('report.findSDM') : route('report.findDevise') }}" method="POST">
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
                    <input type="text" class="form-control float-right" name="date" id="reservation" value="{{ old('date') ? old('date') : ($dateStart .' - '. $dateEnd) }}">
                  </div>
                </div>
              </div>
              @admin
              <div class="col-md-6">
                <div class="form-group">
                  <label for="department">Divisi</label>
                  <select id="department" name="department" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                    <option value="0" {{ $setDepartment == 'x' ? 'selected' :'' }}>All</option>
                    @foreach($department as $item)
                      <option value="{{ $item->id }}" {{ $setDepartment == $item->id ? 'selected' :'' }}>{{ $item->department_name }}</option>
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
          <h3 class="card-title">Data Kesehatan</h3>
        </div>
        <div class="card-body">
          <table id="report" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>NIP</th>
              <th>Nama</th>
              <th>Divisi</th>
              <th>Tidak Mengisi</th>
              <th>Sakit</th>
              <th>View</th>
            </thead>
            <tbody>
            @foreach($report as $item)
              <tr>
                <td>{{ $item->user->username }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->department->department_name }}</td>
                <td>{{ $item->absent + 1}}</td>
                <td>{{ $item->sick }}</td>
                <td>
                  <a href="{{ route('user.show', $item->user->id) }}" type="button" class="btn btn-primary btn-sm btn-block">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
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

        <!-- Toastr -->
        <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

        <script>
          $(function () {
            //Date range picker
            $('#reservation').daterangepicker({
              todayHighlight: true,
              locale: {
                format: 'DD-MM-YYYY'
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

            @error('date')
            toastr.warning('{{ $message }}')
            @enderror

            @error('department')
            toastr.warning('{{ $message }}')
            @enderror

          });
        </script>
@endsection