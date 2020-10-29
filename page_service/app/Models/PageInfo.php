<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class PageInfo extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = 'pages_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];


    /**
     * Get the user that owns the phone.
     */
    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    /**
     * Get the user that owns the phone.
     */
    public function buildingType()
    {
        return $this->belongsTo('App\Models\BuildingType');
    }

    /**
     * Get the user that owns the phone.
     */
    public function buildType()
    {
        return $this->belongsTo('App\Models\BuildType');
    }

    /**
     * Get the user that owns the phone.
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    /**
     * Get the user that owns the phone.
     */
    public function regions()
    {
        return $this->belongsTo('App\Models\Region');
    }

}
