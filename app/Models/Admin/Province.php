<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'province';
    protected $primaryKey = 'ProvinceID';    
    public $timestamps = false;

    public function city()
	{
	    return $this->hasMany('App\Models\Admin\City', 'ProvinceID');
	}

	public function region()
	{
	    return $this->hasOne('App\Models\Admin\Region', 'RegionID', 'RegionID');
	}
}