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
                <th>NIP</th>
                <th>Nama</th>
                <th>Jam</th>
                <th>Log</th>
              </tr>
            </thead>
            <tbody>
              @foreach( $absent as $item)
                <tr>
                  <td>{{ $item->EmpCode }}</td>
                  <td>{{ $item->user->name }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->CreateDt)->format('H:i') }}</td>
                  <td>{{ $item->CreateBy }}</td>
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
