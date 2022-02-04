<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $deposits = Deposit::where('shopper_id', $id)
                            ->get();
        return view('deposit.index', compact('deposits','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('deposit.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'amount' => 'required',
           
        ]);
        $deposit = new Deposit;
        $deposit->date = $request->input('date');
        $deposit->remark = $request->input('remark');
        $deposit->amount = $request->input('amount');
        $deposit->shopper_id = $id;
        $deposit->save();
        $deposits = Deposit::where('shopper_id', $id)
                            ->get();
        return view('deposit.index', compact('deposits','id'));
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
    public function edit($shopper_id, $deposit_id)
    {
        $deposit = Deposit::find($deposit_id);
        return view('deposit.edit', compact('deposit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $deposit_id)
    {
        $deposit = Deposit::find($deposit_id);
        $deposit->date = $request->input('date');
        $deposit->amount = $request->input('amount');
        $deposit->remark = $request->input('remark');
        $deposit->shopper_id = $id;
        $deposit->save();
        $deposits = Deposit::where('shopper_id', $id)
                            ->get();
        return redirect('shoppers/'.$id.'/deposit-list')->with('successAlert','You Have Successfully Updated!');
        // return view('deposit.index',compact('id','deposits'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sid,$did)
    {
       Deposit::find($did)->delete();
        return redirect('shoppers/'.$sid.'/deposit-list')->with('successAlert','You Have Successfully Deleted');
    }
}
