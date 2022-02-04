<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Package;
use App\Models\Township;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class DriverDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('isDriver');
    }
    public function index()
    {
        $packages= Package::select('packages.*','townships.name', 'users.name as driver_name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->join('drivers', 'drivers.client_id', '=', 'packages.client_id')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                            ->where('drivers.user_id', '=', Auth::user()->id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
                            

            $township= Township::select('name')->get();
        return view('driver.driver-dashboard',compact('packages','township'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $packages= Package::select('packages.*','townships.name','users.name as driver_name')
        // ->join('townships', 'townships.id', '=', 'packages.township_id')
        // ->join('drivers', 'drivers.client_id', '=', 'packages.client_id')
        // ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
        // ->where('drivers.user_id', '=', Auth::user()->id)
        // ->orderBy('packages.id', 'DESC')
        // ->get();
        // return view('driver.processing',compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $package = Package::select('packages.*','townships.name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.id', $id)
                            ->get();
        return view('driver.driver-dashboard-2',compact('package'));
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
        if($request->file){
            $image = $request->file;
        $resize_image = Image::make($image->getRealPath());
        $resize_image->resize(320,240);
        $filename = $image->getClientOriginalName();
        $resize_image->save(public_path('image/'.$filename));
        $input['image'] = $filename;
        }
        $input['status'] = $request->input('status');
        $input['driver_id'] = Auth::user()->id;
     
        Package::find($id)->update($input);
        return redirect('driver_dashboard')->with('successAlert','You Have Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->word;
            $searchDate= $request->date;
            $searchTownship=$request->township;
            $data = Package::select('packages.*', 'townships.name', 'users.name as driver_name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->join('drivers', 'drivers.client_id', '=', 'packages.client_id')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                            ->where('drivers.user_id', '=', Auth::user()->id)
                            ->where(function($query) use($searchData){
                                $query->where('packages.receiver_name', 'like', '%'.$searchData.'%')
                                        ->orWhere('townships.name', 'like', '%'.$searchData.'%')
                                        
                                        ->orwhere('packages.phone', 'like', '%'.$searchData.'%');
                            }) ->where(function($query) use($searchDate){
                                $query->where('packages.date','like','%'.$searchDate.'%');
                            })->where(function($query) use($searchTownship){
                                $query->where('townships.name', 'like', '%'.$searchTownship.'%');
                                     
                                        
                            })
                            ->orderBy('packages.id', 'DESC')->get();
            return response()->json($data, 200);
        }
    }
}
