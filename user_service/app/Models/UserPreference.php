<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'api_token', 'password'
    ];


    /**
     * Get the asssociated user 
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    public function user(){
        return $this->belongsTo(App\Models\User::class);
    }
}
