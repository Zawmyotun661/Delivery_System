<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Package;
use App\Models\Deposit;

class ReportExport implements FromView
{
    protected $date;
    protected $word;
    protected $status;
    protected $updateDate;
    protected $township;
    protected $driver;
    public function __construct($data)
    {
        if($data == ''){
            $this->date = '';
            $this->word = '';
            $this->status = '';
            $this->updateDate = '';
            $this->township = '';
          
        }else {
            
            $this->date = $data[0];
            $this->word = $data[1];
            $this->status = $data[2];
            $this->updateDate=$data[3];
            $this->township=$data[4];
           
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
        if(!$this->date && !$this->word && !$this->status && !$this->updateDate && !$this->township && !$this->driver){
            $reports = Package::select('packages.*', 'townships.name', 'u1.name as client_name', 'shoppers.name as cus_name', 'u2.name as driver_name')
                            ->join('users as u1', 'u1.id', '=', 'packages.client_id')
                            ->leftjoin('users as u2', 'u2.id', '=', 'packages.driver_id')
                            ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->orderBy('packages.id', 'DESC')
                            ->get();
        foreach($reports as $report){
            $pack_date = $report->date;
            $shopper_id = $report->shopper_id;
            $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                    ->where('deposits.date',$pack_date)
                                    ->sum('deposits.amount');
            $report->deposit_amount = $deposit_info;
        }
        return view('exports.reports', [
            'reports' => $reports,
        ]);
        }else {
            $searchDate = $this->date;
            $searchData = $this->word;
            $searchStatus = $this->status;
            $updateDate = $this->updateDate;
            $searchTownship = $this->township;
            $searchDriver = $this->driver;
       
            $data = Package::select('packages.*', 'townships.name', 'u1.name as client_name', 'shoppers.name as cus_name', 'u2.name as driver_name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->join('users as u1', 'u1.id', '=', 'packages.client_id')
                            ->join('users as u2', 'u2.id', '=', 'packages.driver_id')
                            ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                            ->where(function($query) use($searchData){
                                $query->where('u1.name', 'like', '%'.$searchData.'%')
                                        ->orWhere('u2.name', 'like', '%'.$searchData.'%')
                                        ->orWhere('townships.name', 'like', '%'.$searchData.'%');
                                        
                            }) ->where(function($query) use($searchTownship){
                                $query->
                                        Where('townships.name', 'like', '%'.$searchTownship.'%');
                                        
                            })
                            ->where('packages.updated_at', 'like', '%'.$updateDate.'%')
                            ->where('packages.date', 'like', '%'.$searchDate.'%')
                            ->where('packages.status', 'like', '%'.$searchStatus.'%')
                            ->orderBy('packages.id', 'DESC')->get();
            foreach($data as $report){
                $pack_date = $report->date;
                $shopper_id = $report->shopper_id;
                $deposit_info = Deposit::where('deposits.shopper_id',$shopper_id)
                                        ->where('deposits.date',$pack_date)
                                        ->sum('deposits.amount');
                $report->deposit_amount = $deposit_info;
            }
            return view('exports.reports', [
                'reports' => $data
            ]);
            
        }
        
    }
}
