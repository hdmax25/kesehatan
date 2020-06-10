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
            <h3 class="card-title">Data Kesehatan -
              @if (Auth::user()->role == 1)
                PT <strong>INKA</strong> <i>Multi Solusi</i>
              @else
                {{ \App\model\Departement::find(Auth::user()->id_department) ? \App\model\Departement::find(Auth::user()->id_department)->department_name : '' }}
              @endif
            </h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-primary"><i class="fa fa-calendar"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tanggal</span>
                    <span class="info-box-number">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fa fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah Pegawai</span>
                    <span class="info-box-number">{{ $sudah->count() + $belum->count() }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-danger"><i class="fa fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Belum mengisi</span>
                    <span class="info-box-number">{{ $belum->count() }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fa fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Sudah mengisi</span>
                    <span class="info-box-number">{{ $sudah->count() }}</span>
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
@endsection
