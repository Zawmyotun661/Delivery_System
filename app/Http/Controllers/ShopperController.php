<?php

namespace App\Http\Controllers;

use App\Models\Shopper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Models\Deposit;
use App\Exports\ShopperPackageExport;
use App\Models\Township;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Illuminate\Support\Str;

class ShopperController extends Controller
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
        $shopper =Shopper::where('client_id', Auth::user()->id)
                            ->orderBy('id', 'DESC')
                            ->get();
                           
        foreach($shopper as $shop)
        {
            $shopper_id = $shop->id;
            $deposit =Deposit::where('deposits.shopper_id', $shopper_id)
                            ->sum('deposits.amount');
            $packages = Package::select('packages.price', 'packages.delivery_fee','packages.paid')
                                ->where('packages.shopper_id', '=', $shopper_id)
                                ->get();
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
                                
                                foreach($packages as $pack)
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
                                 
                                $shop->total_amount= $total;  
                                $shop->toal=$final_deposit;
                                $shop->amount=$final_deposit;
           
        }
        return view('shopper.index',compact('shopper'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shopper.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
          
        ]);
        Shopper::create([
            'name' => $request->name,
            'client_id' => Auth::user()->id,
            'phone' => $request->phone,
            'address' => $request->address,
           
        ]);
        return redirect('shoppers');
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
       $shopper= Shopper::find($id);
        return view('shopper.edit',compact('shopper'));
    }

    /**
     * Update the specified resource intorage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Shopper::find($id)->update([
            'name' => $request->name,
            'client_id' => Auth::user()->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect('/shoppers')->with('successAlert','You Have Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shopper::find($id)->delete();
        Package::where('shopper_id', $id)->delete();
        Deposit::where('shopper_id', $id)->delete();
        return redirect('/shoppers')->with('successAlert','You Have Successfully Deleted!');
    }
    public function packages($id)
    {
        $packages = Package::select('packages.*', 'townships.name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.shopper_id', '=', $id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
        foreach($packages as $pack){
            $pack_date = $pack->date;
            $deposit_info = Deposit::where('deposits.shopper_id',$id)
                                    ->where('deposits.date',$pack_date)
                                    ->sum('deposits.amount');
            $pack->deposit_amount = $deposit_info;
        }
        $deposit =Deposit::where('deposits.shopper_id', $id)
                            ->sum('deposits.amount');
//////////////////////////////
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
        foreach($packages as $pack)
        {////////////////////Only Negative Price ////////////////////////
            $negative = 0;
            $positive = 0;
            
            if (strpos($pack['price'], '-') !== false) {
                $negative += $pack['price'];
            } else {
                $positive += $pack['price'];
            }
            $total_dept += $negative;
            //////////Only Check Paid Amount///////////
            if($pack->paid==='1'){
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
            $final_deposit= $final_amount-$deposit;
            // $fee = $total_amount - $total_delivery - $deposit;
        }
        $isShopper = 1;
        $package_count = $packages->count();
        $total_package = Shopper::select('clients.total_package')
                                ->join('clients', 'clients.user_id', '=', 'shoppers.client_id')
                                ->where('shoppers.id', $id)
                                ->get();
        if($package_count >= $total_package[0]->total_package)
        {
            $new_pack = 0;
        }else{
            $new_pack = 1;
        }
        return view('package.index',compact('packages','final_deposit','final_amount','amount_delivery','amount_paid','amount_total','depo','unpaid_amount','unpaid_delivery','paid_amount','total_dept','isShopper', 'toget','total_amount', 'id','new_pack','total_delivery','fee','total'));
    }
    
    public function export($id)
    {
        $data = '';
        $shopper = Shopper::find($id);
        return Excel::download(new ShopperPackageExport($id,$data), $shopper->name.'.xlsx');
    }
    public function exportPDF($id)
    {
        $shopper = Shopper::find($id);
        $packages = Package::select('packages.*', 'townships.name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.shopper_id', '=', $id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
        foreach($packages as $pack){
            $pack_date = $pack->date;
            $deposit_info = Deposit::where('deposits.shopper_id',$id)
                                    ->where('deposits.date',$pack_date)
                                    ->sum('deposits.amount');
            $pack->deposit_amount = $deposit_info;
        }
        $deposit =Deposit::where('deposits.shopper_id', $id)
                            ->sum('deposits.amount');
        $total = 0;
        $total_amount = 0;
        $toget = 0;
        $paid_amount = 0;
        $unpaid_amount=0;
        $unpaid_delivery=0;
        foreach($packages as $pack)
        {
            
            //////////Only Check Paid Amount///////////
            if($pack->paid==='1'){
                $paid_amount += $pack->price;
            }
            ///////Uncheck delivery and paid amount////////
            else {
                $unpaid_amount += $pack->price;
                $unpaid_delivery +=$pack->delivery_fee;
            }
            
            
            //////////////////////
            $total += $pack->price ;
            $total_amount = $total - $unpaid_delivery;
            $toget = $total_amount - $deposit;
            
            
        }
        $pdf = PDF::loadView('exports.shopper-package-pdf', [
            'shopper' => $shopper,
            'packages' => $packages,
            'total_amount' => $total_amount,
            'total'=>$total,
            'toget' =>$toget,
            
        ]);
        return $pdf->download($shopper->name.'.pdf');
    }
    public function searchExport($id, $data)
    {
        $searchData = explode('&', $data);
        foreach($searchData as $word) {
            $slice[] = Str::after($word, '=');
        }
        $shopper = Shopper::find($id);
        return Excel::download(new ShopperPackageExport($id,$slice), $shopper->name.'.xlsx');
    }
    public function searchPdfExport($id, $data)
    {
        $searchData = explode('&', $data);
        foreach($searchData as $word){
            $slice[] = Str::after($word, '=');
        }
        if(!$slice)
        {
            $shopper = Shopper::find($id);
            $packages = Package::select('packages.*', 'townships.name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->where('packages.shopper_id', '=', $id)
                                ->orderBy('packages.id', 'DESC')
                                ->get();
            foreach($packages as $pack){
                
                $pack_date = $pack->date;
                $deposit_info = Deposit::where('deposits.shopper_id',$id)
                                        ->where('deposits.date',$pack_date)
                                        ->sum('deposits.amount');
                $pack->deposit_amount = $deposit_info;
            }
            $deposit =Deposit::where('deposits.shopper_id', $id)
                                ->sum('deposits.amount');
                                $total = 0;
                                $total_amount = 0;
                                $toget = 0;
                                $paid_amount = 0;
                                $unpaid_amount=0;
                                $unpaid_delivery=0;
            foreach($packages as $pack)
            {
                
                //////////Only Check Paid Amount///////////
                if($pack->paid==='1'){
                    $paid_amount += $pack->price;
                }
                ///////Uncheck delivery and paid amount////////
                else {
                    $unpaid_amount += $pack->price;
                    $unpaid_delivery +=$pack->delivery_fee;
                }
                
                
                //////////////////////
                $total += $pack->price ;
                $total_amount = $total - $unpaid_delivery;
                $toget = $total_amount - $deposit;
                
                
            }
            $pdf = PDF::loadView('exports.shopper-package-pdf', [
                'shopper' => $shopper,
                'packages' => $packages,
                'total_amount' => $total_amount,
                'total'=>$total,
                'toget' =>$toget,
            ]);
            return $pdf->download($shopper->name.'.pdf');
        }else {
            $shopperId = $id;
            $searchDate = $slice[0];
            $searchData = $slice[1];
            $searchStatus = $slice[2];
            $deposit = 0;
            $shopper = Shopper::find($id);
            if($searchDate){
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->where('date',$searchDate)
                                ->sum('amount');
            }else {
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->sum('amount');
            }
            $total = 0;
            $total_amount = 0;
            $toget = 0;
            $paid_amount = 0;
            $unpaid_amount=0;
            $unpaid_delivery=0;
            $data = Package::select('packages.*', 'townships.name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->where('packages.shopper_id', $shopperId)
                                ->where('townships.name', 'like', '%'.$searchData.'%')
                                ->where('packages.date', 'like', '%'.$searchDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->orderBy('packages.id', 'DESC')->get();
                foreach($data as $package)
                {
                
                    $pack_date = $package->date;
                   
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopperId)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                    if($package->paid==='1'){
                        $paid_amount += $package->price;
                    }
                    ///////Uncheck delivery and paid amount////////
                    else {
                        $unpaid_amount += $package->price;
                        $unpaid_delivery +=$package->delivery_fee;
                    }
                    
                    
                    //////////////////////
                    $total += $package->price ;
                    $total_amount = $total - $unpaid_delivery;
                    $toget = $total_amount - $deposit;
                    
                }
                $pdf = PDF::loadView('exports.shopper-package-pdf', [
                    'shopper' => $shopper,
                    'packages' => $data,
                    'total_amount' => $total_amount,
                    'total'=>$total,
                    'toget' =>$toget,
                ]);
                return $pdf->download($shopper->name.'.pdf');
        }
    }
    public function search(Request $request) 
    {
        if($request->ajax()){
            $searchData = $request->word;
            $customer_list = Shopper::select('shoppers.*')
                                    ->where('client_id', Auth::user()->id)
                                    ->where(function($query) use($searchData){
                                        $query->where('shoppers.name', 'like', '%'.$searchData.'%')
                                                ->orWhere('shoppers.phone', 'like', '%'.$searchData.'%');
                                    })->orderBy('shoppers.id', 'DESC')
                                    ->get();
            foreach($customer_list as $customer)
            {
                $shopper_id = $customer->id;
                $deposit =Deposit::where('deposits.shopper_id', $shopper_id)
                                ->sum('deposits.amount');
                $packages = Package::select('packages.price', 'packages.delivery_fee')
                                    ->where('packages.shopper_id', '=', $shopper_id)
                                    ->get();
                  $total = 0;
            $total_amount = 0;
            $toget = 0;
            $paid_amount = 0;
            $unpaid_amount=0;
            $unpaid_delivery=0;
                foreach($packages as $pack)
                {
                    //////////Only Check Paid Amount///////////
                    if($pack->paid==='1'){
                        $paid_amount += $pack->price;
                    }
                    ///////Uncheck delivery and paid amount////////
                    else {
                        $unpaid_amount += $pack->price;
                        $unpaid_delivery +=$pack->delivery_fee;
                    }
                    $total += $pack->price ;
            $total_amount = $total - $unpaid_delivery;
            $toget = $total_amount - $deposit;
                    
                }
                
                $customer->toget = $toget;
                $customer->total = $total;
                $customer->total_amount = $total_amount;

            }
            return response()->json($customer_list, 200);
        }
    }
}
