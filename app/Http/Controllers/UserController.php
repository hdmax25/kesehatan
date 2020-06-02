<?php

namespace App\Http\Controllers;

use App\model\Departement;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
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
    $user = User::all();
    $user->map(function ($item) {
      $item->department = Departement::find($item->id_department);
    });

    $data = [
      'user' => $user
    ];

    return view('user.index', $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|Response|View
   */
  public function create()
  {
    $department = Departement::where('delete', 0)->get();

    $data = [
      'department' => $department
    ];
    return view('user.create', $data);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return Application|RedirectResponse|Response|Redirector
   * @throws ValidationException
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'department' => 'required|numeric|exists:departements,id',
      'username' => 'required|numeric|unique:users',
      'password' => 'required|string',
      'name' => 'required|string',
      'phone' => 'required|numeric',
      'address' => 'required|string',
      'role' => 'required|numeric',
    ]);

    $user = new User();
    $user->username = $request->username;
    $user->name = $request->name;
    $user->id_department = $request->department;
    $user->password = Hash::make($request->password);
    $user->phone = $request->phone;
    $user->ktpaddress = $request->address;
    $user->role = $request->role;
    $user->save();

    return redirect()->route('user.create')->with(['message' => 'input data berhasil']);
  }

  /**
   * Display the specified resource.
   *
   * @param Departement $departement
   * @return Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param $id
   * @return Application|Factory|Response|View
   */
  public function edit($id)
  {
    $user = User::find($id);
    $department = Departement::where('delete', 0)->get();

    $data = [
      'department' => $department,
      'user' => $user
    ];
    return view('user.edit', $data);
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
      'department' => 'required|numeric|exists:departements,id',
      'password' => 'nullable|string',
      'name' => 'required|string',
      'phone' => 'required|numeric',
      'address' => 'required|string',
      'role' => 'required|numeric',
    ]);

    $user = User::find($id);
    if ($user->username != $request->username){
      $this->validate($request, [
        'username' => 'required|numeric|unique:users'
      ]);
    }
    $user->id_department = $request->department;
    if ($request->password) {
      $user->password = Hash::make($request->password);
    }
    $user->phone = $request->phone;
    $user->ktpaddress = $request->address;
    $user->role = $request->role;
    $user->save();

    return redirect()->route('user.edit')->with(['message' => 'Input data berhasil']);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param Departement $departement
   * @return Response
   */
  public function destroy($id)
  {
    //
  }
}