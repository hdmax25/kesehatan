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
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Masukan Unit Kerja</h3>
        </div>
        <form action="{{ route('department.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Unit Kerja Divisi/Department</label>
              <input type="text" class="form-control @error('department_name') is-invalid @enderror" placeholder="Department" name="department_name" value="{{ old('department_name') }}">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Daftar Kondisi</h3>
        </div>
        <div class="card-body table-responsive">
          <table id="report" class="table table-bordered table-striped text-center">
            <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Department</th>
              <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($department as $item)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->department_name }}</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-sm{{ $item->department_name }}">
                    Launch Small Modal
                  </button>
                </td>
              </tr>
              <div class="modal fade" id="modal-sm{{ $item->department_name }}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Department</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{ route('department.update', $item->id) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Unit Kerja Divisi/Department</label>
                          <input type="text" class="form-control" placeholder="Department" name="department_name" value="{{ $item->department_name }}">
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
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

  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

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

      //Initialize Select2 Elements
      $('.select2').select2()

      @error('department_name')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
@endsection
