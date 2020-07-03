@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Buat User
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Buat User
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
          <h3 class="card-title">Tambah User</h3>
        </div>
        <form action="{{ route('user.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="role">Hak akses</label>
              <select id="role" name="role" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                <option value="3" {{ old('role') == 3 ? 'selected' : '' }}>User</option>
                <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Kadiv</option>
                <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Admin</option>
              </select>
            </div>
            <div class="form-group">
              <label for="username">NIP</label>
              <input type="number" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="" value="{{ old('username') }}">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="" value="{{ old('password') }}">
            </div>
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="" style="text-transform:uppercase" value="{{ old('name') }}">
            </div>
            <div class="form-group">
              <label for="department">Divisi</label>
              <select id="department" name="department" class="form-control @error('department') is-invalid @enderror select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                @foreach($department as $item)
                  <option value="{{ $item->id }}" {{ old('role') == $item->id ? 'selected' : '' }}>{{ $item->department_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="department">Jabatan</label>
              <select id="department" name="job" class="form-control @error('job') is-invalid @enderror select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                <option value="SEMENTARA" {{ old('job') == 'SEMENTARA' ? 'selected' : '' }}>SEMENTARA</option>
                <option value="DIREKSI" {{ old('job') == 'DIREKSI' ? 'selected' : '' }}>DIREKSI</option>
                <option value="KADIV" {{ old('job') == 'KADIV' ? 'selected' : '' }}>KADIV</option>
                <option value="KADEP" {{ old('job') == 'KADEP' ? 'selected' : '' }}>KADEP</option>
                <option value="KABAG" {{ old('job') == 'KABAG' ? 'selected' : '' }}>KABAG</option>
                <option value="KASUBAG" {{ old('job') == 'KASUBAG' ? 'selected' : '' }}>KASUBAG</option>
                <option value="STAFF" {{ old('job') == 'STAFF' ? 'selected' : '' }}>STAFF</option>
                <option value="OPERATOR" {{ old('job') == 'OPERATOR' ? 'selected' : '' }}>OPERATOR</option>
              </select>
            </div>
            <div class="form-group">
              <label for="phone">Phone</label>
              <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="" value="{{ old('phone') }}">
            </div>
            <div class="form-group">
              <label for="address">Alamat KTP</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="" style="text-transform:uppercase" name="address" id="address" value="{{ old('address') }}">
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

      @error('username')
      toastr.warning('{{ str_replace('username', 'NIP', $message) }}')
      @enderror

      @error('password')
      toastr.warning('{{ $message }}')
      @enderror

      @error('name')
      toastr.warning('{{ $message }}')
      @enderror

      @error('department')
      toastr.warning('{{ $message }}')
      @enderror

      @error('job')
      toastr.warning('{{ $message }}')
      @enderror

      @error('phone')
      toastr.warning('{{ $message }}')
      @enderror

      @error('address')
      toastr.warning('{{ $message }}')
      @enderror

      @error('role')
      toastr.warning('{{ $message }}')
      @enderror

      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif

    });
  </script>
@endsection
