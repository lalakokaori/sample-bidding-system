<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class AccountType extends Model
{
    use SoftDeletes;

    protected $table = 'AccountType';
    protected $primaryKey = 'AccountTypeID';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function discount()
	{
	    return $this->hasMany('App\Models\Admin\Discount', 'DiscountID');
	}
}
