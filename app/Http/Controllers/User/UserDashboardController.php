<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
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
            $data =  Package::select('packages.*', 'townships.name','users.name as driver_name')
            ->join('townships', 'townships.id', '=', 'packages.township_id')
            ->join('users','users.id','=','packages.driver_id')
                                -> where(function($query) use($searchData){
                                $query->where('packages.phone',$searchData);
                           
                            })->get();
                          
                            
            return response()->json($data,200);
        }
    }
}
