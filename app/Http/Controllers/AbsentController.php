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

class AbsentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $absent = Absent::where('City', 'IN')->where('Dt', Carbon::parse(now())->format('Ymd'))->orderBy('CreateDt','desc')->get();
            $absent->map(function ($item) {
                $item->user = User::find($item->CreateBy);
                return $item;
            });

            $data = [
                'absent' => $absent,
            ];
            return view('absent.report', $data);
        }
        else if (Auth::user()->role == 2) {
            $absent = Absent::where('City', 'IN')->where('Remark', Auth::user()->id_department)->where('Dt', Carbon::parse(now())->format('Ymd'))->orderBy('CreateDt','desc')->get();
            $absent->map(function ($item) {
                $item->user = User::find($item->CreateBy);
                return $item;
            });

            $data = [
                'absent' => $absent,
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
}
