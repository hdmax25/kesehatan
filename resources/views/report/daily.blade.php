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
    <div class="col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Laporan Divisi</h3>
          <div class="card-tools no-print">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed table-bordered table-sm table-striped">
            <thead>
              <tr>
                <th>Divisi</th>
                <th>Jumlah</th>
                <th>Lapor</th>
                <th>Laporan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($groupDepartment as $item)
                <tr>
                  <td>{{$item->departmentName}}</td>
                  <td class="text-right">{{ $item->totalUser }}</td>
                  <td class="text-right">{{ $item->absens }}</td>
                  <td class="text-right">{{ round($item->absens/$item->totalUser*100,1) }}%</td>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Kesehatan Divisi</h3>
          <div class="card-tools no-print">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed table-bordered table-sm table-striped">
            <thead>
              <tr>
                <th>Divisi</th>
                <th>Sehat</th>
                <th>Sakit</th>
                <th>Kesehatan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($dataDepartment as $item)
                <tr>
                  <td>{{$item->departmentName}}</td>
                  <td class="text-right">{{ $item->sehat }}</td>
                  <td class="text-right">{{ $item->sakit }}</td>
                  <td class="text-right">{{ round($item->sehat/($item->sehat+$item->sakit)*100,1) }}%</td>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Keluhan</h3>
          <div class="card-tools no-print">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed table-bordered table-sm table-striped">
            <thead>
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
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Pegawai Sakit</h3>
          <div class="card-tools no-print">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed table-bordered table-sm table-striped">
            <thead>
              <tr>
                <th>Jam</th>
                <th>NIP</th>
                <th>Nama</th>
                @admin
                <th>Divisi</th>
                @endadmin
                <th>Kondisi</th>
                <th>View</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sudah as $item)
                @if($item->absenes->id_penyakit != 1)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($item->absenes->created_at)->format('H:i') }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->name }}</td>
                    @admin
                    <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                    @endadmin
                    <td>{{ $item->disease->penyakit_name }}</td>
                    <td>
                      <a href="{{ route('user.show', $item->id) }}" type="button" class="btn btn-primary btn-xs btn-block">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <div class="col-12">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Pegawai Tidak Lapor</h3>
          <div class="card-tools no-print">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-head-fixed table-bordered table-sm table-striped">
            <thead>
              <tr>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Divisi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($belum as $item)
                <tr>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
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

  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

  <script>
    @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse("13:00:00"))
    $(function () {
      let remaining = new Date();
      let target = "23";
      if (remaining.getHours() > target) {
        let view = document.getElementById("checkedToday");
        view.innerHTML = '';
      }

      setInterval(function () {
        let remaining = new Date();
        let target = "23";
        if (remaining.getHours() > target) {
          let view = document.getElementById("checkedToday");
          view.innerHTML = "";
        }
      }, 1000);
    })
    @endif

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
        "ordering": false,
        "info": true,
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

      //Initialize Select2 Elements
      $('.select2').select2({width: 'resolve'});


      @if (\Session::has('message'))
      toastr.success('{{ \Session::get('message') }}')
      @endif
    });
  </script>

  <script>
    $(function () {
      let dataGroupDepartment = {
        labels: [
          @foreach($groupDepartment as $id => $item)
            '{{ $item->departmentName }}',
          @endforeach
        ],
        datasets: [
          {
            label: 'Jumlah Pegawai',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [
              @foreach($groupDepartment as $id => $item)
              {{ $item->totalUser }},
              @endforeach
            ]
          },
          {
            label: 'Sudah Lapor',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [
              @foreach($groupDepartment as $id => $item)
              {{ $item->absens }},
              @endforeach
            ]
          },
        ]
      }
      //-------------
      //- BAR CHART -
      //-------------
      let barChartCanvas = $('#kymk').get(0).getContext('2d')
      let barChartData = jQuery.extend(true, {}, dataGroupDepartment)
      barChartData.datasets[0] = dataGroupDepartment.datasets[0]
      barChartData.datasets[1] = dataGroupDepartment.datasets[1]

      let barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    });
  </script>
  <script>
    $(function () {
      let dataDepartment = {
        labels: [
          @foreach($dataDepartment as $id => $item)
            '{{ $item->departmentName }}',
          @endforeach
        ],
        datasets: [
          {
            label: 'Sehat',
            backgroundColor: 'rgba(0, 230, 64, 1)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [
              @foreach($dataDepartment as $id => $item)
              {{ $item->sehat }},
              @endforeach
            ]
          },
          {
            label: 'Sakit',
            backgroundColor: 'rgba(247, 202, 24, 1)',
            borderColor: 'rgba(247, 202, 24, 1)',
            pointRadius: false,
            pointColor: 'rgba(247, 202, 24, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [
              @foreach($dataDepartment as $id => $item)
              {{ $item->sakit }},
              @endforeach
            ]
          },
        ]
      }
      //-------------
      //- BAR CHART -
      //-------------
      let barChartCanvas = $('#kd').get(0).getContext('2d')
      let barChartData = jQuery.extend(true, {}, dataDepartment)
      barChartData.datasets[0] = dataDepartment.datasets[0]
      barChartData.datasets[1] = dataDepartment.datasets[1]

      let barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
    });
  </script>
  <script>
    $(function () {
      let pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }

      let donutDataGroupSehat = {
        labels: [
          'Sehat',
          'Sakit'
        ],
        datasets: [
          {
            data: [
              {{ $sehat }}, {{ $sakit }}
            ],
            backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      //-------------
      //- Doughnut CHART -
      //-------------
      let pieChartCanvasGroupSehat = $('#pieChartGroupSehat').get(0).getContext('2d');
      new Chart(pieChartCanvasGroupSehat, {
        type: 'doughnut',
        data: donutDataGroupSehat,
        options: pieOptions
      })

      //==============================================================================

      let donutDataGroupPenyakit = {
        labels: [
          @foreach($dataSakit as $id => $item)
            '{{ $id }}',
          @endforeach
        ],
        datasets: [
          {
            data: [
              @foreach($dataSakit as $id => $item)
              {{ $item }},
              @endforeach
            ],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#51ff0d', '#ffff00', '#00008b', '#ff0000'],
          }
        ]
      }
      //-------------
      //- PIE CHART -
      //-------------
      let pieChartCanvasGroupPenyakit = $('#pieChartGroupPenyakit').get(0).getContext('2d');
      new Chart(pieChartCanvasGroupPenyakit, {
        type: 'pie',
        data: donutDataGroupPenyakit,
        options: pieOptions
      })
    });
  </script>
@endsection
