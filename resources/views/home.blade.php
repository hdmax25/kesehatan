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
        <h1>Data Kesehatan -
          @if (Auth::user()->role == 1)
            PT INKA Multi Solusi
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
                <span class="info-box-text">Divisi</span>
                <span
                    class="info-box-number">{{ \App\model\Departement::find(Auth::user()->id_department) ? \App\model\Departement::find(Auth::user()->id_department)->department_name : '' }}</span>
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
          <div id="checkedToday" class="col-md-12">
            <div class="card card-danger card-outline">
              <div class="card-header">
                <h3 class="card-title">Data Kesehatan Tanggal {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h3>
              </div>
              <form action="{{ route('report.store') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Alamat Sesuai KTP</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Enter ..."
                                  readonly>{{ Auth::user()->ktpaddress  }}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Domisili </label>
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
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio1"
                                     name="position"
                                     value="Rumah" {{ old('position') == 'Rumah' ? 'checked' : '' }}>
                              <label for="customRadio1" class="custom-control-label">Rumah</label>
                            </div>
                            <div class="custom-control custom-radio col-md-3">
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio2"
                                     name="position"
                                     value="Kantor" {{ old('position') == 'Kantor' ? 'checked' : '' }}>
                              <label for="customRadio2" class="custom-control-label">Kantor</label>
                            </div>
                            <div class="custom-control custom-radio col-md-3">
                              <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" id="customRadio3"
                                     name="position"
                                     value="Kost" {{ old('position') == 'Kost' ? 'checked' : '' }}>
                              <label for="customRadio3" class="custom-control-label">Kost</label>
                            </div>
                            <div class="input-group col-md-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <input type="radio" name="position" value="0" {{ old('position') != 'Rumah' && old('position') != 'Kantor' && old('position') != 'Kost' ? 'checked' : '' }}>
                                </span>
                              </div>
                              <input type="text" class="form-control @error('positionDescription') is-invalid @enderror"
                                     name="positionDescription" placeholder="Lain-Lain..."
                                     value="{{ old('positionDescription') }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="disease">Bagaimana Kondisi anda saat ini?</label>
                    <select id="disease" name="disease" class="form-control @error('disease') is-invalid @enderror select2 select2-danger"
                            data-dropdown-css-class="select2-danger" required>
                      @foreach($disease as $item)
                        <option
                            value="{{ $item->id }}" {{ old('disease') == $item->id ? 'selected' : '' }}>{{ $item->penyakit_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="description">Jika terdapat keluhan, silahkan jelaskan gejala/keluhan yang anda alami saat ini </label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                           placeholder="Keluhan" value="{{ old('description') }}">
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="check" name="check">
                    <label class="form-check-label @error('description') text-danger @enderror" for="check">Data ini saya buat dengan
                      sebenar - benarnya dan dapat dipertanggungjawabkan</label>
                  </div>
                </div>

                <div class="card-footer">
                  <button id="btnInOut" onclick="hideBtn()" type="submit" class="btn btn-danger">Submit</button>
                  <span id="btnLoading" class="btn btn-danger d-none disabled"><i class="fas fa-sync-alt fa-spin"></i> Submiting...</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      @else
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
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
      <div class="col-md-3 col-sm-6 col-12">
        <a href="#" title="Click for details" data-toggle="modal" data-target="#belum-lapor">
          <div class="info-box bg-danger">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Belum  Lapor</span>
              <span class="info-box-number">{{$belum->count()}}/{{$sudah->count()+$belum->count()}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}%"></div>
              </div>
              <span class="progress-description">
              {{ round($belum->count()/( $sudah->count()+$belum->count())*100,1) }}% Pegawai
              </span>
            </div>
          </div>
        </a>
        <div class="modal fade" id="belum-lapor">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Belum Lapor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="belumT" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                    <th>NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    @admin
                    <th>Divisi</th>
                    @endadmin
                    <th>WA</th>
                    <th>Call</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($belum as $item)
                    <tr>
                      <td>{{ $item->username }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->job }}</td>
                      @admin
                      <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                      @endadmin
                      <td>
                        <a href="https://api.whatsapp.com/send?phone={{$item->phone}}&text=Segera%20laporkan%20kondisi%20kesehatan%20anda%20klik%20{{ url('/') }}&source=&data=&app_absent="
                           type="button" class="btn btn-success btn-block">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </td>
                      <td>
                        <a href="tel:{{$item->phone}}" type="button" class="btn btn-danger btn-block">
                          <i class="fa fa-phone"></i>
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <div class="modal-footer float-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-primary">
          <span class="info-box-icon"><i class="fa fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Sudah Lapor</span>
            <span class="info-box-number">{{$sudah->count()}}/{{$belum->count() + $sudah->count()}}</span>

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
        <a href="#" title="Click for details" data-toggle="modal" data-target="#sudah-sehat">
          <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-heartbeat"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sehat</span>
              <span class="info-box-number">{{ $sehat }}/{{$sudah->count()}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: {{ $sehat ? round(($sehat / $sudah->count()) * 100, 1) : $sehat }}%"></div>
              </div>
              <span class="progress-description">
              {{ $sehat ? round(($sehat / $sudah->count()) * 100, 1) : $sehat }}% Pegawai
              </span>
            </div>
          </div>
        </a>
        <div class="modal fade" id="sudah-sehat">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Pegawai Sehat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="sudahSehat" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                    <th>Jam</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    @admin
                    <th>Divisi</th>
                    @endadmin
                    <th>View</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($sudah as $item)
                    @if($item->absenes->id_penyakit == 1)
                      <tr>
                        <td>{{ \Carbon\Carbon::parse($item->absenes->created_at)->format('H:i') }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->job }}</td>
                        @admin
                        <td>{{ $item->department ? $item->department->department_name : '' }}</td>
                        @endadmin
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
              <div class="modal-footer float-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-12">
        <a href="#" title="Click for details" data-toggle="modal" data-target="#sudah-sakit">
          <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-heartbeat"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sakit</span>
              <span class="info-box-number">{{ $sakit }}/{{$sudah->count()}}</span>

              <div class="progress">
                <div class="progress-bar" style="width: {{ $sakit ?  round(($sakit / $sudah->count()) * 100, 1) : $sakit }}%"></div>
              </div>
              <span class="progress-description">
              {{ $sakit ?  round(($sakit / $sudah->count()) * 100, 1) : $sakit }}% Pegawai
              </span>
            </div>
          </div>
        </a>
        <div class="modal fade" id="sudah-sakit">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Pegawai Sakit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table id="sudahSakit" class="table table-bordered table-striped" style="width: 100%">
                  <thead>
                  <tr>
                    <th>Jam</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
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
                        <td>{{ $item->job }}</td>
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
              <div class="modal-footer float-right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      </div>
    </div>
  @endif
  @admin
  <div class="row">
    <div class="col-md-6">
      <div class="card card-success card-outline">
        <div class="card-header">
          <h3 class="card-title">Kesehatan</h3>
        </div>
        <div class="card-body">
          <canvas id="pieChartGroupSehat" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">Keluhan</h3>
        </div>
        <div class="card-body">
          <canvas id="pieChartGroupPenyakit" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Laporan Divisi</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="kymk" style="min-height: 300px; height: 300px; max-height: 100%; max-width: 100%;"></canvas>
          </div>
        </div>
        <div class="card-footer no-print">
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#laporan">
            More Info
          </button>
        </div>
      </div>
      <div class="modal fade" id="laporan">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Laporan Divisi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table id="reportdep" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                <tr>
                  <th>Divisi</th>
                  <th>Jumlah</th>
                  <th>Lapor</th>
                  <th>%</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groupDepartment as $item)
                  <tr>
                    <td>{{$item->departmentName}}</td>
                    <td>{{ $item->totalUser }}</td>
                    <td>{{ $item->absens }}</td>
                    <td>{{ round($item->absens/$item->totalUser*100,1) }}%</td>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="modal-footer float-right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
    <div class="col-md-12">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Kesehatan Divisi</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="kd" style="min-height: 300px; height: 400px; max-height: 300px; max-width: 100%;"></canvas>
          </div>
        </div>
        <div class="card-footer no-print">
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#kesehatan-div">
            More Info
          </button>
        </div>
      </div>
      <div class="modal fade" id="kesehatan-div">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Kesehatan Divisi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table id="kesehatan" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                <tr>
                  <th>Dapartment</th>
                  <th>Sehat</th>
                  <th>Sakit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groupDepartment as $item)
                  <tr>
                    <td>{{$item->departmentName}}</td>
                    <td>{{ $item->sehat }}</td>
                    <td>{{ $item->sakit }}</td>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="modal-footer float-right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </div>
  </div>
  @endadmin
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

    //Hide Button
    function hideBtn() {
      document.getElementById("btnInOut").classList.add("d-none");
      document.getElementById("btnLoading").classList.remove("d-none");
    }

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
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
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

  @admin
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
          @foreach($groupDepartment as $id => $item)
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
              @foreach($groupDepartment as $id => $item)
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
              @foreach($groupDepartment as $id => $item)
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
            backgroundColor: ['#f56954', '##e04f53', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#51ff0d', '#ffff00', '#00008b', '#ff0000'],

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
  @endadmin
@endsection
