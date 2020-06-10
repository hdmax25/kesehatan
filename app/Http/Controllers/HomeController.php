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
    if (Auth::user()->role == 1) {
      $department = Departement::where('delete', 0)->get();
      $disease = Penyakit::where('delete', 0)->get();
      $report = User::where('role', '!=', 1)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->disease = Penyakit::find($item->id_penyakit);
        $item->absenes = Report::where('id_user', $item->id)->whereDate('created_at', Carbon::now())->first();
      });

      $data = [
        'department' => $department,
        'disease' => $disease,
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
        'disease' => $disease,
        'todayCheck' => $validateToday,
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
