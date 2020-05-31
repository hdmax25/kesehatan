@extends('layouts.app')

@section('title')
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
@endsection

@section('content')
<div class="row">
  @admin
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="x">#</label>
              <select id="x" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                <option value="#">#</option>
                <option value="#">#</option>
                <option value="#">#</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="x2">#</label>
              <select id="x2" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                <option value="#">#</option>
                <option value="#">#</option>
                <option value="#">#</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-block btn-info btn-xs">Info</button>
      </div>
    </div>
  </div>
  @endadmin
  @kadiv
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="x">#</label>
              <select id="x" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
                <option value="#">#</option>
                <option value="#">#</option>
                <option value="#">#</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" class="btn btn-block btn-info btn-xs">Info</button>
      </div>
    </div>
  </div>
  @endkadiv
  @user
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Tanggal</h3>
      </div>
      <form role="form">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">NIP</span>
                  <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Nama</span>
                  <span class="info-box-number">Name</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Departement</span>
                  <span class="info-box-number">Finishing</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <div class="col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-phone"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Phone</span>
                  <span class="info-box-number">0</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Alamat Sesuai  KTP</label>
                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Domisili</label>
                <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="x">Bagaimana Kondisi anda saat ini?</label>
            <select id="x" name="user" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" required>
              <option value="#">#</option>
              <option value="#">#</option>
              <option value="#">#</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Jika terdapat keluhan, silahkan jelaskan gejala/keluhan yang anda alami saat ini </label>
            <input type="email" class="form-control" placeholder="Tidak Ada">
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Data ini saya buat dengan sebenar - benarnya dan dapat dipertanggungjawabkan</label>
          </div>
        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <!-- /. <div class="modal fade" id="modal-default" style="padding-right: 17px; display: block;" aria-modal="false">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Validasi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Apakah data yang anda masukkan sudah benar??</p>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Koreksi</button>
                <button type="button" class="btn btn-primary">Sudah</button>
              </div>
            </div>
          </div>
        </div>-->
      </form>
    </div>
  </div>
  @enduser
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Primary Outline</h3>
      </div>
      <div class="card-body table-responsive">
        <table id="report" class="table table-bordered table-striped text-center">
          <thead>
          <tr>
            <th style="width: 10px">#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th style="width: 10px">#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
              <td>#</td>
            </tr>
          </tbody>
          <tfoot>
          <tr>
            <th style="width: 10px">#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th style="width: 10px">#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
            <th>#</th>
          </tr>
          </tfoot>
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
@endsection

@section('js')
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>

  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

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

      //Initialize Select2 Elements
      $('.select2').select2()
    });
  </script>
@endsection
