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
        return view('exports.shopper-package', [
            'shoppers' => $packages,
            'total' => $total,
            'payable' => $payable,
            'total_delivery' => $total_delivery,
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
                    $pack_date = $package->date;
                    $total_delivery += $package->delivery_fee;
                    $deposit_info = Deposit::where('deposits.shopper_id',$shopperId)
                                            ->where('deposits.date',$pack_date)
                                            ->sum('deposits.amount');
                    $package->deposit_amount = $deposit_info;
                }
                return view('exports.shopper-package', [
                    'shoppers' => $data,
                    'total' => $total,
                    'payable' => $payable,
                    'total_delivery' => $total_delivery,
                ]);
        }
    }
}
