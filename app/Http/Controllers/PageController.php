<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Business\MemberBusiness;
use App\Dal\MemberDao;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Admin;


class PageController extends Controller
{

    public function homepage(Request $request){

       return view('customer.homepage');
    }

    public function bidItems(Request $request){

       return view('admin.bidItems');
    }

    public function shipmentAdd(Request $request){

       return view('shipmentAdd');
    }

    public function shipmentEdit(Request $request){

       return view('shipmentEdit');
    }

    public function warehouse(Request $request){

       return view('warehouse');
    }

    public function shipment(Request $request){

       return view('shipment');
    }

    public function checkout(Request $request){

       return view('customer.checkout');
    }

    public function bidEvent(Request $request){

       return view('admin.bidEvent');
    } 

    public function inventory(Request $request){

       return view('admin.inventory');
    }

    public function admin(Request $request){

       return view('admin.admin');
    }

    public function discount(Request $request){

       return view('admin.discount');
    }

    //customer

    public function register(Request $request){

       return view('customer.register');
    } 

    public function custItems(Request $request){

       return view('customer.items');
    }

    public function auction(Request $request){

       return view('customer.auction');
    }

    public function cart(Request $request){

       return view('customer.cart');
    }


    //New Mainte

    public function dashboard(Request $request){

       return view('admin1.dashboard');
    } 

 /*   public function supplier1(Request $request){

       return view('admin1.supplier');
    } */

    public function category1(Request $request){

       return view('admin1.category');
    } 

    public function item1(Request $request){

       return view('admin1.item');
    }

    public function accountType1(Request $request){

       return view('admin1.accountType');
    } 

    public function discount1(Request $request){

       return view('admin1.discount');
    }

    public function shipment1(Request $request){

       return view('admin1.shipment');
    }

    public function warehouse1(Request $request){

       return view('admin1.warehouse');
    }

    public function inventory1(Request $request){

       return view('admin1.inventory');
    }

    public function orderedItem(Request $request){

       return view('admin1.Transaction.orderedItem');
    }

    public function itemContainer(Request $request){

       return view('admin1.Transaction.itemContainer');
    }

    public function accountApproval(Request $request){

       return view('admin1.Transaction.accountApproval');
    }

    public function itemPullouts(Request $request){

       return view('admin1.Transaction.itemPullouts');
    }

    public function bidEvent1(Request $request){

       return view('admin1.Transaction.bidEvent');
    }

    public function movingItems(Request $request){

       return view('admin1.Transaction.movingOfItems');
    } 

    public function approvalOfMovingItems(Request $request){

       return view('admin1.Transaction.approvalOfMovingItems');
    } 

    public function bidItems1(Request $request){

       return view('admin1.bidItems');
    }

    public function bidList(Request $request){

       return view('customer.bidList');
    }

    public function eventsList(Request $request){
      return view('customer.eventsList');
    }

    public function userProfile(Request $request){

       return view('customer.userProfile');
    }

    public function bidHistory(Request $request){

       return view('customer.bidHistory');
    }

    public function deliveryStatus(Request $request){

       return view('customer.deliveryStatus');
    }

    public function listOfBidders(Request $request){

       return view('admin1.Queries.listOfBidders');
    }

    public function itemChecking(Request $request){

       return view('admin1.Transaction.itemChecking');
    }

    public function itemOutbound(Request $request){

       return view('admin1.Transaction.itemOutbound');
    }

    public function prepareCheckout(Request $request){

       return view('admin1.Transaction.prepareCheckout');
    }

    public function paymentCheckout(Request $request){

       return view('admin1.Transaction.paymentCheckout');
    }

    public function expectedItemPercent(Request $request){

      return view('admin1.expectedItemPercent');
    }
}



