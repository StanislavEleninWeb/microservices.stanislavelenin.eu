<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cities' => 'array',
        'building_type' => 'array',
        'build_type' => 'array',
        'region' => 'array',
        'keywords' => 'array',
    ];

    /**
     * Get the asssociated user 
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
}
