<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Data Kesehatan - PT INKA Multi Solusi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon icon -->
  <link rel="shortcut icon" href="{{ asset('dist/img/logo.jpg') }}" type="image/x-icon">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="{{ url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">
  @yield('css')
</head>
<style>
  .select2-selection {
    border: 0;
    border-radius: 0;
    font-size: 14px;
    outline: 0;
    min-height: 38px;
    text-align: left;
  }

  .select2-selection__rendered {
    margin: 10px;
  }

  .select2-selection__arrow {
    margin: 10px;
  }

  .modal-xl{
    max-width: 100%;
    height: 100%;
    margin: 0;
  }

  .modal-content{
    min-height: 100%;
    height: auto;
  }

  .modal-open .modal {
    padding-right: 0px !important;
  }
  </style>
<body class="sidebar-mini">
<div id="app" class="wrapper">
  <!-- header -->
  <x-HeaderBarComponent/>
  <!-- /.header -->

  <!-- sidebar -->
  <x-SideBarComponent/>
  <!-- /sidebar -->

  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        @yield('title')
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 0.0.7
    </div>
    <strong>Copyright &copy; 2020 <a href="{{ url('http://inkamultisolusi.co.id') }}">PT INKA Multi Solusi</a>.</strong> All rights
    reserved. <strong>Created by <a href="{{ url('#') }}">TIM IT-ERP</a>.</strong>
  </footer>

</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@yield('js')
</body>
</html>