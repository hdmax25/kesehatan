@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>
        Request List
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            Request List
          </a>
        </li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-3">
      <a href="#pending">
        <div class="info-box">
          <span class="info-box-icon bg-primary"><i class="fa fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pending</span>
            <span class="info-box-number">{{ $pendingCount }}</span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="#approved">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fa fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Approved</span>
            <span class="info-box-number">{{ $approvedCount }}</span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="{{ route('leave.canceled') }}">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fa fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Canceled</span>
            <span
                class="info-box-number">{{ $canceledCount }}</span>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-3">
      <a href="{{ route('leave.expired') }}">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fa fa-envelope"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Expired</span>
            <span class="info-box-number">{{ $expiredCount }}</span>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="row">
    @if($pendingCount)
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Pending</h3>
          </div>
          <div class="card-body table-responsive table-sm">
            <table id="pending" class="table table-bordered table-striped table-sm">
              <thead class="text-center">
                  <tr>
                      <th>Izin</th>
                      <th>Action</th>
                      @if (Auth::user()->role == 1)
                          <th>Divisi</th>
                      @endif
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>Tanggal</th>
                      <th>Jam</th>
                      <th>Tujuan</th>
                      <th>Keterangan</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($pending as $item)
                      <tr>
                          @if ($item->type == 0)
                              <td>Dinas</td>
                              @else
                              <td>Pribadi</td>
                          @endif
                            <td class="text-center">
                              {{-- <a class="btn btn-success btn-sm btn-block" href="https://api.whatsapp.com/send?phone={{ $approval->phone }}&text=Mohon%20segera%20approve%20permintaan%20izin%20saya.%20Terimakasih%0A{{ route('leave.index') }}&source=&data=&app_absent=" type="button" target="_blank">
                                <i class="fab fa-whatsapp"></i>
                              </a> --}}
                              <a href="{{ route('leave.edit', $item->id) }}" type="button" class="btn btn-primary btn-sm btn-block">
                                <i class="fas fa-edit"></i>
                              </a>
                              @if (Auth::user()->role !== 3)
                              <a href="#" class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#modal-sm{{ $item->id }}-approve">
                                <i class="fas fa-check"></i>
                              </a>
                              <a href="#" class="btn btn-danger btn-sm btn-block" data-toggle="modal" data-target="#modal-sm{{ $item->id }}-cancel">
                                <i class="fas fa-times"></i>
                              </a>
                              <div class="modal fade" id="modal-sm{{ $item->id }}-approve">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Approve</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          Approve ?
                                        </div>
                                      </div>
                                      <div class="modal-footer justify-content-between">
                                        <a href="{{ route('leave.approve', $item->id) }}"><button type="submit" class="btn btn-success">Yes</button></a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal fade" id="modal-sm{{ $item->id }}-cancel">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Cancel</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                    </div>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          Cancel ?
                                        </div>
                                      </div>
                                      <div class="modal-footer justify-content-between">
                                        <a href="{{ route('leave.cancel', $item->id) }}"><button type="submit" class="btn btn-success">Yes</button></a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                      </div>
                                  </div>
                                </div>
                              </div>
                              @endif
                            </td>
                          @if (Auth::user()->role == 1)
                              <td>{{ $item->department->department_name }}</td>
                          @endif
                          <td>{{ $item->user->username }}</td>
                          <td>{{ $item->user->name }}</td>
                          <td>{{ $item->date }}</td>
                          <td>{{ $item->start }} - {{ $item->end !== '23:59' ? $item->end : 'Selesai' }}</td>
                          <td>{{$item->destination}}</td>
                          <td>{{$item->detail}}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    @endif
    <div class="col-md-12">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Approved</h3>
        </div>
        <div class="card-body table-responsive table-sm">
          <table id="approved" class="table table-bordered table-striped table-sm">
            <thead class="text-center">
                <tr>
                    <th>Izin</th>
                    <th>View</th>
                    @if (Auth::user()->role == 1)
                        <th>Divisi</th>
                    @endif
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Tujuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved as $item)
                    <tr>
                        @if ($item->type == 0)
                            <td>Dinas</td>
                            @else
                            <td>Pribadi</td>
                        @endif
                        <td class="text-center">
                          <a href="{{ route('leave.show', $item->id) }}" type="button" class="btn btn-success btn-block btn-sm">
                              <i class="fas fa-eye"></i>
                          </a>
                        </td>
                        @if (Auth::user()->role == 1)
                            <td>{{ $item->department->department_name }}</td>
                        @endif
                        <td>{{ $item->user->username }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->start.' - '.$item->end }}</td>
                        <td>{{$item->destination}}</td>
                        <td>{{$item->detail}}</td>
                    </tr>
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
      $('#pending').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
      $('#approved').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });

    @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
    @endif

    @if (\Session::has('message1'))
      toastr.error('{{ \Session::get('message1') }}')
    @endif
  </script>

@endsection
