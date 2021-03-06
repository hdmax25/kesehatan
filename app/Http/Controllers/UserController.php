<?php

namespace App\Http\Controllers;

use App\Http\FromCollection\ExportMode;
use App\model\Departement;
use App\model\Penyakit;
use App\model\Report;
use App\User;
use App\Absent;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use mysql_xdevapi\Exception;
use Intervention\Image\ImageManagerStatic as Image;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
    $user = User::where('delete', 0)->get();
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
      'job' => 'required|string',
      'phone' => 'required|numeric',
      'address' => 'required|string',
      'role' => 'required|numeric',
    ]);

    $user = new User();
    $user->username = $request->username;
    $user->name = Str::upper($request->name);
    $user->id_department = $request->department;
    $user->password = Hash::make($request->password);
    $user->phone = $request->phone;
    $user->ktpaddress = Str::upper($request->address);
    $user->role = $request->role;
    $user->job = Str::upper($request->job);
    $user->save();

    return redirect()->route('user.create')->with(['message' => 'input data berhasil']);
  }

  /**
   * Display the specified resource.
   *
   * @param $id
   * @return Application|Factory|Response|View
   */
  public function show($id)
  {
    $user = User::find($id);
    $user->department = Departement::find($user->id_department);

    $report = Report::where('id_user', $id)->orderBy('id', 'desc')->take(30)->get();
    $report->map(function ($item) {
      $item->disease = Penyakit::find($item->id_penyakit);
      return $item;
    });
    $domicile = Report::where('id_user', $id)->orderBy('id', 'desc')->first();

    $data = [
      'domicile' => $domicile,
      'user' => $user,
      'report' => $report
    ];
    return view('user.show', $data);
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
   * @throws ValidationsException
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'department' => 'required|numeric|exists:departements,id',
      'password' => 'nullable|string',
      'name' => 'required|string',
      'job' => 'required|string',
      'phone' => 'required|numeric',
      'address' => 'required|string',
      'role' => 'required|numeric',
    ]);

    $user = User::find($id);
    $user->name = Str::upper($request->name);
    if ($user->username != $request->username) {
      $this->validate($request, [
        'username' => 'required|numeric|unique:users'
      ]);
      $user->username = $request->username;
    }
    $user->id_department = $request->department;
    if ($request->password) {
      $user->password = Hash::make($request->password);
    }
    $user->phone = $request->phone;
    $user->ktpaddress = Str::upper($request->address);
    $user->role = $request->role;
    $user->job = Str::upper($request->job);
    $user->save();

    return redirect()->route('user.edit', $user->id)->with(['message' => 'Input data berhasil']);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param $id
   * @return RedirectResponse|Response
   * @throws ValidationException
   */
  public function updateProfile(Request $request, $id)
  {
    $this->validate($request, [
      'check' => 'accepted',
    ]);

    $user = User::find($id);
    if ($request->password) {
      $this->validate($request, [
        'password' => 'nullable|string',
      ]);
      $user->password = Hash::make($request->password);
    }
    if ($user->ktpaddress != $request->address) {
      $this->validate($request, [
        'address' => 'required|string',
      ]);
      $user->ktpaddress = Str::upper($request->address);
    }
    if ($user->phone != $request->phone) {
      $this->validate($request, [
        'phone' => 'required|numeric',
      ]);
      $user->phone = $request->phone;
    }
    $user->save();

    return redirect()->back()->with(['message' => 'Input data berhasil']);
  }

  /**
   * @param Request $request
   * @return RedirectResponse
   * @throws ValidationException
   */
  public function updateImage(Request $request, $id): RedirectResponse
  {
    $this->validate($request, [
      'image' => 'required|mimes:jpeg,png,jpg,JPEG,PNG,JPG|max:2000'
    ]);

    $user = Auth::user();
    try {
      File::delete('dist/img/user/' . $user->image);
      $imageName = $user->username . '.' . 'jpeg';
    } catch (Exception $e) {
      $imageName = $user->username . '.' . 'jpeg';
    }
    $request->image->move('dist/img/user/', $imageName);
    $user->image = $imageName.'?'.Carbon::now();
    $user->save();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param $id
   * @return void
   */
  public function destroy($id)
  {
    $user = User::find($id);
    $user->delete = 1;
    $user->save();

    return redirect()->back();
  }

   /**
   * @return BinaryFileResponse
   */
  public function export(): BinaryFileResponse
  {
    $data = [
      0 => [
        'username' => 'NIP',
        'name' => 'Nama',
        'job' => 'Jabatan',
        'department' => 'Divisi',
        'phone' => 'Phone',
        'ktpaddress' => 'Alamat',
      ]
    ];
    $user = User::where('delete', 0)->get();
    $user->map(function ($item) {
      $item->department = Departement::find($item->id_department);
    });

    foreach ($user as $id => $item) {
      $data[$id + 1]['username'] = $item->username;
      $data[$id + 1]['name'] = $item->name;
      $data[$id + 1]['job'] = $item->job;
      if ($item->department){
        $data[$id + 1]['department'] = $item->department->department_name;
      } else {
        $data[$id + 1]['department'] = 'Tidak ada';
      }
      $data[$id + 1]['phone'] = ' '.$item->phone;
      $data[$id + 1]['ktpaddress'] = $item->ktpaddress;
    }

    $exportMode = new ExportMode($data);
    return Excel::download($exportMode, 'export.xlsx');
  }
}

