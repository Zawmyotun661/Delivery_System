<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Shopper;
use App\Models\Package;
use App\Models\Deposit;
class ClientController extends Controller
{
    public function __construct(User $user, Client $client)
    {
        $this->middleware('isAdmin');
        $this->user = $user;
        $this->client = $client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $clients = User::select('users.*', 'clients.total_package')
                        ->join('clients', 'clients.user_id', '=', 'users.id')
                        ->whereHas('roles', function($query) {
                        $query->where('name', 'Client');
                        })->get();
        return view('client.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
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
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);
        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = Hash::make($request['password']);
        $this->user->address = $request->address;
        $this->user->phone = $request->phone;
        $this->user->save();
        $this->client->total_package = $request->package;
        $this->user->clients()->save($this->client);
        $this->user->roles()->attach(2);
        return redirect('clients');
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
        $client = User::select('users.*', 'clients.total_package')
                        ->join('clients', 'clients.user_id', '=', 'users.id')
                        ->where('users.id', $id)
                        ->get();
        return view('client.create',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'package' => 'required',
        ]);
        $client = User::find($id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = Hash::make($request['password']);
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->update();
        $package = Client::where('user_id', $id)->first();
        $package->total_package += $request->package;
        $package->save();
        return redirect('clients')->with('successAlert','You Have Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shopper = Shopper::join('deposits', 'deposits.shopper_id', '=', 'shoppers.id')
                            ->where('shoppers.client_id', $id)
                            ->get();
        foreach($shopper as $shopper)
        {
            Deposit::where('shopper_id', $shopper->shopper_id)->delete();
        }
        Shopper::where('client_id', $id)->delete();
        Package::where('client_id', $id)->delete();
        $selectedUser = User::join('drivers', 'drivers.user_id', '=', 'users.id')
                            ->where('drivers.client_id', $id)
                            ->get();
        foreach($selectedUser as $userId)
        {
            RoleUser::where('user_id', $userId->user_id)->delete();       //delete driver in roleusers table
        }   
        RoleUser::where('user_id', $id)->delete();                      //delete client in roleusers table                         
        User::join('drivers', 'drivers.user_id', '=', 'users.id')
                ->where('drivers.client_id', $id)
                ->delete();
        Driver::where('client_id', $id)->delete();
        $user = User::find($id);
        $user->clients()->delete();
        $user->delete();
        return redirect('clients')->with('successAlert','You Have Successfully Deleted');

    }
    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->name;
            $data =  User::select('users.*', 'clients.total_package')
                            ->join('clients', 'clients.user_id', '=', 'users.id')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->where('role_users.role_id', '=', 2)
                            ->where(function($query) use($searchData){
                                $query->where('users.name', 'like', '%'.$searchData.'%')
                                ->orWhere('users.email', 'like', '%'.$searchData.'%');
                            })->get();
                          
                            
            return response()->json($data,200);
        }
    }
}
