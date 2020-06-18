<?php

namespace App\Http\Controllers;

use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * Show the application dashboard.
   *
   * @return Renderable
   */
  public function index(): Renderable
  {
    $sehat = 0;
    $sakit = 0;
    $dataSakit = array();
    if (Auth::user()->role == 1) {
      $department = Departement::where('delete', 0)->get();
      $disease = Penyakit::where('delete', 0)->get();
      $report = User::where('role', '!=', 1)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->disease = Penyakit::find($item->id_penyakit);
        $item->absenes = Report::whereDate('created_at', Carbon::now())->where('id_user', $item->id)->orderBy('id', 'desc')->first();
        return $item;
      });

      $groupDepartment = User::where('role', '!=', 1)->get()->groupBy(function ($item) {
        return $item->id_department;
      })->map(function ($item, $id) {
        $item->departmentName = Departement::find($id)->department_name;
        $item->totalUser = 0;
        $item->absens = 0;
        $item->notAbsens = 0;
        foreach ($item as $subItem) {
          $item->totalUser++;
          $subItem->absenes = Report::whereDate('created_at', Carbon::now())->where('id_user', $subItem->id)->orderBy('id', 'desc')->first();
          if ($subItem->absenes) {
            $item->absens++;
          } else {
            $item->notAbsens++;
          }
        }
        return $item;
      });

      $dataDepartment = Report::whereDate('created_at', Carbon::now())->get()->groupBy(function ($item) {
        return $item->id_department;
      })->map(function ($item, $id) {
        $item->departmentName = Departement::find($id)->department_name;
        $item->sehat = 0;
        $item->sakit = 0;
        foreach ($item as $subItem) {
          if ($subItem->id_penyakit == 1) {
            ++$item->sehat;
          } else {
            ++$item->sakit;
          }
        }
        return $item;
      });

      foreach ($report->whereNotNull('absenes') as $item) {
        if ($item->absenes->id_penyakit != 1) {
          $dataSakit[Penyakit::find($item->absenes->id_penyakit)->penyakit_name] = $item->absenes->where('id_penyakit', $item->absenes->id_penyakit)->count();
          dump($item->absenes->where('id_penyakit', $item->absenes->id_penyakit)->get());
          $sakit++;
        } else {
          $sehat++;
        }
      }

      $data = [
        'groupDepartment' => $groupDepartment,
        'dataDepartment' => $dataDepartment,
        'department' => $department,
        'disease' => $disease,
        'sehat' => $sehat,
        'sakit' => $sakit,
        'dataSakit' => $dataSakit,
        'sudah' => $report->whereNotNull('absenes'),
        'belum' => $report->whereNull('absenes')
      ];
      return view('home', $data);
    } else if (Auth::user()->role == 2) {
      $validateToday = Report::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
      $disease = Penyakit::where('delete', 0)->get();
      $report = User::where('role', '!=', 1)->where('id_department', Auth::user()->id_department)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->absenes = Report::where('id_user', $item->id)->whereDate('created_at', Carbon::now())->first();
      });

      $domicile = Report::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->first();

      $data = [
        'domicile' => $domicile,
        'todayCheck' => $validateToday,
        'disease' => $disease,
        'sehat' => $sehat,
        'sakit' => $sakit,
        'dataSakit' => $dataSakit,
        'sudah' => $report->whereNotNull('absenes'),
        'belum' => $report->whereNull('absenes')
      ];
      return view('home', $data);
    } else {
      $validateToday = Report::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
      $disease = Penyakit::where('delete', 0)->get();

      $domicile = Report::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->first();

      $data = [
        'domicile' => $domicile,
        'disease' => $disease,
        'todayCheck' => $validateToday
      ];
      return view('home', $data);
    }
  }
}
