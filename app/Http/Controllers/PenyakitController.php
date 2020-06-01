<?php

namespace App\Http\Controllers;

use App\model\Penyakit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PenyakitController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|Response|View
   */
  public function index()
  {
    $disease = Penyakit::all();

    $data = [
      'disease' => $disease
    ];
    return view('penyakit.index', $data);
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
   * @return Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param Penyakit $penyakit
   * @return Response
   */
  public function show(Penyakit $penyakit)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Penyakit $penyakit
   * @return Response
   */
  public function edit(Penyakit $penyakit)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Penyakit $penyakit
   * @return Response
   */
  public function update(Request $request, Penyakit $penyakit)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Penyakit $penyakit
   * @return Response
   */
  public function destroy(Penyakit $penyakit)
  {
    //
  }
}
