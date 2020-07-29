@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Kondisi
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Kondisi
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
          <h3 class="card-title">Masukan Kondisi</h3>
        </div>
        <form action="{{ route('penyakit.store') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Kondisi</label>
              <input type="text" class="form-control @error('penyakit_name') is-invalid @enderror" id="penyakit_name" name="penyakit_name" placeholder="Kondisi">
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
              <th style="width: 10px">id</th>
              <th>Kondisi</th>
              <th class="text-center">Action</th>
              <!--  <th>Delete</th> -->
            </tr>
            </thead>
            <tbody>
            @foreach($disease as $item)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item->penyakit_name }}</td>
                <td class="text-center">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-sm{{ $item->id }}">
                  <i class="fas fa-edit"></i>
                  </button>
                  <a href="{{ route('penyakit.destroy', $item->id) }}">
                    <button type="button" class="btn btn-danger btn-sm">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </a>
                </td>
              </tr>
              <div class="modal fade" id="modal-sm{{ $item->id }}">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Kondisi</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <form action="{{ route('penyakit.update', $item->id) }}" method="post">
                      @csrf
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Kondisi</label>
                          <input type="text" class="form-control @error('penyakit_name') is-invalid @enderror" placeholder="Penyakit" name="penyakit_name" value="{{ $item->penyakit_name }}">
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

      @error('penyakit_name')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
@endsection
