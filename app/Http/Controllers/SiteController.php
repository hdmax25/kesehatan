<?php

namespace App\Http\Controllers;

use App\model\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::where('delete', 0)->get();

        $data = [
        'sites' => $sites
        ];
        return view('site.index', $data);
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
            'name' => 'required|string|',
            'address' => 'required|string|',
            'latitude' => 'required|string|',
            'longitude' => 'required|string|',
          ]);
      
          $site = new Site();
          $site->name = $request->name;
          $site->address = $request->address;
          $site->latitude = $request->latitude;
          $site->longitude = $request->longitude;
          $site->save();
      
          return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|',
            'address' => 'required|string|',
            'latitude' => 'required|string|',
            'longitude' => 'required|string|',
          ]);
      
          $site = Site::find($id);
          $site->name = $request->name;
          $site->address = $request->address;
          $site->latitude = $request->latitude;
          $site->longitude = $request->longitude;
          $site->save();
      
          return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
