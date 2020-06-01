<?php

namespace App\Http\Controllers;

use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
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
      $department = Departement::all();
      $report = Report::orderBy('id', 'desc')->get();
      $report->map(function ($item) {
        $item->user = User::find($item->id_user);
        $item->department = Departement::find($item->id_department);
        $item->penyakit = Departement::find($item->id_penyakit);
        return $item;
      });

      $data = [
        'report' => $report,
        'department' => $department
      ];
      return view('home', $data);
    } else if (Auth::user()->role == 2) {
      $report = Report::orderBy('id', 'desc')->where('id_department', Auth::user()->id_department)->get();
      $report->map(function ($item) {
        $item->user = User::find($item->id_user);
        $item->department = Departement::find($item->id_department);
        $item->penyakit = Departement::find($item->id_penyakit);
        return $item;
      });

      $data = [
        'report' => $report,
      ];
      return view('home', $data);
    } else {
      $disease = Penyakit::all();
      $report = Report::orderBy('id', 'desc')->where('id_user', Auth::user()->id)->get();
      $report->map(function ($item) {
        $item->user = User::find($item->id_user);
        $item->department = Departement::find($item->id_department);
        $item->penyakit = Penyakit::find($item->id_penyakit);
        return $item;
      });

      $data = [
        'report' => $report,
        'disease' => $disease
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
    $dateStart = $date[0];
    $dateEnd = $date[1];
    $report = Report::orderBy('id', 'desc')->where('id_department', $request->department)->whereBetween('created_at', [$dateStart, $dateEnd])->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->penyakit = Departement::find($item->id_penyakit);
      return $item;
    });


    $data = [
      'report' => $report,
      'department' => Departement::all()
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
    $date = explode(' - ', $request->date);
    $dateStart = $date[0];
    $dateEnd = $date[1];
    $report = Report::orderBy('id', 'desc')->whereBetween('created_at', [$dateStart, $dateEnd])->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->penyakit = Departement::find($item->id_penyakit);
      return $item;
    });


    $data = [
      'report' => $report,
    ];
    return view('home', $data);
  }
}
