@extends('layouts.app')

@section('title')
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
@endsection

@section('content')
  <div class="row">
    @admin
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <form action="{{ route('findSDM') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="reservation">Tanggal</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" name="date" id="reservation">
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="department">Department</label>
                  <select id="department" name="department" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                    @foreach($department as $item)
                      <option value="{{ $item->id }}">{{ $item->department_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card-footer">
                <button type="submit" class="btn btn-block btn-info btn-xs">Find</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    @endadmin
    @kadiv
    <div class="col-md-12">
      <div class="card card-outline card-danger">
        <form action="{{ route('findDevise') }}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="reservation">Tanggal</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" name="date" id="reservation">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-block btn-info btn-xs">Find</button>
          </div>
        </form>
      </div>
    </div>
    @endkadiv
    @user
    @if (!$report->where('created_at', \Carbon\Carbon::now())->count())
      <div class="col-md-12">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Data Kesehatan Tanggal {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h3>
          </div>
          <form action="{{ route('findDevise') }}" method="post">
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>
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
                    <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Departement</span>
                      <span class="info-box-number">{{ \App\model\Departement::find(Auth::user()->id_department) ? \App\model\Departement::find(Auth::user()->id_department)->department_name : '' }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fa fa-phone"></i></span>
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
                    <label for="address">Alamat Sesuai KTP</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" rows="3" name="address" id="address" placeholder="Enter ...">{{ Auth::user()->ktpaddress  }}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="domicile">Domisili</label>
                    <textarea class="form-control @error('domicile') is-invalid @enderror" rows="3" name="domicile" id="domicile"
                              placeholder="Enter ...">{{ $report->first() ? $report->first()->domicile : ''  }}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card card-outline card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Posisi anda saat ini</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="custom-control custom-radio col-md-3">
                        <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" name="position" value="Rumah" checked>
                        <label class="custom-control-label">Rumah</label>
                      </div>
                      <div class="custom-control custom-radio col-md-3">
                        <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" name="position" value="Kantor">
                        <label class="custom-control-label">Kantor</label>
                      </div>
                      <div class="custom-control custom-radio col-md-3">
                        <input class="custom-control-input @error('position') is-invalid @enderror" type="radio" name="position" value="Kost">
                        <label class="custom-control-label">Kost</label>
                      </div>
                      <div class="input-group col-md-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text @error('position') is-invalid @enderror">
                            <input type="radio" id="position" name="position" value="0">
                          </span>
                        </div>
                        <input type="text" class="form-control @error('positionDescription') is-invalid @enderror" name="positionDescription" placeholder="Lain-Lain...">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="disease">Bagaimana Kondisi anda saat ini?</label>
                <select id="disease" name="disease" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" required>
                  @foreach($disease as $item)
                    <option value="{{ $item->id }}">{{ $item->penyakit_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="description">Jika terdapat keluhan, silahkan jelaskan gejala/keluhan yang anda alami saat ini </label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Tidak Ada">
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label" for="exampleCheck1">Data ini saya buat dengan sebenar - benarnya dan dapat dipertanggungjawabkan</label>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    @endif
    @enduser
    <div class="col-md-12">
      <div class="card card-danger">
        <div class="card-header">
          <h3 class="card-title">Primary Outline</h3>
        </div>
        <div class="card-body table-responsive">
          <table id="report" class="table table-bordered table-striped text-center">
            <thead>
            <tr>
              <th>Tanggal</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Department</th>
              <th>Phone</th>
              <th>Posisi</th>
              <th>Kondisi</th>
              <th>Keluhan</th>
              <th>Alamat</th>
              <th>Domisili</th>
            </tr>
            </thead>
            <tbody>
            @foreach($report as $item)
              <tr>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                <td>{{ $item->user->username }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->department->department_name }}</td>
                <td>{{ $item->user->phone }}</td>
                <td>{{ $item->position }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->penyakit->penyakit_name }}</td>
                <td>{{ $item->detail }}</td>
                <td>{{ $item->user->ktpaddress }}</td>
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
    $(function () {
      //Date range picker
      $('#reservation').daterangepicker();

      $('#report').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "responsive": true,
      });

      //Initialize Select2 Elements
      $('.select2').select2();

    });
  </script>
  @user
  <script>
    $(function () {
      @error('address')
      toastr.warning('{{ $message }}');
      @enderror
      @error('domicile')
      toastr.warning('{{ $message }}');
      @enderror
      @error('position')
      toastr.warning('{{ $message }}');
      @enderror
      @error('positionDescription')
      toastr.warning('{{ $message }}');
      @enderror
      @error('description')
      toastr.warning('{{ $message }}');
      @enderror
    });
  </script>
  @enduser
@endsection
