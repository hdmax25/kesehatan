@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Leave Request
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
  <div class="row">
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Leave Request</h3>
        </div>
        <form action="{{ route('leave.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="department">Izin</label>
              <select id="type" name="type" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                <option value="0" {{ old('type') == 0 ? 'selected' : '' }}>Dinas</option>
                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Pribadi</option>
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Tanggal</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" name="date" id="date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ old('date') }}">
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Jam</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" name="time" class="form-control float-right @error('time') is-invalid @enderror" id="time" value="{{ old('time') ? old('time') : \Carbon\Carbon::now()->format('H:00').' - '.\Carbon\Carbon::now()->addhours(4)->format('H:00') }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Tujuan</label>
              <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination" name="destination" placeholder="Tujuan" value="{{ old('destination') }}">
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <textarea class="form-control @error('detail') is-invalid @enderror" rows="3" id="detail" name="detail" placeholder="Tulis Keterangan">{{ old('detail') }}</textarea>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
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
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      @error('date')
      toastr.warning('{{ $message }}')
      @enderror

      @error('destination')
      toastr.warning('{{ $message }}')
      @enderror

      @error('detail')
      toastr.warning('{{ $message }}')
      @enderror

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif
    });
  </script>

  <script>
      $('#reservationdate').datetimepicker({
          format: 'DD/MM/YYYY'
      });
      $('#time').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        locale: {
          format: 'HH:mm'
        }
      }).on('show.daterangepicker', function (ev, picker) {
        picker.container.find(".calendar-table").hide();
      });

      //Initialize Select2 Elements
      $('.select2').select2();
  </script>
@endsection