<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\UserPreference;

class UserPreferenceController extends Controller
{

    public function store($id, Request $request){

    	$user = User::with('preference')->findOrFail($id);

    	$validated = Validator::make($request->all(), [
    		'price_from' => 'nullable|numeric',
    		'price_to' => 'nullable|numeric',
    		'price_per_square_from' => 'nullable|filled|integer',
    		'price_per_square_to' => 'nullable|filled|numeric',
    		'space_from' => 'nullable|integer',
    		'space_to' => 'nullable|integer',
    		'cities' => 'nullable|array',
    		'cities.*' => 'present|integer',
    		'region' => 'nulalble|array',
    		'region.*' => 'present|integer',
    		'build_type' => 'nullable|array',
    		'build_type.*' => 'present|integer',
    		'building_type' => 'nullable|array',
    		'building_type.*' => 'present|integer',
    		'keywords' => 'nullable|array',
    		'keywords.*' => 'present|string',
    	])->validate();

    	$preference = $user->preference?:new UserPreference;

    	if(isset($validated['price_from']))
	    	$preference->price_from = $validated['price_from'];
	    if(isset($validated['price_to']))
	    	$preference->price_to = $validated['price_to'];
    	if(isset($validated['price_per_square_from']))
	    	$preference->price_per_square_from = $validated['price_per_square_from'];
	    if(isset($validated['price_per_square_to']))
	    	$preference->price_per_square_to = $validated['price_per_square_to'];
	    if(isset($validated['space_from']))
	    	$preference->space_from = $validated['space_from'];
	    if(isset($validated['space_to']))
	    	$preference->space_to = $validated['space_to'];
	    if(isset($validated['cities']))
	    	$preference->cities = $validated['cities'];
	    if(isset($validated['region']))
	    	$preference->region = $validated['region'];
	    if(isset($validated['build_type']))
	    	$preference->build_type = $validated['build_type'];
	    if(isset($validated['building_type']))
	    	$preference->building_type = $validated['building_type'];
	    if(isset($validated['keywords']))
	    	$preference->keywords = $validated['keywords'];

    	if($preference->isDirty())
	    	$user->preference()->save($preference);

        return response()->json($user);
    }

}
