<?php

namespace App\Http\Controllers;

use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ReportController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|Response|View
   */
  public function index()
  {
    $data = array();
    if (Auth::user()->role == 1) {
    $department = Departement::where('delete', 0)->get();
      $report = Report::orderBy('id', 'desc')->get();
      $report->map(function ($item) {
        $item->user = User::find($item->id_user);
        $item->department = Departement::find($item->id_department);
        $item->penyakit = Penyakit::find($item->id_penyakit);
        return $item;
      });

      $data = [
        'report' => $report,
        'department' => $department
      ];
    } elseif (Auth::user()->role == 2) {
      $department = Departement::where('delete', 0)->get();
        $report = Report::orderBy('id', 'desc')->get();
        $report->map(function ($item) {
          $item->user = User::find($item->id_user);
          $item->department = Departement::find($item->id_department);
          $item->penyakit = Penyakit::find($item->id_penyakit);
          return $item;
        });
  
        $data = [
          'report' => $report,
          'department' => $department
        ];
      }
      return view('report.index', $data);
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
    return view('report.index', $data);
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
    return view('report.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse|Response
   * @throws ValidationException
   */
  public function store(Request $request)
  {
    if (Carbon::now() > Carbon::parse("13:00:00")) {
      return redirect()->back()->with(['message' => 'Input Anda Sudah Melewati Jam 1 siang']);
    }

    $this->validate($request, [
      'disease' => 'required|string|exists:penyakits,id',
      'domicile' => 'required|string|max:191',
      'position' => 'required|string|max:191',
      'positionDescription' => 'nullable|string|max:191',
      'description' => 'required|string|max:191',
      'check' => 'accepted',
    ]);

    $report = new Report();
    $report->id_user = Auth::user()->id;
    $report->id_department = Auth::user()->id_department;
    $report->id_penyakit = $request->disease;
    if ($request->position == '0') {
      $report->position = $request->positionDescription;
    } else {
      $report->position = $request->position;
    }
    $report->domicile = $request->domicile;
    $report->deatail = $request->description;
    $report->save();

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   *
   * @param Report $report
   * @return void
   */
  public function show(Report $report)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Report $report
   * @return void
   */
  public function edit(Report $report)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Report $report
   * @return void
   */
  public function update(Request $request, Report $report)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param $id
   * @return void
   */
  public function destroy($id)
  {
    //
  }
}
