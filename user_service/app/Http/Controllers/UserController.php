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

    public function destroy($id){
        User::destroy($id);

        return response();
    }

    /**
     * Filter user by preference
     *
     * @return App\Models\User
     */
    public function usersByPreference(Request $request)
    {
        $users = User::orderBy('id');
        
        $users->whereHas('preference', function($query) use ($request){

            // Price
            if(isset($request->price) && is_numeric($request->price)) {
                $query->where(function($sub_query) use ($request){
                    return $sub_query->where('price_from', '<=', $request->price)->orWhereNull('price_from');
                });
                $query->where(function($sub_query) use ($request){
                    return $sub_query->where('price_to', '>=', $request->price)->orWhereNull('price_to');
                });
            }

            // Price per square
            if(isset($request->price_per_square) && is_numeric($request->price_per_square)) {
                $query->where(function($sub_query) use ($request){
                    return $sub_query->where('price_per_square_from', '<=', $request->price_per_square)->orWhereNull('price_per_square_from');
                });
                $query->where(function($sub_query) use ($request){
                    $sub_query->where('price_per_square_to', '>=', $request->price_per_square)->orWhereNull('price_per_square_to');
                });
            }

            // Space
            if(isset($request->space) && is_numeric($request->space)) {
                $query->where(function($sub_query) use ($request){ 
                    return $sub_query->where('space_from', '<=', $request->space)->orWhereNull('space_from');
                });
                $query->where(function($sub_query) use ($request){
                    return $sub_query->where('space_to', '>=', $request->space)->orWhereNull('space_to');
                });
            }

            // Building Type
            if(isset($request->building_type) && is_numeric($request->building_type))
                $query->where(function($sub_query) use ($request){
                    return $sub_query->whereJsonContains('building_type', $request->building_type)->orWhereNull('building_type');
                });

            // Build Type
            if(isset($request->build_type) && is_numeric($request->build_type)){
                $query->where(function($sub_query) use ($request){
                    return $sub_query->whereJsonContains('build_type', $request->build_type)->orWhereNull('build_type');
                });
            }

            // Region
            if(isset($request->region) && is_numeric($request->region)){
                $query->where(function($sub_query) use ($request){ 
                    return $sub_query->whereJsonContains('region', $request->region)->orWhereNull('region');
                });
            }

            // Keywords
            if(isset($request->keywords) && !empty($request->keywords)){
                $query->where(function($sub_query) use ($request){
                    return $sub_query->whereJsonContains('keywords', $request->keywords)->orWhereNull('keywords');
                });
            }

            return $query;

        });

        // dd($users->toSql());

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
