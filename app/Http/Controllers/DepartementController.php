<?php

namespace App\Http\Controllers;

use App\model\Departement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DepartementController extends Controller
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
   * Display a listing of the resource.
   *
   * @return Application|Factory|Response|View
   */
  public function index()
  {
    $department = Departement::where('delete', 0)->get();

    $data = [
      'department' => $department
    ];

    return view('department.index', $data);
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
      'department_name' => 'required|string|unique:departements',
    ]);
    $department = new Departement();
    $department->department_name = $request->department_name;
    $department->save();

    return redirect()->back();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param $id
   * @return RedirectResponse|Response
   * @throws ValidationException
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'department_name' => 'required|string|unique:departements',
    ]);
    $department = Departement::find($id);
    $department->department_name = $request->department_name;
    $department->save();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param $id
   * @return RedirectResponse|Response
   */
  public function destroy($id)
  {
    $department = Departement::find($id);
    $department->delete = 1;
    $department->save();

    return redirect()->back();

  }
}
