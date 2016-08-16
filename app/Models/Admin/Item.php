<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';
    protected $primaryKey = 'ItemID';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function itemModel()
	{
	    return $this->hasOne('App\Models\Admin\itemModel', 'ItemModelID', 'ItemModelID');
	}

	public function itemHistory()
	{
	    return $this->hasMany('App\Models\Admin\ItemHistory', 'ItemID', 'ItemID');
	}

	public function pullRequest()
	{
	    return $this->hasMany('App\Models\Admin\PullRequest', 'ItemID', 'ItemID');
	}

	public function supplier()
	{
	    return $this->hasOne('App\Models\Admin\Supplier', 'SupplierID', 'SupplierID');
	}

	public function container()
	{
	    return $this->hasOne('App\Models\Admin\Container', 'ContainerID', 'ContainerID');
	}

	public function current_warehouse()
	{
	    return $this->hasOne('App\Models\Admin\Warehouse', 'WarehouseNo', 'CurrentWarehouse');
	}

	public function requested_warehouse()
	{
	    return $this->hasOne('App\Models\Admin\Warehouse', 'WarehouseNo', 'RequestedWarehouse');
	}

	public function item_auction()
	{
	    return $this->hasMany('App\Models\Admin\Item_Auction', 'ItemID', 'ItemID');
	}

	public function bids()
	{
	    return $this->hasMany('App\Models\Admin\Bid', 'ItemID', 'ItemID');
	}

	public function winners()
	{
	    return $this->hasMany('App\Models\Admin\Winner', 'ItemID', 'ItemID');
	}

	public function checkoutRequest_item()
	{
	    return $this->hasMany('App\Models\Admin\CheckoutRequest_Item', 'ItemID', 'ItemID');
	}
}
