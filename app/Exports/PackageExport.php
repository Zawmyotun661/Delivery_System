<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Package;
use App\Models\Deposit;
use Illuminate\Support\Facades\Auth;

class PackageExport implements FromView
{
    protected $id;
    protected $date;
    protected $word;
    protected $status;
    public function __construct($data) 
    {
        $this->id = Auth::user()->id;
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
    public function view(): View
    {
        if(!$this->date && !$this->word && !$this->status){
        $packages = Package::select('packages.*', 'townships.name', 'users.name as driver_name')
                            ->leftjoin('users', 'users.id', '=', 'packages.driver_id')
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
            'shoppers' => $packages
        ]);
    }else {
        $searchData = $this->word;
        $searchDate = $this->date;
        $searchStatus = $this->status;
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
                }
        return view('exports.packages', [
            'shoppers' => $data
        ]);
    }
    }
}