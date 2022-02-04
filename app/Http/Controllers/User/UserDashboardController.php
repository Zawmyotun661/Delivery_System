<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Package;
use App\Models\Township;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(){
        return view('user.UserDashboard');
    }
    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->name;  
            $data =  Package::select('packages.*', 'townships.name','users.name as driver_name','shoppers.name as shopper_name')
            ->join('townships', 'townships.id', '=', 'packages.township_id')
            ->join('users','users.id','=','packages.driver_id')
            ->join('shoppers','shoppers.id','=','packages.shopper_id')
            //  ->where('packages.status', '=','Processing' )
            //  ->orwhere('packages.status', '=','New')
            //  ->orwhere('packages.status', '=','Error')
             
                                -> where(function($query) use($searchData){
                                $query->where('packages.phone',$searchData);
                           
                            })->get();
                          
                            
            return response()->json($data,200);
        }
    }
    public function online_shop(){
        $township=Township::select('name')->get();   
        return view('user.onlineshopDashboard',compact('township'));
    }
    public function online_shop_search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->name;  
            $searchName = $request->word; 
            $searchTownship=$request->township;
            $searchDate = $request->searchDate;
            // $deposit = Deposit::sum('deposits.amount');
            $data =  Package::select('packages.*', 'townships.name','u1.name as client_name','shoppers.name as shopper_name')
            ->join('townships', 'townships.id', '=', 'packages.township_id')
            ->join('users as u1', 'u1.id', '=', 'packages.client_id')
            ->join('shoppers','shoppers.id','=','packages.shopper_id')
            //  ->where('packages.status', '=','Processing' )
            //  ->orwhere('packages.status', '=','New')
            //  ->orwhere('packages.status', '=','Error')
             
                                -> where(function($query) use($searchData){
                                $query->where('shoppers.phone',$searchData);
                               
                            })   -> where(function($query) use($searchName){
                                $query->where('u1.name','like', '%'.$searchName.'%');
                               
                            })->where(function($query) use($searchTownship){
                                $query->where('townships.name', 'like', '%'.$searchTownship.'%');
                                     
                                        
                            })->where('packages.date', 'like', '%'.$searchDate.'%')->get();
                           
                            $amount_delivery=0;
                            $paid_amount=0;
                            $depo=0;
                            $amount_paid=0;
                            $amount_paid=0;
                            $amount_total=0;
                            $total_delivery=0;
                          
                          foreach($data as $pack){
                             
                              if ($pack->paid==='1'){
                                $paid_amount += $pack->price;
                                $amount_delivery +=$pack->delivery_fee;
                            }
                            $amount_total+=$pack->price;
                            $amount_paid+=$pack->paid_amount;
                            $amount_paid+=$pack->price;
                           $total_delivery += $pack->delivery_fee;
                            $final_amount=$amount_total-$amount_delivery;
                            // $final_deposit= $final_amount-$deposit;
                          }
                          $response = [
                              'data'=>$data,
                          'total_price'=>$amount_total,
                          'amount_delivery'=>$amount_delivery,
                          'final_amount'=>$final_amount,
                        //   'final_deposit'=>$final_deposit,
                          'total_delivery'=>$total_delivery,

                        ];
                            
            return response()->json($response);
        }
    }
    // public function s_search(Request $request)
    // {
    //     if($request->ajax()){
    //         $searchData = $request->name;  
    //         $searchDate = $request->searchDate;
    //         $data =  Package::select('packages.*', 'townships.name','u1.name as client_name','shoppers.name as shopper_name')
    //         ->join('townships', 'townships.id', '=', 'packages.township_id')
    //         ->join('users as u1', 'u1.id', '=', 'packages.client_id')
    //         ->join('shoppers','shoppers.id','=','packages.shopper_id')
    //         //  ->where('packages.status', '=','Processing' )
    //         //  ->orwhere('packages.status', '=','New')
    //         //  ->orwhere('packages.status', '=','Error')
             
    //                             -> where(function($query) use($searchData){
    //                             $query->where('u1.name','like', '%'.$searchData.'%');
                           
    //                         })->where('packages.date', 'like', '%'.$searchDate.'%')->get();
                          
                            
    //         return response()->json($data,200);
    //     }
    // }
}
