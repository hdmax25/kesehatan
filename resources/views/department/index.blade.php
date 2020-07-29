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
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Masukan Unit Kerja</h3>
        </div>
        <form action="{{ route('department.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Unit Kerja Divisi/Divisi</label>
              <input type="text" class="form-control @error('department_name') is-invalid @enderror" placeholder="Divisi" name="department_name" value="{{ old('department_name') }}">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <div class="card-header">
          <h3 class="card-title">Daftar Kondisi</h3>
        </div>
        <div class="card-body table-responsive">
          <table id="report" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>Divisi</th>
              <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($department as $item)
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->department_name }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-sm{{ $item->id }}">
                   <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $item->id }}">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
              <div class="modal fade" id="modal-sm{{ $item->id }}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Divisi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{ route('department.update', $item->id) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Unit Kerja Divisi/Divisi</label>
                          <input type="text" class="form-control" placeholder="Divisi" name="department_name" value="{{ $item->department_name }}">
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
              <div class="modal fade" id="delete{{ $item->id }}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Delete</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      Delete {{ $item->department_name }} ?
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <a href="{{ route('department.destroy', $item->id) }}"><button type="submit" class="btn btn-danger">Delete</button></a>
                    </div>
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

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('js')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

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

      @error('department_name')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
@endsection
