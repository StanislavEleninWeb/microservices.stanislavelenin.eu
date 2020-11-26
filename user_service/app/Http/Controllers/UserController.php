<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request){

        return response()->json(User::all());
    }

    public function show($id){
        return User::findOrFail($id);
    }

    public function destroy(){
        
    }
}
