<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'SubCategory';
    protected $primaryKey = 'SubCategoryID';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    public function category()
	{
	    return $this->hasOne('App\Models\Admin\Category', 'CategoryID', 'CategoryID');
	}
}//ALTER TABLE `category` ADD `deleted_at` DATETIME NULL DEFAULT NULL
