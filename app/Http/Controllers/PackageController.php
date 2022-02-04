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
use SebastianBergmann\Environment\Console;

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
        $packages = Package::select('packages.*', 'townships.name', 'users.name as driver_name', 'shoppers.name as cus_name')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                            ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.client_id', '=', Auth::user()->id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
                    
               $cities = City::all();
            $township=Township::select('name')->get();   
            
            $driver = User::join('drivers', 'drivers.user_id', '=', 'users.id')
            ->where('drivers.client_id', Auth::user()->id)
         
         
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
        
        return view('package.index',compact('packages','driver','isShopper','id', 'new_pack','township','cities'));
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
        //    $check_value = $request['paid'];
        $isChecked =  $request->has('paid') ;
        
        if  ($request->paid === '1'){
          
            $updateamount = $request->amount - $request-> deli_fee;
            $package = new Package;
            $package->client_id = Auth::user()->id;
            $package->price = $request->input('amount');
            $package->paid_amount = $updateamount;
            $package->delivery_fee = $request->input('deli_fee');   
            $package->shopper_id = $request->input('shopper_id');
            $package->date = $request->input('date');
            $package->package_name = $request->input('package_name');
            $package->package_size = $request->input('package_size');
            $package->phone = $request->input('phone');
            $package->paid = $request->input('paid');
            $package->address = $request->input('address');
            $package->receiver_name = $request->input('receiver_name');
            $package->township_id = $request->input('townshipId');
            $package->payment_status=$request->input('payment_status');
           
            $package->status = $request->input('status');
            $package->remark = $request->input('remark');
            $package->save();
            return response()->json(['success'=>'Successfully']);
        
            } else {
            
                $package = new Package;
                $package->client_id = Auth::user()->id;
                $package->price =  $request->input('amount');
                $package->delivery_fee = $request->input('deli_fee');   
                $package->shopper_id = $request->input('shopper_id');
                $package->date = $request->input('date');
                $package->package_name = $request->input('package_name');
                $package->paid = $request->input('paid');
                $package->package_size = $request->input('package_size');
                $package->phone = $request->input('phone');
                $package->address = $request->input('address');
                $package->receiver_name = $request->input('receiver_name');
                $package->township_id = $request->input('townshipId');
                $package->payment_status=$request->input('payment_status');
                $package->status = $request->input('status');
                $package->remark = $request->input('remark');
                $package->save();
                return response()->json(['success'=>'SUCCESS']);
               
            }
        
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
    public function edit_list($package_id)
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
        return view('package.edit_list',compact('package','city'));
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
        //    $arryToString = implode(',',$request->input('paid'));
        //    $package['paid']=$arryToString
      
        if  ($request->paid === '1'){
         
           $updateamount = $request->amount - $request-> deli_fee;
            $updatedeli = $request->deli_fee -  $request->deli_fee;
            $id = $request->input('id');
            $package = Package::find($id);
          
            $package->client_id = Auth::user()->id;
            $package->shopper_id = $request->input('shopper_id');
            $package->date = $request->input('date');
            $package->package_name = $request->input('package_name');
            $package->paid = $request->input('paid');
            $package->payment_status=$request->input('payment_status');
            $package->package_size = $request->input('package_size');
            $package->receiver_name = $request->input('receiver_name');
            $package->phone = $request->input('phone');
            $package->address = $request->input('address');
            $package->township_id = $request->input('townshipId');
            $package->price = $request->input('amount');
            $package->paid_amount = $updateamount;
            $package->delivery_fee = $request->input('deli_fee');
            $package->status = $request->input('status');
            $package->remark = $request->input('remark');
            $package->save();
            return response()->json(['successAlert'=>'Package Successfully Updated.']);
        } else {
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
            $package->payment_status=$request->input('payment_status');
            $package->status = $request->input('status');
            $package->remark = $request->input('remark');
            $package->save();
            return response()->json(['successAlert'=>'Package Successfully Updated.']);
        }
            
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
        $package = Package::find($pid);
        if($package->image){
            $image = $package->image;
        $filePath = "image/".$image;
        if(file_exists(public_path($filePath))) {
            unlink(public_path($filePath));
        }
        }
        $package->delete();
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
            $searchDriver = $request->driver;
            $startdate=$request->startdate;
            $enddate=$request->enddate;
            $searchTownship = $request->township;
            $isShopper = $request->isShopper;
            $shopperId = $request->shopperId;
            $searchDate = $request->searchDate;
            $updateDate = $request->updateDate;
            $searchStatus = $request->status;
            $deposit = 0;
            if($updateDate){
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->where('date',$updateDate)
                                ->sum('amount');
            }else {
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->sum('amount');
            }
            if($searchDate){
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->where('date',$searchDate)
                                ->sum('amount');
            }else {
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->sum('amount');
            }
            $amount_total=0;  
            $amount_paid=0;
            $amount_delivery=0;
            $final_amount=0;
            $final_deposit=0;
            ///////////////
            $total = 0;
            $total_amount = 0;
            $toget = 0;
            $total_dept=0;
            $total_delivery = 0;
            $fee=0;
            $paid_amount=0;
            $unpaid_amount=0;
            $unpaid_delivery=0;
            $depo=0;
            
            if($isShopper == 1)
            {
                $data = Package::select('packages.*', 'townships.name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->where('packages.shopper_id', $shopperId)
                                ->where('townships.name', 'like', '%'.$searchData.'%')
                                ->where('packages.date', 'like', '%'.$searchDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->orderBy('packages.id', 'DESC')->get();
                                foreach($data as $pack)
                                {////////////////////Only Negative Price ////////////////////////
                                    $negative = 0;
                                    $positive = 0;
                                    
                                    if (strpos($pack['price'], '-') !== false) {
                                        $negative += $pack['price'];
                                    } else {
                                        $positive += $pack['price'];
                                    }
                                    $total_dept += $negative;
                                    // dd($pack->paid);
                                    //////////Only Check Paid Amount///////////
                                    if ($pack->paid==='1'){
                                        $paid_amount += $pack->price;
                                        $amount_delivery +=$pack->delivery_fee;
                                    }
                                    
                                    ///////Uncheck delivery and paid amount////////
                                    else {
                                        $unpaid_amount += $pack->price;
                                        $unpaid_delivery +=$pack->delivery_fee;
                                    }
                                    
                                    
                                    //////////////////////
                                    $amount_paid+=$pack->paid_amount;
                                    $amount_total+=$pack->price;
                                    $depo = $deposit;
                                    $total += $pack->price ;
                                    $total_amount = $total - $unpaid_delivery;
                                    $toget = $total_amount - $deposit;
                                    
                                    $total_delivery += $pack->delivery_fee; 
                        
                                    $final_amount=$amount_total-$amount_delivery;
                                    $final_deposit= $final_amount-$depo;
                                    // $fee = $total_amount - $total_delivery - $deposit;
                                    // $fee = $total_amount - $total_delivery - $deposit;
                                   
                                }
                $response = [
                    'package' => $data,
                   'paid_delivery'=>$amount_delivery,
                   'total_delivery'=>$total_delivery,
                    'total' => $final_deposit,
                    'total_amount' => $total,
                    'unpaid'=>$unpaid_amount,
                    'toget' => $final_amount,
                    'shopperId' => $shopperId
                ];
                return response()->json($response);
            }else {
                $amount_total=0;  
                $amount_paid=0;
                $amount_delivery=0;
                $final_amount=0;
                $final_deposit=0;
                ///////////////
                $total = 0;
                $total_amount = 0;
                $toget = 0;
                $total_dept=0;
                $total_delivery = 0;
                $fee=0;
                $paid_amount=0;
                $unpaid_amount=0;
                $unpaid_delivery=0;
                $depo=0;
                
                $data = Package::select('packages.*', 'townships.name', 'users.name as driver_name', 'shoppers.name as cus_name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                                ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                                ->where('packages.client_id', '=', Auth::user()->id)
                                
                                ->where('packages.updated_at', 'like', '%'.$updateDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->where(function($query) use($searchData){
                                    $query
                                            ->Where('shoppers.name', 'like', '%'.$searchData.'%')
                                            ->orWhere('packages.phone', 'like', '%'.$searchData.'%')
                                            ->orWhere('users.name', 'like', '%'.$searchData.'%')
                                            ->orWhere('packages.receiver_name', 'like', '%'.$searchData.'%');
                                            
                                })->where(function($query) use($searchTownship){
                                    $query->where('townships.name', 'like', '%'.$searchTownship.'%');
                                         
                                            
                                })->where(function($query) use($searchDriver){
                                    $query->where('users.name', 'like', '%'.$searchDriver.'%');
                                         
                                            
                                })->where(function($query) use($searchDate){
                                    $query->where('packages.date', 'like', '%'.$searchDate.'%');
                                         
                                            
                                })
                                // ->where(function($query) use($startdate,$enddate){
                                //     $query->whereBetween('packages.date',array($startdate,$enddate));

                                       
                                            
                                // })
                                ->orderBy('packages.id', 'DESC')->get();
                                
                foreach($data as $package)
                {
                    $pack_date = $package->date;
                    $shopper_id = $package->shopper_id;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                    if($package->driver_name != '') {
                        $total += $package->price + $package->delivery_fee;
                    }else {
                        $total = 0;
                    }
                    if ($package->paid==='1'){
                        $paid_amount += $package->price;
                        $amount_delivery +=$package->delivery_fee;
                    }
                    
                    ///////Uncheck delivery and paid amount////////
                    else {
                        $unpaid_amount += $package->price;
                        $unpaid_delivery +=$package->delivery_fee;
                    }
                    
                    
                    //////////////////////
                    $amount_paid+=$package->paid_amount;
                    $amount_total+=$package->price;
                    $depo = $deposit_info;
                    $total += $package->price ;
                    $total_amount = $total - $unpaid_delivery;
                    $toget = $total_amount - $deposit;
                    
                    $total_delivery += $package->delivery_fee; 
        
                    $final_amount=$amount_total-$amount_delivery;
                    $final_deposit= $final_amount-$depo;

                }
                $response = [
                    'package' => $data,
                    'driverTotal' => $total,
                    'total_amount' =>$amount_total,
                    'delivery_fee' => $unpaid_delivery
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
        $searchData = explode('&',$data);
      
        foreach($searchData as $word)
        {
            $slice[] = Str::after($word, '=');
        }
        return Excel::download(new PackageExport($slice), $customer->name.'.xlsx');

    }
}
