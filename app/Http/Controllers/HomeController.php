<?php

namespace App\Http\Controllers;

use App\Http\FromCollection\ExportMode;
use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function export()
  {
    return Excel::download(new ExportMode, 'report.xlsx');
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
      $report = User::where('role', '!=', 1)->get();
      $report->map(function ($item) {
        $item->department = Departement::find($item->id_department);
        $item->absenes = Report::where('id_user', $item->id)->whereDate('created_at', Carbon::now())->first();
      });

      $data = [
        'department' => $department,
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

      $data = [
        'report' => $report,
        'disease' => $disease,
        'todayCheck' => $validateToday,
        'sudah' => $report->whereNotNull('absenes'),
        'belum' => $report->whereNull('absenes')
      ];
      return view('home', $data);
    } else {
      $validateToday = Report::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
      $disease = Penyakit::where('delete', 0)->get();
      $report = Report::orderBy('id', 'desc')->where('id_user', Auth::user()->id)->get();
      $report->map(function ($item) {
        $item->user = User::find($item->id_user);
        $item->department = Departement::find($item->id_department);
        $item->penyakit = Penyakit::find($item->id_penyakit);
        return $item;
      });

      $data = [
        'report' => $report,
        'disease' => $disease,
        'todayCheck' => $validateToday
      ];
      return view('home', $data);
    }
  }

  /**
   * @param Request $request
   * @return Application|Factory|View
   * @throws ValidationException
   */
  public function findSDM(Request $request)
  {
    $this->validate($request, [
      'date' => 'required|string',
      'department' => 'required|numeric|exists:departements,id',
    ]);

    $date = explode(' - ', $request->date);
    $dateStart = Carbon::parse($date[0] . ' 00:00:00')->format('Y-m-d H:i:s');
    $dateEnd = Carbon::parse($date[1] . '23:59:59')->format('Y-m-d H:i:s');
    $report = Report::orderBy('id', 'desc')->where('id_department', $request->department)->whereBetween('created_at', [$dateStart, $dateEnd])->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->penyakit = Penyakit::find($item->id_penyakit);
      return $item;
    });

    $data = [
      'report' => $report,
      'department' => Departement::where('delete', 0)->get()
    ];
    return view('home', $data);
  }

  /**
   * @param Request $request
   * @return Application|Factory|View
   * @throws ValidationException
   */
  public function findDevise(Request $request)
  {
    $this->validate($request, [
      'date' => 'required|string',
    ]);
    $validateToday = Report::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
    $disease = Penyakit::where('delete', 0)->get();
    $date = explode(' - ', $request->date);
    $dateStart = Carbon::parse($date[0] . ' 00:00:00')->format('Y-m-d H:i:s');
    $dateEnd = Carbon::parse($date[1] . '23:59:59')->format('Y-m-d H:i:s');
    $report = Report::orderBy('id', 'desc')->whereBetween('created_at', [$dateStart, $dateEnd])->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->penyakit = Penyakit::find($item->id_penyakit);
      return $item;
    });

    $data = [
      'report' => $report,
      'disease' => $disease,
      'todayCheck' => $validateToday
    ];
    return view('home', $data);
  }
}
