<button onclick="exportTableToExcel('tblData', 'Data-Kesehatan')">Export Table Data To Excel File</button>
<table id="tblData">
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
        <td>{{ $item->user->phone }}</td>
        <td>{{ $item->position }}</td>
        <td>{{ $item->penyakit->penyakit_name }}</td>
        <td>{{ $item->deatail }}</td>
        <td>{{ $item->user->ktpaddress }}</td>
        <td>{{ $item->domicile }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
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