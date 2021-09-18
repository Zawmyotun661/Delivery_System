<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Township;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $country= Country::select('name')->get();
        $packages =Package::all();
       
        return view('package.index',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country= Country::select('name')->get();
        $city=City::select('name')->get();
        $township=Township::select('name')->get();
        return view('package.create',compact('country','city','township'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['country'] = $request->input('country');
        $input['city'] = $request->input('city');
        $input['township'] = $request->input('township');
        Package::create($input);
        return redirect('packages');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);


        $country= Country::select('name')->get();
        $city=City::select('name')->get();
        $township=Township::select('name')->get();
        return view('package.edit',compact('package','country','city','township'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $input = $request->all();
        $input['country'] = $request->input('country');
        $input['city'] = $request->input('city');
        $input['township'] = $request->input('township');
        Package::find($id)->update($input);
        return redirect('packages')->with('successAlert','You Have Successfully updated');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Package::find($id)->delete();
        return redirect('packages')->with('successAlert','You Have Successfully Deleted');;
    }
}
