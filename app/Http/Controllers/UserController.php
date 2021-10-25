<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin');
    }
    public function index()
    {
        $clients =User::all();
        return view('client.index',compact('clients'));
       
    }
}
