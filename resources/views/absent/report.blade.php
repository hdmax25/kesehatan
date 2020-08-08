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
          <h3 class="card-title">Report</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover table-sm table-nowarp">
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
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
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
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection

@section('js')
  <!-- bs-custom-file-input -->
  <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

  <!-- IP Detect -->
  <script src= "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 

@endsection
