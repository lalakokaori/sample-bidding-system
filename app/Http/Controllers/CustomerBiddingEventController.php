<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App;
use App\Models\Admin;
use Session;
use Carbon\Carbon;

class CustomerBiddingEventController extends Controller
{
    public function eventItems(Request $request){
    	$categories = App\Models\Admin\Category::with('subCategory')->get();

        $auction = App\Models\Admin\Auction::find($request->eventID);

        $currentDatetime = Carbon::now('Asia/Manila');
        $auctionEndTime = explode(' ', $auction->EndDateTime);
        $currentDatetime = explode(' ', $currentDatetime);

        if ($currentDatetime[0] > $auctionEndTime[0] || ($currentDatetime[0] == $auctionEndTime[0] && $currentDatetime[1] > $auctionEndTime[1])){
            return "Event has ended";
        }

        $joinbid = App\Models\Admin\Joinbid::where('AuctionID', $request->eventID)->where('AccountID', $request->session()->get('accountID'))->get();

        if (count($joinbid) > 0){
            $joined = 'true';
        }
        else {
            $joined = 'false';
        }

    	return view('customer.items')->with('categories', $categories)->with('eventID', $request->eventID)->with('joined', $joined);
    }

    public function itemsOfSubcategory(Request $request){
    	$items = App\Models\Admin\Item::all();
    	$itemsOnAuction = [];
    	$returndata = [];

    	foreach ($items as $key => $item) {
    		foreach ($item->item_auction as $key => $itemauction){
    			if($itemauction->AuctionID == $request->eventID){
    				array_push($itemsOnAuction, $item);
    			}
    		}
    	}

    	foreach ($itemsOnAuction as $key => $item) {
    		if($item->itemModel->subCategory->SubCategoryID == $request->subcatID){
    			array_push($returndata, $item);
    		}
    	}

    	return $returndata;
    }

    public function joinEvent(Request $request){
        $joinbid = new App\Models\Admin\Joinbid;

        $joinbid->AccountID = $request->session()->get('accountID');
        $joinbid->AuctionID = $request->eventID;
        $joinbid->DateJoined = Carbon::now('Asia/Manila');

        $joinbid->save();

        return 'success';
    }

    public function hasJoinedThisEvent(Request $request){
        $joinbid = App\Models\Admin\Joinbid::where('AuctionID', $request->eventID)->where('AccountID', $request->session()->get('accountID'))->get();

        if (count($joinbid) > 0){
            return 'true';
        }
        else {
            return 'false';
        }
    }

    public function auction(Request $request){
        $item = App\Models\Admin\Item::with('itemModel', 'item_auction')->where('ItemID', $request->itemID)->first();

        return view('customer.auction')->with('item', $item);
    }

    public function bidItem(Request $request){
        //if bid is lower than highest bid
        $currentBids = App\Models\Admin\Bid::where('ItemID', $request->itemID)->get()->sortByDesc('price');
        $highestBid = $currentBids->first();
        $highestBid = $highestBid->price;

        if($highestBid >= $bid){
            return 'error';
        }

        //add bid
        $bid = new App\Models\Admin\Bid;

        $bid->AccountID = $request->session()->get('accountID');
        $bid->ItemID = $request->itemID;
        $bid->Price = $request->price;
        $bid->DateTime = Carbon::now('Asia/Manila');

        $bid->save();

        //make a winner
        $winner = new App\Models\Admin\Winner;
        $winner->ItemID = $request->itemID;
        $winner->AccountID = $request->session()->get('accountID');

        $item = App\Models\Admin\Item::find($request->itemID);
        $winner->AuctionID = $item->item_auction->last()->AuctionID;

        $winner->save();

        return 'success';
    }

    public function getHighestBid(Request $request){
        $bid = App\Models\Admin\Bid::with('item')->where('ItemID', $request->itemID)->get()->sortByDesc('Price')->first();

        return $bid->Price;
    }

    public function getBidHistory(Request $request){
        $bids = App\Models\Admin\Bid::with('account', 'item')->where('ItemID', $request->itemID)->get();

        return $bids;
    }

    public function bidList(Request $request){
        $bids = App\Models\Admin\Bid::where('AccountID', $request->session()->get('accountID'))->get();

        return view('customer.bidList')->with('bids', $bids);
    }
}
