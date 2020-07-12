@extends('layouts.app')

@section('title')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Data Kesehatan - PT INKA Multi Solusi
      </h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
          <a href="#">
            {{ \Carbon\Carbon::now()->format('l, d F Y') }}
          </a>
        </li>
      </ol>
    </div>
  </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered text-center">
        <thead>
          <tr class="table-primary">
            <th colspan="5">Data Kesehatan - PT INKA Multi Solusi</th>
          </tr>
          <tr>
            <th style="width: 20%;">Pegawai</th>
            <th style="width: 20%;">Sudah Lapor</th>
            <th style="width: 20%;">Tidak Lapor</th>
            <th style="width: 20%;">Sehat</th>
            <th style="width: 20%;">Sakit</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td>{{ $belum->count() + $sudah->count() }}</td>
              <td>{{ $sudah->count() }}</td>
              <td>{{ $belum->count() }}</td>
              <td>{{ $sehat }}</td>
              <td>{{ $sakit }}</td>
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="text-center">
          <tr class="table-primary">
            <th colspan="5">Laporan Divisi</th>
          </tr>
          <tr>
            <th>Divisi</th>
            <th>Jumlah</th>
            <th>Lapor</th>
            <th>Tidak Lapor</th>
            {{-- <th>% Lapor</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($groupDepartment as $item)
            <tr>
              <td>{{$item->departmentName}}</td>
              <td class="text-right">{{ $item->totalUser }}</td>
              <td class="text-right">{{ $item->absens }}</td>
              <td class="text-right">{{ $item->totalUser-$item->absens }}</td>
              {{-- <td class="text-right">{{ $item->absens ? round($item->absens / $item->totalUser * 100 ,1) }}%</td> --}}
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="text-center">
          <tr class="table-success">
            <th colspan="4">Kesehatan Divisi</th>
          </tr>
          <tr>
            <th>Divisi</th>
            <th>Sehat</th>
            <th>Sakit</th>
            {{-- <th>Kesehatan</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($groupDepartment as $item)
            <tr>
              <td>{{$item->departmentName}}</td>
              <td class="text-right">{{ $item->sehat }}</td>
              <td class="text-right">{{ $item->sakit }}</td>
              {{-- <td class="text-right">{{ round($item->sehat/($item->sehat+$item->sakit)*100,1) }}%</td> --}}
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="text-center">
          <tr class="table-warning">
            <th colspan="6">Pegawai Sakit</th>
          </tr>
          <tr>
            <th>Jam</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Divisi</th>
            <th>Kondisi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sudah as $item)
            @if($item->absenes->id_penyakit != 1)
              <tr>
                <td>{{ \Carbon\Carbon::parse($item->absenes->created_at)->format('H:i') }}</td>
                <td>{{ $item->username }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->job ? $item->job : "SEMENTARA" }}</td>
                <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                <td>{{ $item->disease->penyakit_name }}</td>
              </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered">
        <thead class="text-center">
          <tr class="table-warning">
            <th colspan="2">Keluhan</th>
          </tr>
          <tr>
            <th>Keluhan</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataSakit as $id => $item)
            <tr>
              <td>{{ $id }}</td>
              <td class="text-right">{{ $item }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-12 table-responsive">
      <table class="table table-striped table-sm table-bordered" style="width: 100%!important;">
        <thead class="text-center">
          <tr class="table-danger">
            <th colspan="4">Pegawai Tidak Lapor</th>
          </tr>
          <tr>
            <th>Divisi</th>
            <th>Jabatan</th>
            <th>NIP</th>
            <th>Nama Pegawai</th>
          </tr>
        </thead>
        <tbody>
          @foreach($belum as $item)
            <tr>
              <td>{{ $item->department ? $item->department->department_name : '' }}</td>
              <td>{{ $item->job ? $item->job : "SEMENTARA" }}</td>
              <td>{{ $item->username }}</td>
              <td>{{ $item->name }}</td>
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

  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

  <script>
    $(function () {
      //Date range picker
      $('#reservation').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        }
      });

      $('#sudahSehat').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      $('#sudahSakit').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      $('#belumT').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": true,
      });

      $('#reportdep').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": true,
      });

      $('#kesehatan').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true,
        "responsive": true,
      });

      $('#keluhan').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });
    });
  </script>
  <script type="text/javascript"> 
    window.addEventListener("load", window.print());
  </script> 

@endsection
