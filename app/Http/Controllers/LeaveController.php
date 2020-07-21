<?php

namespace App\Http\Controllers;

use App\User;
use App\model\Leave;
use App\model\Departement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1) {
            $leave = Leave::orderBy('updated_at', 'desc')->where('delete', 0)->take(100)->get();
            $leave->map(function ($item) {
                $item->user = User::find($item->id_user);
                $item->department = Departement::find($item->id_department);
                return $item;
            });

            $data = [
            'leave' => $leave
            ];
            return view('leave.index', $data);
        } else if (Auth::user()->role == 2) {
            $leave = Leave::orderBy('updated_at', 'desc')->where('delete', 0)->where('id_department', Auth::user()->id_department)->take(100)->get();
            $leave->map(function ($item) {
                $item->user = User::find($item->id_user);
                $item->department = Departement::find($item->id_department);
                return $item;
            });

            $data = [
            'leave' => $leave
            ];
            return view('leave.index', $data);
        } else {
            $leave = Leave::orderBy('updated_at', 'desc')->where('delete', 0)->where('id_user', Auth::user()->id)->take(100)->get();
            $leave->map(function ($item) {
                $item->user = User::find($item->id_user);
                $item->department = Departement::find($item->id_department);
                return $item;
            });

            $data = [
            'leave' => $leave
            ];
            return view('leave.index', $data);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave.create');
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
          'datetime' => 'required|string',
          'destination' => 'required|string',
          'detail' => 'required|string',
          
        ]);
        $leave = new Leave();
        $leave->type = $request->type;
        $leave->id_user = Auth::user()->id;
        $leave->id_department = Auth::user()->id_department;
        $leave->start = explode(' - ', $request->datetime)[0];
        $leave->end = explode(' - ', $request->datetime)[1];
        $leave->destination = $request->destination;
        $leave->detail = $request->detail;
        $leave->approve = 0;
        $leave->save();
        return redirect()->route('leave.index')->with(['message' => 'Leave Request Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\model\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $leave = Leave::find($id);
        $leave->user = User::find($leave->id_user);
        $leave->department = Departement::find($leave->id_department);

        $data = [
          'leave' => $leave,
        ];
        return view('leave.show', $data);
      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leave::find($id);
        $leave->user = User::find($leave->id_user);
        $leave->department = Departement::find($leave->id_department);

        $data = [
          'leave' => $leave,
        ];
        return view('leave.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'datetime' => 'required|string',
            'destination' => 'required|string',
            'detail' => 'required|string',
            
          ]);
          $leave = Leave::find($id);
          $leave->start = explode(' - ', $request->datetime)[0];
          $leave->end = explode(' - ', $request->datetime)[1];
          $leave->destination = $request->destination;
          $leave->detail = $request->detail;
          $leave->save();
          return redirect()->route('leave.index')->with(['message' => 'Edit Leave Request Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leave::find($id);
        $leave->delete = 1;
        $leave->save();
    }

    public function approve($id)
    {
        $leave = Leave::find($id);
        $leave->approve = 1;
        $leave->save();
        return redirect()->back()->with(['message' => 'Request Aprroved']);
    }

    public function cancel($id)
    {
        $leave = Leave::find($id);
        $leave->approve = 2;
        $leave->save();
        return redirect()->back()->with(['message1' => 'Request Canceled']);
    }

}
