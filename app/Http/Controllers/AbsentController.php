<?php

namespace App\Http\Controllers;

use App\model\Absent;
use App\model\Site;
use App\User;
use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use Carbon\Carbon;
use App\model\tblAttendanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\FromCollection\ExportMode;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AbsentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = Departement::where('delete', 0)->get();
        $data = [
            'setDepartment' => 0,
            'department' => $department,
          ];
        return view('absent.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'location' => 'required|integer',
        ]);
        $absent = new Absent();
        $absent->id_user =  Auth::user()->id;
        $absent->username_user =  Auth::user()->username;
        $absent->attend =  0;
        $absent->id_location =  $request->location;
        $absent->save();
        
        return redirect()->back()->with(['message' => 'Berhasil']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Absent  $absent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = User::find($id);
        $user->department = Departement::find($user->id_department);

        $att = tblAttendanceLog::where('EmpCode', Auth::user()->username)->orderBy('CreateDt','desc')->get();
        $attLog = $att->take(10);
        $attLimit = 0;
        $attLimit = $att->where('created_at', Carbon::now())->count();
        $attCount = 0;
        $attCount = $att->count();
        

        $sites = Site::where('delete', 0)->get();
        $firstSite = Site::where('delete', 0)->min('id');

        $data = [
          'user' => $user,
          'sites' => $sites,
          'firstSite' => $firstSite,
          'attLog' => $attLog,
          'attLimit' => $attLimit,
          'attCount' => $attCount,
        ];
        return view('absent.show', $data);
    }

    public function report()
    {
        if (Auth::user()->role == 1) {
            $absent = tblAttendanceLog::where('City', 'IN')->where('Dt', Carbon::parse(now())->format('Ymd'))->orderBy('CreateDt','desc')->get();
            $absent->map(function ($item) {
                $item->user = User::find($item->CreateBy);
                return $item;
            });
            $user = User::where('delete', 0)->count();

            $data = [
                'absent' => $absent,
                'user' => $user,
            ];
            return view('absent.report', $data);
        }
        else if (Auth::user()->role == 2) {
            $absent = tblAttendanceLog::where('City', 'IN')->where('Remark', Auth::user()->id_department)->where('Dt', Carbon::parse(now())->format('Ymd'))->orderBy('CreateDt','desc')->get();
            $absent->map(function ($item) {
                $item->user = User::find($item->CreateBy);
                return $item;
            });
            $user = User::where('delete', 0)->where('id_department', Auth::user()->id_department)->count();

            $data = [
                'absent' => $absent,
                'user' => $user,
            ];
            return view('absent.report', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Absent  $absent
     * @return \Illuminate\Http\Response
     */
    public function edit(Absent $absent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Absent  $absent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'location' => 'required|integer',
        ]);
        $absent = new Absent();
        $absent->id_user =  Auth::user()->id;
        $absent->username_user =  Auth::user()->username;
        $absent->attend =  1;
        $absent->id_location =  $request->location;
        $absent->save();
        
        return redirect()->back()->with(['message' => 'Berhasil']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absent  $absent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absent $absent)
    {
        //
    }

    public function export(Request $request): BinaryFileResponse
    {
      $data = [
        0 => [
          'EmpCode' => 'NIP',
          'Dt' => 'Tanggal',
          'Tm' => 'Jam',
          'City' => 'Log',
        ]
      ];
      
      $this->validate($request, [
        'date' => 'required|string',
        'department' => 'required|string',
        ]);
        $date = explode(' - ', $request->date);
        $dateStart = Carbon::parse($date[0] . ' 00:00:00');
        $dateEnd = Carbon::parse($date[1] . ' 23:59:59');
        $department = $request->department;
        if ($department == 0) {
            $att = Absent::whereBetween('Dt', [$dateStart->format('Ymd'), $dateEnd->format('Ymd')])->get();
        } else {
            $att = Absent::whereBetween('Dt', [$dateStart->format('Ymd'), $dateEnd->format('Ymd')])->where('Remark', $department)->get();
        }
        $att->map(function ($item) {
            $item->user = User::find($item->CreateBy);
        });
  
      foreach ($att as $id => $item) {
        $data[$id + 1]['EmpCode'] = $item->EmpCode;
        $data[$id + 1]['Name'] = $item->user->username;
        $data[$id + 1]['Dt'] = \Carbon\Carbon::parse($item->CreateDt)->format('d-m-Y');
        $data[$id + 1]['Tm'] = \Carbon\Carbon::parse($item->CreateDt)->format('H:i:s');
        $data[$id + 1]['City'] = $item->City;
      }
  
      $exportMode = new ExportMode($data);
      return Excel::download($exportMode, 'export.xlsx');
    }
}
