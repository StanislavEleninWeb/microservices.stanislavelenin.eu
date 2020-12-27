<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\UserPreference;

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

    /**
     * Create a new controller instance.
     *
     * @return App\Models\User
     */
    public function usersByPreference(Request $request)
    {
        // $usr = User::orderBy('id');
        $user = User::find(1);
        // dd($user);
        dd($user->preference);
        $usr->whereHas('preferences', function($query) use ($request){
            return $query->where('price_from', '<=', $request->price);
        });
        return $usr->get();
        $users = UserPreference::orderBy('user_id', 'DESC');

        return $users->get()->pluck('user');

        // Price
        if(isset($request->price) && is_numeric($request->price)) {
            $user->where('price_from', '>=', $request->price);
            $user->where('price_to', '<=', $request->price);
        }

        // Price pre square
        if(isset($request->price_per_square) && is_numeric($request->price_per_square)) {
            $user->where('price_per_square_from', '>=', $request->price_per_square);
            $user->where('price_per_square_to', '<=', $request->price_per_square);
        }

        // Space
        if(isset($request->space) && is_numeric($request->space)) {
            $user->where('space_from', '>=', $request->space);
            $user->where('space_to', '<=', $request->space);
        }

        // Building Type
        if(isset($request->building_type) && is_numeric($request->building_type))
            $user->whereJsonContains('building_type_id', $request->building_type);

        // Build Type
        if(isset($request->build_type) && is_numeric($request->build_type))
            $user->whereJsonContains('build_type_id', $request->build_type);

        // Region
        if(isset($request->region) && is_numeric($request->region))
            $user->whereJsonContains('region_id', $request->region);

        // Keywords
        if(isset($request->keywords) && !empty($request->keywords))
            $user->whereJsonContains('keywords', $request->keywords);

        return response()->json($users->get());
    }

    /**
     * Create a new controller instance.
     *
     * @return App\Models\User
     */
    public function usersByRole(Request $request)
    {
        $role = Role::where('name', trim($request->role))->get();

        $users = User::role($role)->get();

        return response()->json($users);
    }

}
