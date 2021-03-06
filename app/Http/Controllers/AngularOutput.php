<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Business\SupplierBusiness;
use App\Dal\SupplierDao;
use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use App\Models\Admin;
use Session;
use Input;
use Response;
use Carbon\Carbon;


class AngularOutput extends Controller
{
    public function colors(){
        $colors = App\Models\Admin\Color::all();

        return $colors;
    }

    public function suppliers(){
        $suppliers = App\Models\Admin\Supplier::all();
        return $suppliers;
    }

    public function problemTypesList(){
        $problemTypes = App\Models\Admin\ProblemType::all();
        return $problemTypes;
    }

    public function itemModels(){
        $itemModels = App\Models\Admin\ItemModel::all();
        return $itemModels;
    }

    public function itemModelsOfSubcat(Request $request){
        $itemModels = App\Models\Admin\ItemModel::where('SubCategoryID', $request->subcatID)->get();
        return $itemModels;
    }

    public function itemModelsWithItems(){
        $itemModels = App\Models\Admin\ItemModel::with('items')->get();
        return $itemModels;
    }

    public function singleItem(Request $request){
        $item =  App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.Supplier', 'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province', 'itemHistory', 'pullRequest', 'itemDefect')
            ->where('ItemID', $request->itemID)->first();

        return $item;
    }

    public function itemsInContainer(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province')
            ->where('ContainerID', $request->containerID)->get();

        return $items;
    }

    public function itemsInbound(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province')
            ->where('status', 0)->whereHas('container', function($query){
                $query->whereNotNull('ActualArrival');
            })->get();

        return $items;
    }

    public function itemsMissing(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province')
            ->where('status', -1)->whereHas('container', function($query){
                $query->whereNotNull('ActualArrival');
            })->get();

        return $items;
    }

    public function unexpectedItems(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province')
            ->where('Unexpected', 1)->get();
 
        return $items;
    }

    public function itemsChecking(Request $request){
         $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category',
            'container', 'current_warehouse', 'current_warehouse.city', 'current_warehouse.city.province')->where('status', 1)->get();

        return $items;
    }

    public function itemsChecked(Request $request){
         $items = App\Models\Admin\Item::with('itemModel', 'container', 'container.warehouse.city',
            'container.warehouse.city.province', 'current_warehouse', 'current_warehouse.city', 'current_warehouse.city.province', 'itemDefect')->where('status', 2)->get();

        return $items;
    }

    public function itemsInventory(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.Supplier', 'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province', 'itemHistory',
            'pullRequest', 'itemDefect')->where('DefectDescription', '!=', '')->where('image_path', '!=', '')
            ->where('status', 1)->orWhere('status', 2)
            ->whereHas('pullRequest', function($query){}, '=', 0)
            ->get();

        return $items;
    }

    public function requestedToDispose(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.Supplier', 'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province', 'itemHistory',
            'pullRequest', 'itemDefect')->where('DefectDescription', '!=', '')->where('image_path', '!=', '')
            ->where('status', 1)->orWhere('status', 2)
            ->whereHas('pullRequest', function($query){}, '>', 0)
            ->get();

        return $items;
    }

    public function itemsOfModelInventory(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.Supplier', 'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province', 'itemHistory',
            'pullRequest', 'itemDefect')
            ->where('status', 2)
            ->where('ItemModelID', $request->itemID)
            ->get();

        return $items;
    }

    public function itemmodelsInventory(Request $request){
        $itemModels = App\Models\Admin\ItemModel::with('subCategory', 'subCategory.category', 'items', 'items.container', 
            'items.container.Supplier', 'items.container.warehouse', 'items.container.warehouse.city', 'items.container.warehouse.city.province', 'items.itemHistory',
            'items.pullRequest', 'items.itemDefect')->get();
        $returnData = [];

        foreach ($itemModels as $key => $itemModel) {
            $items = App\Models\Admin\Item::where('ItemModelID', $itemModel->ItemModelID)->where('status', 2)->get();

            //remove will pull request
            foreach ($items as $key => $item) {
                if(count($item->pullRequest) > 0){
                    $items->splice($key, 1);
                }
            }

            $itemModel->stocksCount = $items->count();
            array_push($returnData, $itemModel);
        }

        return $returnData;

    }



    public function itemsMoveSelect(Request $request){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'container', 
            'container.Supplier', 'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province', 'current_warehouse', 
            'current_warehouse.city', 'current_warehouse.city.province')
            ->where('CurrentWarehouse', $request->warehouseFrom)
            ->where('CurrentWarehouse', '!=', $request->warehouseTo)
            ->where('status', 2)
            ->where('RequestedWarehouse', null)->get();

        return $items;
    }

    public function itemsMoveApprovalRequests(Request $request){
        $requests = App\Models\Admin\MovingRequest::with('item_movingRequest.item.itemModel', 'item_movingRequest.item.itemModel.subCategory', 'item_movingRequest.item.itemModel.subCategory.category', 'item_movingRequest.item.container', 
            'item_movingRequest.item.container.Supplier', 'item_movingRequest.item.container.warehouse', 'item_movingRequest.item.container.warehouse.city', 'item_movingRequest.item.container.warehouse.city.province', 'item_movingRequest.item.current_warehouse', 
            'item_movingRequest.item.current_warehouse.city', 'item_movingRequest.item.current_warehouse.city.province', 'item_movingRequest.item.requested_warehouse', 'item_movingRequest.item.requested_warehouse.city', 'item_movingRequest.item.requested_warehouse.city.province')
            ->where('Status', 0)
            ->get();

        $returnData = $requests;

        //remove received items
        foreach($requests as $key => $request){
            $removed = 0;
            foreach($request->item_movingRequest as $key2 => $item_request){
                if($item_request->item->RequestedWarehouse == null){
                    $returnData[$key]->item_movingRequest->splice($key2-$removed, 1);
                    $removed++;
                }
            }
        }

        return $returnData;
    }

    public function allContainers(){

        $containers = App\Models\Admin\Container::orderBy('ActualArrival', 'asc')
        ->orderBy('Arrival', 'desc')
        ->with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province')
        ->get();

        return $containers;
    }

    public function containers(){

        $containers = App\Models\Admin\Container::with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province')
        ->where('ActualArrival', '!=', 'null')
        ->get();

        return $containers;
    }

    public function containersWithPendingItems(){

        $containers = App\Models\Admin\Container::with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province', 'item', 'item.itemModel.subCategory', 'item.itemModel.subCategory.category')
        ->where('ActualArrival', '!=', 'null')->whereHas('item', function($query){
            $query->where('status', 0);
        })
        ->get();

        return $containers;
    }

    public function containersWithUnexpectedItems(){

        $containers = App\Models\Admin\Container::with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province', 'item', 'item.itemModel.subCategory', 'item.itemModel.subCategory.category')
        ->where('ActualArrival', '!=', 'null')->whereHas('item', function($query){
            $query->where('status', 1)->where('Unexpected', 1);
        })
        ->get();

        return $containers;
    }

    public function containersWithMissing(){

        $containers = App\Models\Admin\Container::with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province', 'item', 'item.itemModel.subCategory', 'item.itemModel.subCategory.category')
        ->where('ActualArrival', '!=', 'null')->whereHas('item', function($query){
            $query->where('status', -1);
        })
        ->get();

        return $containers;
    }

    public function warehouses(){
        $warehouses = App\Models\Admin\Warehouse::with('city', 'city.province')->get();
        return $warehouses;
    }

    public function cityOptions(){
        $provID = Input::get('provID');
        $cities = App\Models\Admin\City::where('ProvinceID', $provID)->get();

        return \Response::json($cities);
    }

    public function categories(){
        $categories = App\Models\Admin\Category::with('subCategory')->get();

        return $categories;
    }

    public function subcatOptions(){
        $catID = Input::get('catID');
        $subCategories = App\Models\Admin\SubCategory::where('CategoryID', $catID)->get();

        return \Response::json($subCategories);
    }

    public function provinces(){
        $provinces = App\Models\Admin\Province::orderBy('ProvinceName')->get();
        return $provinces;
    }

    public function accountTypes(){
        $accountTypes = App\Models\Admin\AccountType::all();
        return $accountTypes;
    }

    public function currentTime(){
        return Carbon::now('Asia/Manila');
    }

    public function accountsList(){
        $accounts = App\Models\Admin\Account::with('membership', 'membership.accounttype', 'membership.city', 'membership.city.province')->get();

        return $accounts;
    }

    public function shipmentFee(Request $request){
        $shipment = App\Models\Admin\Shipment::find($request->provinceID);

        return $shipment;
    }

    public function salesGraph(){
        $items = App\Models\Admin\Item::with('itemModel', 'itemModel.subCategory', 'itemModel.subCategory.category', 'item_auction',
            'item_auction.auction.AuctionID', 'item_auction.auction.EndDateTime', 'item_auction.ItemID', 'item_auction.Points')
            ->where('status', 3)->whereHas('container', function($query){
                $query->whereNotNull('ActualArrival');
            })->get();
    }

    public function accountInfo(Request $request){
        $account = App\Models\Admin\Account::with('membership')->where('AccountID', $request->session()->get('accountID'))->first();

        return $account;
    }

    public function deliverComList(){
        $shipment = App\Models\Admin\Shipment::with('province')->where('CompanyCourier', 1)->get();

        return $shipment;
    }

    public function deliverList(){
        $shipment = App\Models\Admin\Shipment::with('province')->where('CompanyCourier', 0)->get();

        return $shipment;
    }

    public function customerStat(){
        $customer = App\Models\Admin\Account::with('membership')->orderBy('DateApproved')->get();

        return $customer;
    }

    public function supplierStat(){
        $supplier = App\Models\Admin\Supplier::get();
        $item = App\Models\Admin\Item::with('itemModel', 'container', 'container.supplier', 'supplier')->where('status', 1)
        ->orWhere('status', 2)->orWhere('status', -1)->orWhere('status', -2)->get();
        $returnData = NULL;
        $previtem = NULL;
        $holditem = NULL;
        $ctr = 0;
        $ctr2 = 0;

        foreach ($supplier as $key => $result) {
            $a = count($item);
            for ($i=0; $i < $a; $i++) { 
                if($item[$i]->container->supplier->SupplierID==$result->SupplierID){
                    if(!isset($returnData[$ctr])){
                        $returnData[$ctr]["SupplierName"] = $result->SupplierName;
                        $returnData[$ctr]["Status"] = $result->Status;
                        if($item[$i]->status==1){
                            $returnData[$ctr]["Items"] = $item[$i]->itemModel->ItemName;
                            $returnData[$ctr]["Found"] = 1;
                            $returnData[$ctr]["Missing"] = 0;
                        }
                        if($item[$i]->status==2){
                            $returnData[$ctr]["Items"] = $item[$i]->itemModel->ItemName;
                            $returnData[$ctr]["Found"] = 1;
                            $returnData[$ctr]["Missing"] = 0;
                        }
                        if($item[$i]->status==-1){
                            $returnData[$ctr]["Found"] = 0;
                            $returnData[$ctr]["Missing"] = 1;
                        }
                        if($item[$i]->status==-2){
                            $returnData[$ctr]["Found"] = 0;
                            $returnData[$ctr]["Missing"] = 1;
                        }
                        $previtem[0][$ctr2] = $item[$i]->itemModel->ItemName;
                        $ctr2++;
                    } else{
                        $j = count($previtem[0]);
                        for($k=0; $k<$j; $k++){
                            if($previtem[0][$k]==$item[$i]->itemModel->ItemName){
                                if($item[$i]->status==1){
                                    $returnData[$ctr]["Found"]++;
                                }
                                if($item[$i]->status==2){
                                    $returnData[$ctr]["Found"]++;
                                }
                                if($item[$i]->status==-1){
                                    $returnData[$ctr]["Missing"]++;
                                }
                                if($item[$i]->status==-2){
                                    $returnData[$ctr]["Missing"]++;
                                }
                                break;
                            }
                            if($k+1==$j){
                                if($item[$i]->status==1){
                                    $returnData[$ctr]["Found"]++;
                                    $previtem[0][$ctr2] = $item[$i]->itemModel->ItemName;
                                    $holditem[0] = $item[$i]->itemModel->ItemName.", ".$returnData[$ctr]["Items"];
                                    $returnData[$ctr]["Items"] = $holditem[0];
                                }
                                if($item[$i]->status==2){
                                    $returnData[$ctr]["Found"]++;
                                    $previtem[0][$ctr2] = $item[$i]->itemModel->ItemName;
                                    $holditem[0] = $item[$i]->itemModel->ItemName.", ".$returnData[$ctr]["Items"];
                                    $returnData[$ctr]["Items"] = $holditem[0];
                                }
                                if($item[$i]->status==-1){
                                    $returnData[$ctr]["Missing"]++;
                                    $previtem[0][$ctr2] = $item[$i]->itemModel->ItemName;
                                    $holditem[0] = $item[$i]->itemModel->ItemName.", ".$returnData[$ctr]["Items"];
                                    $returnData[$ctr]["Items"] = $holditem[0];
                                }
                                if($item[$i]->status==-2){
                                    $returnData[$ctr]["Missing"]++;
                                    $previtem[0][$ctr2] = $item[$i]->itemModel->ItemName;
                                    $holditem[0] = $item[$i]->itemModel->ItemName.", ".$returnData[$ctr]["Items"];
                                    $returnData[$ctr]["Items"] = $holditem[0];
                                }
                                $ctr2++;
                            }
                        }
                    }
                }
            }
            $ctr++;
            $ctr2 = 0;
            $previtem[0] = NULL;
        }

        $ctr = 0;
        foreach ($supplier as $key => $result) {
            $i = count($returnData);
            for ($j=0; $j < $i; $j++) { 
                if($returnData[$j]["SupplierName"]==$result->SupplierName){
                    $ctr++;
                    break;
                }
                if($j+1==$i){
                    $returnData[$ctr]["SupplierName"] = $result->SupplierName;
                    $returnData[$ctr]["Status"] = $result->Status;
                    $ctr++;
                }
            }
        }

        return $returnData;
    }

    //mainte data
    public function mainte_Warehouses(){
        $warehouses = App\Models\Admin\Warehouse::with('city', 'city.province')
        ->where('Status', 1)->get();
        return $warehouses;
    }

    public function mainte_Suppliers(){
        $suppliers = App\Models\Admin\Supplier::where('Status', 1)->get();
        return $suppliers;
    }

    public function mainte_Categories(){
        $categories = App\Models\Admin\Category::with('subCategory')->where('Status', 1)->get();

        return $categories;
    }

    public function mainte_SubcatOptions(){
        $catID = Input::get('catID');
        $subCategories = App\Models\Admin\SubCategory::where('CategoryID', $catID)->where('Status', 1)->get();

        return \Response::json($subCategories);
    }

    public function mainte_ItemModelsOfSubcat(Request $request){
        $itemModels = App\Models\Admin\ItemModel::where('SubCategoryID', $request->subcatID)->where('Status', 1)->get();
        return $itemModels;
    }

    public function mainte_ProblemTypesList(){
        $problemTypes = App\Models\Admin\ProblemType::all();
        return $problemTypes;
    }

    public function pendingCustomer(){
        $customer = App\Models\Admin\Account::with('membership')->where('Status', 0)->get();

        return $customer;
    }

    public function pendingContainer(){

        $containers = App\Models\Admin\Container::where('ActualArrival', NULL)->orderBy('ActualArrival', 'asc')
        ->orderBy('Arrival', 'desc')
        ->with('Supplier', 'warehouse', 'warehouse.city', 'warehouse.city.province')
        ->get();

        return $containers;
    }

    public function pendingCheckout(){
        $checkoutRequest = App\Models\Admin\CheckoutRequest::with('account')
            ->where('Status', 0)->get();

        return $checkoutRequest;
    }

    public function pendingItems(){
        $items = App\Models\Admin\Item::with('itemModel', 'container', 
            'container.warehouse', 'container.warehouse.city', 'container.warehouse.city.province')
            ->where('Status', 0)->get();

        return $items;
    }

    public function accountDetails(Request $request){
        $returnData = collect();

        $account = App\Models\Admin\Account::find($request->session()->get('accountID'));

        $bids = App\Models\Admin\Bid::where('AccountID', $request->session()->get('accountID'))->get();

        $itemBids = $bids->groupBy('ItemID');

        //
        $itemWon = 0;
        $allBids = App\Models\Admin\Bid::all();
        $allBids = $allBids->groupBy('ItemID');
        foreach ($allBids as $key => $allBid) {
            if($allBid->last()->AccountID == $request->session()->get('accountID')){
                $itemWon++;
            }
        }

        $nextDiscountGoal = NULL;
        $allDiscounts = App\Models\Admin\Discount::where('AccountTypeID', $account->membership->first()
                ->AccountTypeID)->orderBy('RequiredPoints', 'asc')->get();
        foreach ($allDiscounts as $key => $allDiscount) {
            if($allDiscount->RequiredPoints <= $account->Points){
                if($key+1 < count($allDiscounts)){
                    $nextDiscountGoal = $allDiscounts[$key+1];
                }
            }
        }

        $returnData->put('points', $account->Points);
        $returnData->put('discount', $this->customerDiscount($request->session()->get('accountID')));
        $returnData->put('totalBids', count($bids));
        $returnData->put('itemBids', count($itemBids));
        $returnData->put('itemWon', $itemWon);
        $returnData->put('nextDiscountGoal', $nextDiscountGoal);

        return $returnData;
    }
}
