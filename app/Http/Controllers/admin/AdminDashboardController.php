<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use App\Models\Package;
use App\Models\Deposit;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }

    public function index(){
        $users = User::all();
    return view('Admin.admin',compact('users'));
    }

    public function manage($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('Admin.add-role', compact('user','roles'));
    }

    public function update(Request $request, $id) 
    {
        $roleIds = $request->role_ids;
        $user = User::find($id);
        $user->roles()->sync($roleIds);
        return redirect('/admin/user_list');

    }

    public function search(Request $request)
    {
        $searchData = $request->search_data;
        $users = User::where('name', 'like', '%'.$searchData.'%')
                            ->orWhere('email', 'like', '%'.$searchData.'%')
                            ->orWhere('phone', 'like', '%'.$searchData.'%')
                            ->paginate(10);
        return view('Admin.admin', compact('users','searchData'));
    }

    public function reports()
    {
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
        return view('Admin.report-list', compact('reports'));
    }

    public function searchReport(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->word;
            $searchDate = $request->searchDate;
            $searchStatus = $request->status;
            $data = Package::select('packages.*', 'townships.name', 'u1.name as client_name', 'shoppers.name as cus_name', 'u2.name as driver_name')
                            ->join('townships', 'townships.id', '=', 'packages.township_id')
                            ->join('users as u1', 'u1.id', '=', 'packages.client_id')
                            ->leftjoin('users as u2', 'u2.id', '=', 'packages.driver_id')
                            ->join('shoppers', 'shoppers.id', '=', 'packages.shopper_id')
                            ->where(function($query) use($searchData){
                                $query->where('u1.name', 'like', '%'.$searchData.'%')
                                        ->orWhere('u2.name', 'like', '%'.$searchData.'%')
                                        ->orWhere('townships.name', 'like', '%'.$searchData.'%');
                            })->where('packages.date', 'like', '%'.$searchDate.'%')
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
            return response()->json($data, 200);
        }
    }
    public function export()
    {
        $data = '';
        return Excel::download(new reportExport($data), 'reports.xlsx');
    }
    public function searchExport($data)
    { 
        $searchData = explode("&",$data);
        foreach($searchData as $word){
            $slice[] = Str::after($word, '=');
        }
        return Excel::download(new reportExport($slice), 'reports.xlsx');
    }
}
