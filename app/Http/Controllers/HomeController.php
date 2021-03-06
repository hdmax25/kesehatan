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
    $dataSakit = array();
    if (Auth::user()->role == 1) {
      $report = User::where('role', '!=', 1)->where('delete', 0)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->absenes = Report::whereDate('created_at', Carbon::now())->where('id_user', $item->id)->orderBy('id', 'desc')->first();
        if ($item->absenes) {
          $item->disease = Penyakit::find($item->absenes->id_penyakit);
        } else {
          $item->disease = null;
        }
        return $item;
      });

      $mirrorReport = $report->chunk(500);
      foreach ($mirrorReport as $id => $item) {
        foreach ($item as $subId => $subItem) {
          if ($subItem->absenes) {
            if ($subItem->absenes->id_penyakit != 1) {
              $dataSakit[Penyakit::find($subItem->absenes->id_penyakit)->penyakit_name] = $subItem->absenes->whereDate('created_at', Carbon::now())->where('id_penyakit', $subItem->absenes->id_penyakit)->count();
            }
          }
        }
      }

      $groupDepartment = $report->groupBy(function ($item) {
        return $item->id_department;
      })->map(function ($item, $id) {
        $item->departmentName = Departement::find($id)->department_name;
        $item->totalUser = 0;
        $item->absens = 0;
        $item->notAbsens = 0;
        $item->sehat = 0;
        $item->sakit = 0;
        foreach ($item as $subItem) {
          $item->totalUser++;
          $subItem->absenes = Report::where('id_user', $subItem->id)->whereDate('created_at', Carbon::now())->orderBy('id', 'desc')->first();
          if ($subItem->absenes) {
            if ($subItem->absenes->id_penyakit == 1) {
              ++$item->sehat;
            } else {
              ++$item->sakit;
            }
            $item->absens++;
          } else {
            $item->notAbsens++;
          }
        }
        return $item;
      });

      $data = [
        'groupDepartment' => $groupDepartment,
        'sehat' => $report->whereNotNull('absenes')->where('absenes.id_penyakit', 1)->count(),
        'sakit' => $report->whereNotNull('absenes')->where('absenes.id_penyakit', '!=', 1)->count(),
        'dataSakit' => $dataSakit,
        'sudah' => $report->whereNotNull('absenes'),
        'belum' => $report->whereNull('absenes')
      ];
      return view('home', $data);
    } else if (Auth::user()->role == 2) {
      $validateToday = Report::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
      $disease = Penyakit::where('delete', 0)->get();
      $report = User::where('role', '!=', 1)->where('delete', 0)->where('id_department', Auth::user()->id_department)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->absenes = Report::where('id_user', $item->id)->whereDate('created_at', Carbon::now())->first();
        if ($item->absenes) {
          $item->disease = Penyakit::find($item->absenes->id_penyakit);
        } else {
          $item->disease = null;
        }
        return $item;
      });

      $domicile = Report::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->first();

      $mirrorReport = $report->chunk(500);
      foreach ($mirrorReport as $id => $item) {
        foreach ($item as $subId => $subItem) {
          if ($subItem->absenes) {
            if ($subItem->absenes->id_penyakit != 1) {
              $dataSakit[Penyakit::find($subItem->absenes->id_penyakit)->penyakit_name] = $subItem->absenes->whereDate('created_at', Carbon::now())->where('id_penyakit', $subItem->absenes->id_penyakit)->count();
            }
          }
        }
      }

      $data = [
        'domicile' => $domicile,
        'todayCheck' => $validateToday,
        'disease' => $disease,
        'sehat' => $report->whereNotNull('absenes')->where('absenes.id_penyakit', 1)->count(),
        'sakit' => $report->whereNotNull('absenes')->where('absenes.id_penyakit', '!=', 1)->count(),
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
