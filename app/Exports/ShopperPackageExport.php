<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Package;
use App\Models\Deposit;

class ShopperPackageExport implements FromView
{
    protected $id;
    protected $date;
    protected $word;
    protected $status;
    public function __construct($id, $data) 
    {
        $this->id = $id;
        if($data == ''){
            $this->date = '';
            $this->word = '';
            $this->status = '';
        }else {
            $this->date = $data[0];
            $this->word = $data[1];
            $this->status = $data[2];
        }
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
    public function view(): View
    {
        if(!$this->date && !$this->word && !$this->status){
            $packages = Package::select('packages.*', 'townships.name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->where('packages.shopper_id', '=', $this->id)
                            ->orderBy('packages.id', 'DESC')
                            ->get();
        foreach($packages as $pack){
            $pack_date = $pack->date;
            $deposit_info = Deposit::where('deposits.shopper_id',$this->id)
                                    ->where('deposits.date',$pack_date)
                                    ->sum('deposits.amount');
            $pack->deposit_amount = $deposit_info;
        }
        $deposit =Deposit::where('deposits.shopper_id', $this->id)
                            ->sum('deposits.amount');
                            $amount_delivery=0;
                            $paid_amount=0;
                            $depo=0;
                            $amount_paid=0;
                            $amount_paid=0;
                            $amount_total=0;
                            $total_delivery=0;
         
                            foreach($packages as $pack){
                             
                                if ($pack->paid==='1'){
                                  $paid_amount += $pack->price;
                                  $amount_delivery +=$pack->delivery_fee;
                              }
                              $amount_total+=$pack->price;
                              $amount_paid+=$pack->paid_amount;
                              $amount_paid+=$pack->price;
                             $total_delivery += $pack->delivery_fee;
                              $final_amount=$amount_total-$amount_delivery;
                              $final_deposit= $final_amount-$deposit;
                            }
        return view('exports.shopper-package', [
            'shoppers' => $packages,
            'total_price'=>$amount_total,
            'amount_delivery'=>$amount_delivery,
            'final_amount'=>$final_amount,
            'final_deposit'=>$final_deposit,
            'total_delivery'=>$total_delivery,
        ]);
        }else {
            $shopperId = $this->id;
            $searchDate = $this->date;
            $searchData = $this->word;
            $searchStatus = $this->status;
            $deposit = 0;
            if($searchDate){
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->where('date',$searchDate)
                                ->sum('amount');
            }else {
                $deposit = Deposit::where('shopper_id',$shopperId)
                                ->sum('amount');
            }
            $amount_delivery=0;
            $paid_amount=0;
            $depo=0;
            $amount_paid=0;
            $amount_paid=0;
            $amount_total=0;
            $total_delivery=0;

            $data = Package::select('packages.*', 'townships.name')
                                ->join('townships', 'townships.id', '=', 'packages.township_id')
                                ->where('packages.shopper_id', $shopperId)
                                ->where('townships.name', 'like', '%'.$searchData.'%')
                                ->where('packages.date', 'like', '%'.$searchDate.'%')
                                ->where('packages.status', 'like', '%'.$searchStatus.'%')
                                ->orderBy('packages.id', 'DESC')->get();

                foreach($data as $package)
                {
                   
                    if ($package->paid==='1'){
                        $paid_amount += $package->price;
                        $amount_delivery +=$package->delivery_fee;
                    }
                    $amount_total+=$package->price;
                    $amount_paid+=$package->paid_amount;
                    $amount_paid+=$package->price;
                   $total_delivery += $package->delivery_fee;
                    $final_amount=$amount_total-$amount_delivery;
                    $final_deposit= $final_amount-$deposit;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopperId)
                                            ->where('deposits.date',$package)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                }
                return view('exports.shopper-package', [
                    'shoppers' => $data,
                  
                    'total_price'=>$amount_total,
                    'amount_delivery'=>$amount_delivery,
                    'final_amount'=>$final_amount,
                    'final_deposit'=>$final_deposit,
                    'total_delivery'=>$total_delivery,
                ]);
        }
    }
}
