<?php

namespace App\Http\Controllers;

use App\model\tblAttendanceLog;
use App\model\Absent;
use App\model\Site;
use App\User;
use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TblAttendanceLogController extends Controller
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
        $attlog = new tblAttendanceLog;
        $attlog->setConnection('mysql2');
        $attlog->EmpCode =  Auth::user()->username;
        $attlog->Dt = \Carbon\Carbon::now()->format('Ymd');
        $attlog->Tm = \Carbon\Carbon::now()->format('His');
        $attlog->Machine = $request->location;
        $attlog->PIN = Auth::user()->username;
        $attlog->Remark = 'Data From IT-ERP';
        $attlog->CreateBy = 'MASHARI';
        $attlog->CreateDt = \Carbon\Carbon::now()->format('YmdHi');

        $attlog->save();
        return redirect()->back()->with(['message' => 'Berhasil']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\tblAttendanceLog  $tblAttendanceLog
     * @return \Illuminate\Http\Response
     */
    public function show(tblAttendanceLog $tblAttendanceLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\tblAttendanceLog  $tblAttendanceLog
     * @return \Illuminate\Http\Response
     */
    public function edit(tblAttendanceLog $tblAttendanceLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\tblAttendanceLog  $tblAttendanceLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tblAttendanceLog $tblAttendanceLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\tblAttendanceLog  $tblAttendanceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(tblAttendanceLog $tblAttendanceLog)
    {
        //
    }
}
