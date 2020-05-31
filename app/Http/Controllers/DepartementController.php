<?php

namespace App\Http\Controllers;

use App\model\Departement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DepartementController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|Response|View
   */
  public function index()
  {
    return view('department.index');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param Departement $departement
   * @return Response
   */
  public function show(Departement $departement)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Departement $departement
   * @return Response
   */
  public function edit(Departement $departement)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Departement $departement
   * @return Response
   */
  public function update(Request $request, Departement $departement)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Departement $departement
   * @return Response
   */
  public function destroy(Departement $departement)
  {
    //
  }
}
