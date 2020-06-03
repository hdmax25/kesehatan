<?php

namespace App\Http\Controllers;

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
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
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
   * @return Response
   */
  public function show(Report $report)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Report $report
   * @return Response
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
   * @return Response
   */
  public function update(Request $request, Report $report)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Report $report
   * @return Response
   */
  public function destroy($id)
  {
    //
  }
}

class InvoicesExport implements FromView
{
    public function view(): View
    {
        return view('exports.invoices', [
            'invoices' => Invoice::all()
        ]);
    }
}
