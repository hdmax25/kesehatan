<table>
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