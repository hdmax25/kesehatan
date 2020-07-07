<?php

namespace App\Http\Controllers;

use App\model\Absent;
use App\User;
use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use Carbon\Carbon;
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
            'lat' => 'required|string',
            'long' => 'required|string',
          ]);
        $absent = new Absent();
        $absent->id_user =  Auth::user()->id;
        $absent->username_user =  Auth::user()->username;
        $absent->attend =  0;
        $absent->lat =  $request->lat;
        $absent->long =  $request->long;
        $absent->save();

        return redirect()->back()->with(['message' => 'Absen berhasil']);
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
        $checkToday = Absent::where('id_user', Auth::user()->id)->whereDate('created_at', Carbon::now())->count();
        $check = Absent::where('id_user', Auth::user()->id)->count();
        $absent = Absent::where('id_user', $id)->orderBy('created_at', 'desc')->take(30)->get();
        $absentToday = Absent::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->first();
        $data = [
          'user' => $user,
          'absent' => $absent,
          'checkToday' => $checkToday,
          'check' => $check,
          'absentToday' => $absentToday,
        ];
        return view('absent.show', $data);
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
        $absentToday = Absent::where('id_user', Auth::user()->id)->orderBy('id', 'desc')->first();
        $dateStart = Carbon::now()->subDays(7);
        if ($absentToday < aaa) {

        } else{
            $this->validate($request, [
                'lat' => 'required|string',
                'long' => 'required|string',
            ]);
            $absent = new Absent();
            $absent->id_user =  Auth::user()->id;
            $absent->username_user =  Auth::user()->username;
            $absent->attend =  1;
            $absent->lat =  $request->lat;
            $absent->long =  $request->long;
            $absent->save();
        }
        return redirect()->back()->with(['message' => 'Absen berhasil']);
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
