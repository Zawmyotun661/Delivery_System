<?php

namespace App\Http\Controllers;

use App\Models\Township;
use App\Models\City;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $township =Township::all();
        return view('township.index',compact('township'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('township.create', compact('cities'));
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
            'cityId' => 'required',
          
        ]);
        Township::create([
            'name' => $request->name,
            'cityId' => $request->cityId,
           
        ]);
        return redirect('township');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Township::find($id)->delete();
        return redirect('township')->with('successAlert','You Have Successfully Deleted');
    }

    public function search(Request $request)
    {
        if($request->ajax()){
            $searchData = $request->name;
            $data =  Township::
                            where(function($query) use($searchData){
                                $query->where('name', 'like', '%'.$searchData.'%');
                               
                            })->get();
                          
                            
            return response()->json($data,200);
        }
    }
}
