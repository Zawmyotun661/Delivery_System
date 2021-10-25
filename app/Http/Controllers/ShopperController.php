<?php

namespace App\Http\Controllers;

use App\Models\Shopper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Models\Deposit;
use App\Exports\ShopperPackageExport;
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
                            ->get();
        foreach($shopper as $shop)
        {
            $shopper_id = $shop->id;
            $deposit =Deposit::where('deposits.shopper_id', $shopper_id)
                            ->sum('deposits.amount');
            $packages = Package::select('packages.price', 'packages.delivery_fee')
                                ->where('packages.shopper_id', '=', $shopper_id)
                                ->get();
            $total = 0;
            $toget = 0;
            foreach($packages as $pack)
            {
                $total += $pack->price + $pack->delivery_fee;
                $toget = $total - $deposit;
            }
            
            $shop->toget = $toget;
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
        // return $packages;
        $deposit =Deposit::where('deposits.shopper_id', $id)
                            ->sum('deposits.amount');
        $total = 0;
        $total_amount = 0;
        $toget = 0;
        $total_delivery = 0;
        foreach($packages as $pack)
        {
            // $deposit = $pack->deposit;
            $total += $pack->price + $pack->delivery_fee;
            $total_amount += $pack->price;
            $toget = $total_amount - $deposit;
            $total_delivery += $pack->delivery_fee; 
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
        return view('package.index',compact('packages','isShopper', 'toget','total', 'id','new_pack','total_delivery'));
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
        $payable = 0;
        $total_delivery = 0;
        foreach($packages as $pack)
        {
            $total += $pack->price + $pack->delivery_fee;
            $total_amount += $pack->price;
            $payable = $total_amount - $deposit;
            $total_delivery += $pack->delivery_fee;
        }
        $pdf = PDF::loadView('exports.shopper-package-pdf', [
            'shopper' => $shopper,
            'packages' => $packages,
            'total' => $total,
            'payable' => $payable,
            'total_delivery' => $total_delivery,
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
            $payable = 0;
            $total_delivery = 0;
            foreach($packages as $pack)
            {
                $total += $pack->price + $pack->delivery_fee;
                $total_amount += $pack->price;
                $payable = $total_amount - $deposit;
                $total_delivery += $pack->delivery_fee;
            }
            $pdf = PDF::loadView('exports.shopper-package-pdf', [
                'shopper' => $shopper,
                'packages' => $packages,
                'total' => $total,
                'payable' => $payable,
                'total_delivery' => $total_delivery,
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
            $payable = 0;
            $total_delivery = 0;
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
                    $payable = $total_amount - $deposit;
                    $total_delivery += $package->delivery_fee;
                    $pack_date = $package->date;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopperId)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                }
                $pdf = PDF::loadView('exports.shopper-package-pdf', [
                    'shopper' => $shopper,
                    'packages' => $data,
                    'total' => $total,
                    'payable' => $payable,
                    'total_delivery' => $total_delivery,
                ]);
                return $pdf->download($shopper->name.'.pdf');
        }
    }
}
