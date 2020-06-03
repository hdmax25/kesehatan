
@extends('layouts.app')

@section('content')
<button onclick="exportTableToExcel('tblData', 'Data-Kesehatan')" class="btn btn-danger">Export Table Data To Excel File</button>
<div class="card-body table-responsive p-0">
    <table id="tblData" class="table table-hover table-head-fixed text-wrap">
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
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y h:m') }}</td>
            <td>{{ $item->user->username }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->department->department_name }}</td>
            <td>'{{ $item->user->phone }}</td>
            <td>{{ $item->position }}</td>
            <td>{{ $item->penyakit->penyakit_name }}</td>
            <td>{{ $item->deatail }}</td>
            <td>{{ $item->user->ktpaddress }}</td>
            <td>{{ $item->domicile }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
<script>
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
@endsection