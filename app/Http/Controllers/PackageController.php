<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Township;
use App\Models\Driver;
use App\Models\User;
use App\Models\Deposit;
use App\Exports\PackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function __construct() 
    {
        $this->middleware('isClient');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::select('packages.*', 'townships.name', 'users.name as driver_name')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.client_id', '=', Auth::user()->id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
        foreach($packages as $pack){
            $pack_date = $pack->date;
            $shopper_id = $pack->shopper_id;
            $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                    ->where('deposits.date',$pack_date)
                                    ->sum('deposits.amount');
            $pack->deposit_amount = $deposit_info;
        }
        $isShopper = 0;
        $id = 0;        //assigning for shopper Id
        $new_pack = 0;
        return view('package.index',compact('packages','isShopper', 'id', 'new_pack'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $shopperId = $id;
        $cities = City::all();
        $township=Township::select('name')->get();

        return view('package.create',compact('township','cities','shopperId'));
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $request->validate([
                'date' => 'required',
                'receiver_name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'townshipId' => 'required',
                'amount' => 'required',
                'deli_fee' => 'required',
                'status' => 'required',
            ]);
            
            $package = new Package;
            $package->client_id = Auth::user()->id;
            $package->shopper_id = $request->input('shopper_id');
            $package->date = $request->input('date');
            $package->package_name = $request->input('package_name');
            $package->package_size = $request->input('package_size');
            $package->phone = $request->input('phone');
            $package->address = $request->input('address');
            $package->receiver_name = $request->input('receiver_name');
            $package->township_id = $request->input('townshipId');
            $package->price = $request->input('amount');
            $package->delivery_fee = $request->input('deli_fee');
            $package->status = $request->input('status');
            $package->remark = $request->input('remark');
            $package->save();
            return response()->json(['success'=>'Successfully']);
        

        }
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
    public function edit($shopper_id,$package_id)
    {
        $city=City::all();
        $package = Package::select('packages.*','townships.name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.id', $package_id)
                            ->get();
        
        foreach($package as $pack){
            $tId = $pack->township_id;
            $cities = City::select('cities.id as city_id')
                            ->join('townships', 'townships.cityId', '=', 'cities.id')
                            ->where('townships.id', $tId)
                            ->get();
            $pack->city = $cities;
            $cId = $pack->city[0]->city_id;
            $township = Township::select('townships.id as tId', 'townships.name')
                                ->where('cityId', $cId)
                                ->get();
            $pack->township = $township;

        }
        return view('package.edit',compact('package','city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->ajax())
        {
            $request->validate([
                'date' => 'required',
                'receiver_name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'townshipId' => 'required',
                'amount' => 'required',
                'deli_fee' => 'required',
                'status' => 'required',

            ]);

            $id = $request->input('id');
            $package = Package::find($id);
            $package->client_id = Auth::user()->id;
            $package->shopper_id = $request->input('shopper_id');
            $package->date = $request->input('date');
            $package->package_name = $request->input('package_name');
            $package->package_size = $request->input('package_size');
            $package->receiver_name = $request->input('receiver_name');
            $package->phone = $request->input('phone');
            $package->address = $request->input('address');
            $package->township_id = $request->input('townshipId');
            $package->price = $request->input('amount');
            $package->delivery_fee = $request->input('deli_fee');
            $package->status = $request->input('status');
            $package->remark = $request->input('remark');
            $package->save();
            return response()->json(['successAlert'=>'Package Successfully Updated.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sid,$pid)
    {  
        Package::find($pid)->delete();
        return redirect('shoppers/'.$sid.'/package-list')->with('successAlert','You Have Successfully Deleted');
    }

    public function townshipList(Request $request)
    {
        if($request->ajax()){
            $cityId = $request->cityId;
            $data = Township::where('cityId', '=', $cityId)
                                    ->get();
            return response()->json($data, 200);
        }
    }
    
    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->word;
            $isShopper = $request->isShopper;
            $shopperId = $request->shopperId;
            $searchDate = $request->searchDate;
            $searchStatus = $request->status;
            // return $searchStatus;
            $deposit = 0;
            if($searchDate){
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->where('date',$searchDate)
                                ->sum('amount');
            }else {
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->sum('amount');
            }
            $total = 0;
            $toget = 0;
            $total_amount = 0;
            $total_delivery = 0;
            if($isShopper == 1)
            {
                $data = Package::select('packages.*', 'townships.name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->where('packages.shopper_id', $shopperId)
                                ->where('townships.name', 'like', '%'.$searchData.'%')
                                ->where('packages.date', 'like', '%'.$searchDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->orderBy('packages.id', 'DESC')->get();
                foreach($data as $package)
                {
                    $total += $package->price + $package->delivery_fee;
                    $total_amount += $package->price;
                    $toget = $total_amount - $deposit;
                    $total_delivery += $package->delivery_fee;
                    $pack_date = $package->date;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopperId)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    // if($deposit_info){
                    $package->deposit_amount = $deposit_info;
                    // }else{
                    // $package->deposit_amount = '';
                    // }
                }
                $response = [
                    'package' => $data,
                    'payable' => $toget,
                    'total' => $total,
                    'total_delivery' => $total_delivery,
                    'shopperId' => $shopperId
                ];
                return response()->json($response);
            }else {
                $data = Package::select('packages.*', 'townships.name', 'users.name as driver_name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                                ->where('packages.client_id', '=', Auth::user()->id)
                                ->where('packages.date', 'like', '%'.$searchDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->where(function($query) use($searchData){
                                    $query->where('users.name', 'like', '%'.$searchData.'%')
                                            ->orWhere('townships.name', 'like', '%'.$searchData.'%');
                                })->orderBy('packages.id', 'DESC')->get();
                foreach($data as $package)
                {
                    $pack_date = $package->date;
                    $shopper_id = $package->shopper_id;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    // if($deposit_info){
                    $package->deposit_amount = $deposit_info;
                    // }else{
                    // $package->deposit_amount = '';
                    // }
                }
                $response = [
                    'package' => $data
                ];
                return response()->json($response);
            }
            
        }
    }
    public function export() 
    {
        $id = Auth::user()->id;
        $customer = User::find($id);
        $data = '';
        return Excel::download(new PackageExport($data), $customer->name.'.xlsx');
    }

    public function searchExport($data)
    {
        $id = Auth::user()->id;
        $customer = User::find($id);
        $searchData = explode('&', $data);
        foreach($searchData as $word)
        {
            $slice[] = Str::after($word, '=');
        }
        return Excel::download(new PackageExport($slice), $customer->name.'.xlsx');

    }
}
