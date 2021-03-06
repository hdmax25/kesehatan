<?php

namespace App\Http\Controllers;

use App\Http\FromCollection\ExportMode;
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
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\Support\Renderable;

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
    $dateStart = Carbon::now()->subDays(2);
    $dateEnd = Carbon::now();
    $amountDate = $dateEnd->diffInDays($dateStart);
    if (Auth::user()->role == 1) {
      $department = Departement::where('delete', 0)->get();
      $report = Report::orderBy('id', 'desc')->get()->groupBy(function ($item) {
        return $item->id_user;
      })->map(function ($item) use ($amountDate) {
        $dataSickList = 0;
        $dataAbsent = 0;
        foreach ($item as $subItem) {
          if ($subItem->id_penyakit != 1) {
            $dataSickList++;
          }
          $dataAbsent++;

          $item->user = User::find($subItem->id_user);
          $item->department = Departement::find($subItem->id_department);
        }
        $item->absent = $amountDate - $dataAbsent;
        $item->sick = $dataSickList;
        return $item;
      });

      $data = [
        'report' => $report,
        'department' => $department,
        'setDepartment' => 0,
        'dateStart' => $dateStart->format('d-m-Y'),
        'dateEnd' => $dateEnd->format('d-m-Y'),
      ];
    } elseif (Auth::user()->role == 2) {
      $department = Departement::where('id', Auth::user()->id_department)->get();
      $report = Report::where('id_department', Auth::user()->id_department)->orderBy('id', 'desc')->get()->groupBy(function ($item) {
        return $item->id_user;
      })->map(function ($item) use ($amountDate) {
        $dataSickList = 0;
        $dataAbsent = 0;
        foreach ($item as $subItem) {
          if ($subItem->id_penyakit != 1) {
            $dataSickList++;
          }
          $dataAbsent++;

          $item->user = User::find($subItem->id_user);
          $item->department = Departement::find($subItem->id_department);
        }
        $item->absent = $amountDate - $dataAbsent;
        $item->sick = $dataSickList;
        return $item;
      });

      $data = [
        'report' => $report,
        'department' => $department,
        'setDepartment' => Auth::user()->id_department,
        'dateStart' => $dateStart->format('d-m-Y'),
        'dateEnd' => $dateEnd->format('d-m-Y'),
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
    ]);

    $date = explode(' - ', $request->date);
    $dateStart = Carbon::parse($date[0] . ' 00:00:00');
    $dateEnd = Carbon::parse($date[1] . ' 23:59:59');
    $amountDate = $dateEnd->diffInDays($dateStart);
    if ($request->department != 0) {
      $this->validate($request, [
        'department' => 'required|numeric|exists:departements,id',
      ]);
      $report = Report::orderBy('id', 'desc')->where('id_department', $request->department)->whereBetween('created_at', [$dateStart->format('Y-m-d H:i:s'), $dateEnd->format('Y-m-d H:i:s')])->get()->groupBy(function ($item) {
        return $item->id_user;
      })->map(function ($item) use ($amountDate) {
        $dataSickList = 0;
        $dataAbsent = 0;
        foreach ($item as $subItem) {
          if ($subItem->id_penyakit != 1) {
            $dataSickList++;
          }
          $dataAbsent++;

          $item->user = User::find($subItem->id_user);
          $item->department = Departement::find($subItem->id_department);
        }
        $item->absent = $amountDate - $dataAbsent;
        $item->sick = $dataSickList;
        return $item;
      });
    } else {
      $report = Report::orderBy('id', 'desc')->whereBetween('created_at', [$dateStart->format('Y-m-d H:i:s'), $dateEnd->format('Y-m-d H:i:s')])->get()->groupBy(function ($item) {
        return $item->id_user;
      })->map(function ($item) use ($amountDate) {
        $dataSickList = 0;
        $dataAbsent = 0;
        foreach ($item as $subItem) {
          if ($subItem->id_penyakit != 1) {
            $dataSickList++;
          }
          $dataAbsent++;

          $item->user = User::find($subItem->id_user);
          $item->department = Departement::find($subItem->id_department);
        }
        $item->absent = $amountDate - $dataAbsent;
        $item->sick = $dataSickList;
        return $item;
      });
    }

    $data = [
      'report' => $report,
      'department' => Departement::where('delete', 0)->get(),
      'setDepartment' => $request->department,
      'dateStart' => $dateStart->format('d-m-Y'),
      'dateEnd' => $dateEnd->format('d-m-Y'),
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
    $disease = Penyakit::where('delete', 0)->get();
    $date = explode(' - ', $request->date);
    $dateStart = Carbon::parse($date[0] . ' 00:00:00');
    $dateEnd = Carbon::parse($date[1] . ' 23:59:59');
    $amountDate = $dateEnd->diffInDays($dateStart);
    $report = Report::orderBy('id', 'desc')->whereBetween('created_at', [$dateStart->format('Y-m-d H:i:s'), $dateEnd->format('Y-m-d H:i:s')])->get()->groupBy(function ($item) {
      return $item->id_user;
    })->map(function ($item) use ($amountDate) {
      $dataSickList = 0;
      $dataAbsent = 0;
      foreach ($item as $subItem) {
        if ($subItem->id_penyakit != 1) {
          $dataSickList++;
        }
        $dataAbsent++;

        $item->user = User::find($subItem->id_user);
        $item->department = Departement::find($subItem->id_department);
      }
      $item->absent = $amountDate - $dataAbsent;
      $item->sick = $dataSickList;
      return $item;
    });

    $data = [
      'report' => $report,
      'disease' => $disease,
      'setDepartment' => Auth::user()->id_department,
      'dateStart' => $dateStart->format('d-m-Y'),
      'dateEnd' => $dateEnd->format('d-m-Y'),
    ];
    return view('report.index', $data);
  }

  public function daily(): Renderable
  {
    $dataSakit = array();
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
    return view('report.daily', $data);
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
      $this->validate($request, [
        'positionDescription' => 'required|string|max:191',
      ]);
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
   * @return BinaryFileResponse
   */
  public function exportkadiv(): BinaryFileResponse
  {
    $data = [
      0 => [
        'date' => 'Tanggal',
        'username' => 'NIP',
        'name' => 'Nama',
        'department' => 'Department',
        'phone' => 'Phone',
        'position' => 'Posisi',
        'disease' => ' Kondisi',
        'diseaseDescription' => 'Keluhan',
        'ktpaddress' => 'Alamat',
        'domicile' => 'Domisili',
      ]
    ];

    $report = Report::where('id_department', Auth::user()->id_department)->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->disease = Penyakit::find($item->id_penyakit);
    });

    foreach ($report as $id => $item) {
      $data[$id + 1]['date'] = $item->created_at;
      $data[$id + 1]['username'] = $item->user->username;
      $data[$id + 1]['name'] = $item->user->name;
      $data[$id + 1]['department'] = $item->department->department_name;
      $data[$id + 1]['phone'] = $item->user->phone;
      $data[$id + 1]['position'] = $item->position;
      $data[$id + 1]['disease'] = $item->disease->penyakit_name;
      $data[$id + 1]['diseaseDescription'] = $item->deatail;
      $data[$id + 1]['ktpaddress'] = $item->user->ktpaddress;
      $data[$id + 1]['domicile'] = $item->domicile;
    }

    $exportMode = new ExportMode($data);
    return Excel::download($exportMode, 'report.xlsx');
  }

  /**
   * @return BinaryFileResponse
   */
  public function export(): BinaryFileResponse
  {
    $data = [
      0 => [
        'date' => 'Tanggal',
        'username' => 'NIP',
        'name' => 'Nama',
        'department' => 'Department',
        'phone' => 'Phone',
        'position' => 'Posisi',
        'disease' => ' Kondisi',
        'diseaseDescription' => 'Keluhan',
        'ktpaddress' => 'Alamat',
        'domicile' => 'Domisili',
      ]
    ];
    $report = Report::whereDate('created_at', Carbon::now())->get();
    $report->map(function ($item) {
      $item->user = User::find($item->id_user);
      $item->department = Departement::find($item->id_department);
      $item->disease = Penyakit::find($item->id_penyakit);
    });

    foreach ($report as $id => $item) {
      $data[$id + 1]['date'] = $item->created_at;
      $data[$id + 1]['username'] = $item->user->username;
      $data[$id + 1]['name'] = $item->user->name;
      $data[$id + 1]['department'] = $item->department->department_name;
      $data[$id + 1]['phone'] = $item->user->phone;
      $data[$id + 1]['position'] = $item->position;
      $data[$id + 1]['disease'] = $item->disease->penyakit_name;
      $data[$id + 1]['diseaseDescription'] = $item->deatail;
      $data[$id + 1]['ktpaddress'] = $item->user->ktpaddress;
      $data[$id + 1]['domicile'] = $item->domicile;
    }

    $exportMode = new ExportMode($data);
    return Excel::download($exportMode, 'report.xlsx');
  }
}
