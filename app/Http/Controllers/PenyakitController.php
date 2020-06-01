<?php

namespace App\Http\Controllers;

use App\model\Penyakit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PenyakitController extends Controller
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
    $disease = Penyakit::where('delete', 0)->get();

    $data = [
      'disease' => $disease
    ];
    return view('penyakit.index', $data);
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
      'penyakit_name' => 'required|string|unique:penyakits',
    ]);

    $disease = new Penyakit();
    $disease->penyakit_name = $request->penyakit_name;
    $disease->save();

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
      'penyakit_name' => 'required|string|unique:penyakits',
    ]);

    $disease = Penyakit::find($id);
    $disease->penyakit_name = $request->penyakit_name;
    $disease->save();

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
    $disease = Penyakit::find($id);
    $disease->delete = 1;
    $disease->save();

    return redirect()->back();

  }
}
