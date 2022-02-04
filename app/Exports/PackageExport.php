<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Package;
use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class PackageExport implements FromView
{
    protected $id;
    protected $date;
    protected $word;
    protected $status;
    protected $updateDate;
    protected $township;
    protected $driver;
    public function __construct($data) 
    {
        $this->id = Auth::user()->id;
        if($data == ''){
            $this->date = '';
            $this->word = '';
            $this->status = '';
            $this->updateDate = '';
            $this->township = '';
            $this->driver = '';
        }else {
            
            $this->date = $data[0];
            $this->word = $data[1];
            $this->status = $data[2];
            $this->updateDate=$data[3];
            $this->township=$data[4];
            $this->driver=$data[5];
        }
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        if(!$this->date && !$this->word && !$this->status && !$this->updateDate && !$this->township && !$this->driver ){
        $packages = Package::select('packages.*', 'townships.name', 'users.name as driver_name', 'shoppers.name as cus_name')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                            ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.client_id', '=', $this->id)
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

        return view('exports.packages', [
            'packages' => $packages
        ]);
    }else {
        $searchData = $this->word;
        $searchDate = $this->date;
        $searchStatus = $this->status;
        $updateDate = $this->updateDate;
        $searchTownship = $this->township;
        $searchDriver = $this->driver;
   
        $data = Package::select('packages.*', 'townships.name', 'users.name as driver_name', 'shoppers.name as cus_name')
                        ->join('townships', 'townships.id', '=', 'packages.township_id')
                        ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                        ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
                        ->where('packages.client_id', '=', Auth::user()->id)
                        ->where('packages.updated_at', 'like', '%'.$updateDate.'%')
                        ->where('packages.status', 'like', '%'.$searchStatus.'%')
                        ->where(function($query) use($searchData){
                            $query
                                    ->Where('shoppers.name', 'like', '%'.$searchData.'%');
                                    
                                    
                        })->where(function($query) use($searchTownship){
                            $query->where('townships.name', 'like', '%'.$searchTownship.'%');
                                 
                                    
                        })->where(function($query) use($searchDriver){
                            $query->where('users.name', 'like', '%'.$searchDriver.'%');
                                 
                                    
                        })->where(function($query) use($searchDate){
                            $query->where('packages.date', 'like', '%'.$searchDate.'%');
                                 
                                    
                        })->orderBy('packages.id', 'DESC')->get();
                        $amount_delivery=0;
                        $paid_amount=0;
                        $depo=0;
                        $amount_paid=0;
                        $amount_paid=0;
                        $amount_total=0;
                        $total_delivery=0;
                        
                foreach($data as $package)
                {
                    
                    $pack_date = $package->date;
                    $shopper_id = $package->shopper_id;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                    if($package->driver_name != '') {

                          if ($package->paid==='1'){
                                $paid_amount += $package->price;
                                $amount_delivery +=$package->delivery_fee;
                            }
                            $amount_total+=$package->price;
                            $amount_paid+=$package->paid_amount;
                            $amount_paid+=$package->price;
                           $total_delivery += $package->delivery_fee;
                            $final_amount=$amount_total-$amount_delivery;
                            $final_deposit= $final_amount-$deposit_info;
                    }else {
                        $total = 0;
                    }
                    
                }
        return view('exports.packages', [
            'packages' => $data,
            'total_price'=>$amount_total,
            'amount_delivery'=>$amount_delivery,
          
        ]);
    }
    }
}