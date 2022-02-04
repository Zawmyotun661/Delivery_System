<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\RoleUser; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class DriverController extends Controller
{
    public function __construct(User $user, Driver $driver) 
    {
        $this->middleware('isClient');
        $this->user = $user;
        $this->driver = $driver;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $drivers = User::whereHas('roles', function($query) {
        //             $query->where('name', 'Driver');
        //             })->get();

        $drivers = User::join('drivers', 'drivers.user_id', '=', 'users.id')
                        ->where('drivers.client_id', Auth::user()->id)
                        ->get();
        $search_value = '';
        
            return view('driver.index',compact('drivers','search_value'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.create');
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
            'address' => 'required',
            'phone' => 'required',
        ]);

        $this->user->name = $request->name;
        $this->user->email = $request->email;
        $this->user->password = Hash::make($request['password']);
        $this->user->address = $request->address;
        $this->user->phone = $request->phone;
        $this->user->save();                           //save to user table
        $this->driver->client_id = Auth::user()->id;       
        $this->user->drivers()->save($this->driver); //save user_id to driver table
        $this->user->roles()->attach(3);             //assign role
        return redirect('drivers');
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
        $driver = User::find($id);
        return view('driver.create', compact('driver'));
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
        ]);
        $driver = User::find($id);
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->password = Hash::make($request['password']);
        $driver->address = $request->address;
        $driver->phone = $request->phone;
        $driver->update();
        return redirect('drivers')->with('successAlert','You Have Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->drivers()->delete();             //delete driver 
        $user->delete();                        //delete user
        RoleUser::where('user_id', $id)->delete();
        
        return redirect('drivers')->with('successAlert','You Have Successfully Deleted!');
    }
    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->name;
            $data =  User::join('drivers', 'drivers.user_id', '=', 'users.id')
                            ->where('drivers.client_id', '=', Auth::user()->id)
                            ->where(function($query) use($searchData){
                                $query->where('users.name', 'like', '%'.$searchData.'%')
                                ->orWhere('users.email', 'like', '%'.$searchData.'%');
                            })->get();
                            
            return response()->json($data,200);
        }
    }
}
