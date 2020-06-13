@extends('layouts.app')

@section('title')
  @if (Auth::user()->role == 3)
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>
          Data Kesehatan
        </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <a href="#">
              Data Kesehatan
            </a>
          </li>
        </ol>
      </div>
    </div>
  @else
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>
          @if (Auth::user()->role == 1)
            PT <strong>INKA</strong> <i>Multi Solusi</i>
          @else
            {{ \App\model\Departement::find(Auth::user()->id_department) ? \App\model\Departement::find(Auth::user()->id_department)->department_name : '' }}
          @endif
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
  @endif
@endsection

@section('content')
  @if (Auth::user()->role !== 1)
    @if (!$todayCheck)
      @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse("13:00:00"))
        <div class="row">
          <div id="checkedToday" class="col-md-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Data Kesehatan Tanggal {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h3>
              </div>
              <form action="{{ route('report.store') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-address-card"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">NIP</span>
                          <span class="info-box-number">{{ Auth::user()->username }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Nama</span>
                          <span class="info-box-number">{{ Auth::user()->name }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Departement</span>
                          <span class="info-box-number">{{ \App\model\Departement::find(Auth::user()->id_department) ? \App\model\Departement::find(Auth::user()->id_department)->department_name : '' }}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-phone"></i></span>
                        <div class="info-box-content">
                          <span class="info-box-text">Phone</span>
                          <span class="info-box-number">{{ Auth::user()->phone }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Alamat Sesuai KTP</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Enter ..." readonly>{{ Auth::user()->ktpaddress  }}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Domisili </label><small>(Tidak harus sesuai KTP)</small>
                        <textarea class="form-control @error('domicile') is-invalid @enderror" name="domicile" rows="3"
                                  placeholder="Masukkan domisili">{{ old('domicile') ? old('domicile') : ($domicile ? $domicile->domicile : '')}}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Posisi anda saat ini</h3>
                        </div>
                        <div class="card-body">
                          <div class="form-group row">
                            <div class="custom-control custom-radio col-md-3">
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio1" name="position"
                                     value="Rumah" {{ old('position') == 'Rumah' ? 'checked' : '' }}>
                              <label for="customRadio1" class="custom-control-label">Rumah</label>
                            </div>
                            <div class="custom-control custom-radio col-md-3">
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio2" name="position"
                                     value="Kantor" {{ old('position') == 'Kantor' ? 'checked' : '' }}>
                              <label for="customRadio2" class="custom-control-label">Kantor</label>
                            </div>
                            <div class="custom-control custom-radio col-md-3">
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio3" name="position"
                                     value="Kost" {{ old('position') == 'Kost' ? 'checked' : '' }}>
                              <label for="customRadio3" class="custom-control-label">Kost</label>
                            </div>
                            <div class="input-group col-md-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <input type="radio" name="position" value="0" {{ old('position') != 'Rumah' && old('position') != 'Kantor' && old('position') != 'Kost' ? 'checked' : '' }}>
                                </span>
                              </div>
                              <input type="text" class="form-control @error('positionDescription') is-invalid @enderror" name="positionDescription" placeholder="Lain-Lain..."
                                     value="{{ old('positionDescription') }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="disease">Bagaimana Kondisi anda saat ini?</label>
                    <select id="disease" name="disease" class="form-control @error('disease') is-invalid @enderror select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                      @foreach($disease as $item)
                        <option value="{{ $item->id }}" {{ old('disease') == $item->id ? 'selected' : '' }}>{{ $item->penyakit_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Jika terdapat keluhan, silahkan jelaskan gejala/keluhan yang anda alami saat ini </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Tidak Ada" value="{{ old('description') }}">
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="check" name="check">
                    <label class="form-check-label @error('description') text-danger @enderror" for="check">Data ini saya buat dengan sebenar - benarnya dan dapat dipertanggungjawabkan</label>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-danger">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @else
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-info"></i> Alert!</h5>
            Pengisian data monitoring kesehatan pegawai telah ditutup
        </div>
      @endif
    @else
      @user
      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-danger">
            <div class="card-header">
              <h3 class="card-title">Berhasil</h3>
            </div>
            <div class="card-body">
              Terimakasih telah mengisi data kesehatan hari ini. Besok jangan lupa ngisi lagi ya kak...
            </div>
            <div class="card-footer">
              <a href="{{ route('user.show', Auth::user()->id) }}" class="btn btn-danger"><i class="far fa-clock"></i> History</a>
            </div>
          </div>
        </div>
      </div>
      @enduser
    @endif
  @endif
  @if (Auth::user()->role !== 3)
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-danger">
          <div class="card-header">
            <h3 class="card-title">Data Kesehatan</h3>
              <div class="card-tools">
                <span class="badge badge-danger">Jumlah Pegawai {{$sudah->count()+$belum->count()}}</span>
             </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-info">
                  <span class="info-box-icon"><i class="fa fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Sudah Lapor</span>
                    <span class="info-box-number">{{$sudah->count()}}</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: {{ round($sudah->count()/( $sudah->count()+$belum->count())*100,1) }}%"></div>
                    </div>
                    <span class="progress-description">
                    {{ round($sudah->count()/( $sudah->count()+$belum->count())*100,1) }}% Pegawai
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-danger">
                  <span class="info-box-icon"><i class="fa fa-users"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Belum  Lapor</span>
                    <span class="info-box-number">{{$belum->count()}}</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}%"></div>
                    </div>
                    <span class="progress-description">
                    {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}% Pegawai
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-success">
                  <span class="info-box-icon"><i class="fas fa-heartbeat"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Sehat</span>
                    <span class="info-box-number">{{$sudah->count()}}</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: {{ round($sudah->count()/( $sudah->count()+$belum->count())*100,1) }}%"></div>
                    </div>
                    <span class="progress-description">
                    {{ round($sudah->count()/( $sudah->count()+$belum->count())*100,1) }}% Pegawai
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box bg-warning">
                  <span class="info-box-icon"><i class="fas fa-heartbeat"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-text">Sakit</span>
                    <span class="info-box-number">{{$belum->count()}}</span>

                    <div class="progress">
                      <div class="progress-bar" style="width: {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}%"></div>
                    </div>
                    <span class="progress-description">
                    {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}% Pegawai
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-danger card-outline">
          <div class="card-header">
            <h3 class="card-title">Belum Mengisi</h3>
          </div>
          <div class="card-body">
            <table id="belum-t" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                @admin
                  <th>Department</th>
                @endadmin
                <th>Call</th>
              </tr>
              </thead>
              <tbody>
              @foreach($belum as $item)
                <tr>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->name }}</td>
                  @admin
                    <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                  @endadmin
                  <td>
                    <a href="tel:{{$item->phone}}" type="button" class="btn btn-danger btn-xs btn-block">
                      <i class="fas fa-phone"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card card-success card-outline">
          <div class="card-header">
            <h3 class="card-title">Sudah Mengisi</h3>
          </div>
          <div class="card-body">
            <table id="sudah-t" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Jam</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>View</th>
              </tr>
              </thead>
              <tbody>
              @foreach($sudah as $item)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($item->absenes->created_at)->format('H:i') }}</td>
                  <td>{{ $item->username }}</td>
                  <td>{{ $item->name }}</td>
                  <td>
                    <a href="{{ route('user.show', $item->id) }}" type="button" class="btn btn-primary btn-xs btn-block">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Donut Chart</h3>
            </div>
            <div class="card-body"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 487px;" width="487" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
    </div>
  @endif
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
      let target = "13";
      if (remaining.getHours() > target) {
        let view = document.getElementById("checkedToday");
        view.innerHTML = '';
      }

      setInterval(function () {
        let remaining = new Date();
        let target = "13";
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

      $('#sudah-t').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      $('#belum-t').DataTable({
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
  @kadiv
  <script>
    $(function () {
      @error('domicile')
      toastr.warning('{{ $message }}')
      @enderror

      @error('position')
      toastr.warning('{{ $message }}')
      @enderror

      @error('positionDescription')
      toastr.warning('{{ $message }}')
      @enderror

      @error('disease')
      toastr.warning('{{ $message }}')
      @enderror

      @error('description')
      toastr.warning('{{ $message }}')
      @enderror

      @error('check')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
  @endkadiv
  @user
  <script>
    $(function () {
      @error('domicile')
      toastr.warning('{{ $message }}')
      @enderror

      @error('position')
      toastr.warning('{{ $message }}')
      @enderror

      @error('positionDescription')
      toastr.warning('{{ $message }}')
      @enderror

      @error('disease')
      toastr.warning('{{ $message }}')
      @enderror

      @error('description')
      toastr.warning('{{ $message }}')
      @enderror

      @error('check')
      toastr.warning('{{ $message }}')
      @enderror
    });
  </script>
  @enduser
  <script>
    $(function () {
      /* ChartJS
      * -------
      * Here we will create a few charts using ChartJS
      */

      //--------------
      //- AREA CHART -
      //--------------

      // Get context with jQuery - using jQuery's .get() method.
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

      var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label               : 'Digital Goods',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [28, 48, 40, 19, 86, 27, 90]
          },
          {
            label               : 'Electronics',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [65, 59, 80, 81, 56, 55, 40]
          },
        ]
      }

      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      var areaChart       = new Chart(areaChartCanvas, { 
        type: 'line',
        data: areaChartData, 
        options: areaChartOptions
      })

      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
      var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
      var lineChartData = jQuery.extend(true, {}, areaChartData)
      lineChartData.datasets[0].fill = false;
      lineChartData.datasets[1].fill = false;
      lineChartOptions.datasetFill = false

      var lineChart = new Chart(lineChartCanvas, { 
        type: 'line',
        data: lineChartData, 
        options: lineChartOptions
      })

      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData        = {
        labels: [
            'Chrome', 
            'IE',
            'FireFox', 
            'Safari', 
            'Opera', 
            'Navigator', 
        ],
        datasets: [
          {
            data: [700,500,400,600,300,100],
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions      
      })

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData        = donutData;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions      
      })

      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = jQuery.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }

      var barChart = new Chart(barChartCanvas, {
        type: 'bar', 
        data: barChartData,
        options: barChartOptions
      })

      //---------------------
      //- STACKED BAR CHART -
      //---------------------
      var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
      var stackedBarChartData = jQuery.extend(true, {}, barChartData)

      var stackedBarChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }

      var stackedBarChart = new Chart(stackedBarChartCanvas, {
        type: 'bar', 
        data: stackedBarChartData,
        options: stackedBarChartOptions
      })
    })
  </script>
@endsection
