<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomepageController@displayHomepage');


//POST
Route::post('/confirmSupplier', 'SupplierController@confirmSupplier');

Route::post('/confirmCategory', 'CategoryController@confirmCategory');

Route::post('/confirmSubCategory', 'SubCategoryController@confirmSubCategory');

Route::post('/confirmDelivery3rdParty', 'Delivery3rdPartyController@confirmDelivery3rdParty');

Route::post('/confirmAccountType', 'AccountTypeController@confirmAccountType');

Route::post('/confirmKeyword', 'KeywordController@confirmKeyword');

Route::post('/confirmItem', 'ItemController@confirmItem');

Route::post('/confirmProvince', 'ProvinceController@confirmProvince');

Route::post('/confirmCity', 'CityController@confirmCity');

Route::post('/confirmShipment', 'ShipmentController@confirmShipment');

Route::post('/confirmWarehouse', 'WarehouseController@confirmWarehouse');

Route::post('/confirmInventory', 'InventoryController@confirmItem');

Route::post('/confirmDiscount', 'DiscountController@confirmDiscount');

Route::post('/confirmRegister', 'RegisterController@confirmRegister');

Route::post('/updateReward', 'DiscountController@updateReward');

Route::post('/updateShipment', 'ShipmentController@updateShipment');

Route::post('/updateShipmentFee', 'ShipmentController@updateShipmentFee');

Route::post('/insertAccount', 'RegisterController@insertRegister');

Route::post('/loginAccount', 'LoginController@login');

Route::post('/addContainer', 'OrderedController@addContainer');

Route::post('/addItemToContainer', 'ContainerController@addItemToContainer');

Route::post('/itemDelivered', 'ItemInboundController@itemDelivered');

Route::post('/itemMoveRequest', 'MovingController@itemMoveRequest');

Route::post('/approveMovingOfItems', 'MovingController@approveMovingOfItems');

Route::post('/addBiddingEvent', 'BiddingEventController@addBiddingEvent');

Route::get('/logout', 'LoginController@logout');


//GET
Route::get('/supplier', 'SupplierController@manageSupplier');

Route::get('/category', 'CategoryController@manageCategory');

Route::get('/subcategory', 'SubCategoryController@manageSubcategory');

Route::get('/accountType', 'AccountTypeController@manageAccountType');

Route::get('/item', 'ItemController@manageItem');

Route::get('/shipment', 'ShipmentController@manageShipment');

Route::get('/registerContainer', 'RegisterContainerController@manageRegContainer');

Route::get('/places', 'ProvinceController@manageProvince');

Route::get('/inventory', 'InventoryController@manageItem');

Route::get('/discount', 'DiscountController@manageDiscount');

Route::get('/itemContainer', 'ContainerController@viewContainer');
//Route::get('/shipment', 'PageController@shipment');

//AJAX
Route::get('/cityOptions', 'AngularOutput@cityOptions');

Route::get('/subcatOptions', 'AngularOutput@subcatOptions');

Route::get('/status_Supplier', 'StatusUpdate@Supplier');

Route::get('/status_Item', 'StatusUpdate@Item');

Route::get('/status_AccountType', 'StatusUpdate@AccountType');

Route::get('/status_Category', 'StatusUpdate@Category');

Route::get('/status_SubCategory', 'StatusUpdate@SubCategory');

Route::get('/status_Warehouse', 'StatusUpdate@Warehouse');

Route::get('/warehouse', 'WarehouseController@manageWarehouse');

Route::get('/category', 'CategoryController@manageCategory');

Route::get('/bidEvent', 'PageController@bidEvent');

Route::get('/register', 'PageController@register');

Route::get('/customer/checkout', 'PageController@checkout');

Route::get('/customer/items', 'PageController@custItems');

Route::get('/bidItems', 'BiddingEventController@viewEventItems');

//Route::get('/customer/cart', 'PageController@cart');

Route::get('/customer/items/auction', 'PageController@auction');

Route::get('/admin', 'PageController@admin');


//Angular AngularOutput
Route::get('/provinces', 'AngularOutput@provinces');

Route::get('/accounttypes', 'AngularOutput@accounttypes');

Route::get('/suppliers', 'AngularOutput@suppliers');

Route::get('/itemModels', 'AngularOutput@itemModels');

Route::get('/warehouses', 'AngularOutput@warehouses');

Route::get('/itemsInContainer', 'AngularOutput@itemsInContainer');

Route::get('/containers', 'AngularOutput@containers');

Route::get('/singleItem', 'AngularOutput@singleItem');

Route::get('/itemsInbound', 'AngularOutput@itemsInbound');

Route::get('/itemsInventory', 'AngularOutput@itemsInventory');

Route::get('/itemsMoveSelect', 'AngularOutput@itemsMoveSelect');

Route::get('/itemsMoveApproval', 'AngularOutput@itemsMoveApproval');

Route::get('/itemmodelsInventory', 'AngularOutput@itemmodelsInventory');

Route::get('/itemsOfModelInventory', 'AngularOutput@itemsOfModelInventory');

Route::get('/categories', 'AngularOutput@categories');

//

Route::get('/eventList', 'BiddingEventController@eventList');

Route::get('/getEventItems', 'BiddingEventController@getEventItems');


//Angular Input

Route::get('/disposeItem', 'AngularInput@disposeItem');

Route::get('/cancelDisposeItem', 'AngularInput@cancelDisposeItem');

Route::get('/confirmDispose', 'AngularInput@confirmDispose');

//

Route::get('/eventDetails', 'BiddingEventController@eventDetails');

Route::get('/addItemToAuction', 'BiddingEventController@addItemToAuction');

Route::get('/itemsToAddToEvent', 'BiddingEventController@itemsToAddToEvent');

Route::get('/removeFromEvent', 'BiddingEventController@removeFromEvent');



Route::post('/edit', 'ShipmentController@editShipment');

Route::get('/add', 'ShipmentController@addShipment');

Route::get('/accounts', 'PageController@manageAccounts');

Route::get('/tryLoad', 'SupplierController@tryLoad');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


// new mainte
Route::get('/dashboard', 'PageController@dashboard');

Route::get('/discount1', 'PageController@discount1');

//Route::get('/shipment1', 'PageController@shipment1');

Route::get('/warehouse1', 'PageController@warehouse1');

//Route::get('/inventory1', 'PageController@inventory1');

Route::get('/biddingEvent', 'PageController@bidEvent1');

Route::get('/orderedItem', 'PageController@orderedItem');

Route::get('/itemInbound', 'PageController@itemInbound');

Route::get('/movingOfItems', 'PageController@movingItems');

Route::get('/approvalOfMovingItems', 'PageController@approvalOfMovingItems');

Route::get('/accountApproval', 'PageController@accountApproval');

Route::get('/itemPullouts', 'PageController@itemPullouts');



Route::group(['middleware' => ['web']], function () {
    //
});



Route::group(['middleware' => 'customer'], function () {
    Route::get('/customer/cart', 'PageController@cart');
});

Route::get('/customer/bidList', 'PageController@bidList');

Route::get('/angulardt', function(){
	return view('admin1.angulardt');
});