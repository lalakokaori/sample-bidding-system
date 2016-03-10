<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Business\SupplierBusiness;
use App\Dal\SupplierDao;
use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use Session;
use Input;
use Response;

class StatusUpdate extends Controller
{
    public function Supplier(){
        $supplier = new App\Supplier;
        $supplier = App\Supplier::find(Input::get('supplierID'));

        if ($supplier->Status == 1){
            $supplier->Status = 0;
        }
        elseif ($supplier->Status == 0){
            $supplier->Status = 1;
        }
        $supplier->save();
    }

    public function Item(){
        $item = new App\Item;
        $item = App\Item::find(Input::get('itemID'));

        if ($item->Status == 1){
            $item->Status = 0;
        }
        elseif ($item->Status == 0){
            $item->Status = 1;
        }
        $item->save();
    }

    public function AccountType(){
        $accountType = new App\AccountType;
        $accountType = App\AccountType::find(Input::get('accounttypeID'));

        if ($accountType->Status == 1){
            $accountType->Status = 0;
        }
        elseif ($accountType->Status == 0){
            $accountType->Status = 1;
        }
        $accountType->save();
    }
}
