<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProvinceThirdParty extends Model
{
	use SoftDeletes;

    protected $table = 'provincethirdparty';
    protected $primaryKey = 'PartyID';
    public $timestamps = false;

    public function province()
	{
	    return $this->hasOne('App\Province', 'ProvinceID', 'ProvinceID');
	}
}
