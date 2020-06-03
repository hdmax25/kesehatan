<?php
namespace App\Http\FromCollection;

use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\User;

class ExportMode implements FromCollection
{
  public function collection()
  {
    $data = [
      0 => [
        'date' => 'Tanggal',
        'username' => 'NIP',
        'name' => 'Nama',
        'department' => 'Department',
        'phone' => 'phone',
        'position' => 'posisi',
        'domicile' => 'Domisili',
        'address' => 'alamat'
      ]
    ];
    $report = Report::all();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->penyakit = Penyakit::find($item->id_penyakit);
    });

    foreach ($report as $id => $item) {
      $data[$id + 1]['date'] = $item->created_at;
      $data[$id + 1]['username'] = $item->user->username;
      $data[$id + 1]['name'] = $item->user->name;
      $data[$id + 1]['department'] = $item->deparment ? $item->deparment->department_name : '';
      $data[$id + 1]['phone'] = $item->user->phone;
      $data[$id + 1]['position'] = $item->position;
      $data[$id + 1]['domicile'] = $item->domicile;
      $data[$id + 1]['address'] = $item->user->address;
    }

    return collect($data);
  }
}