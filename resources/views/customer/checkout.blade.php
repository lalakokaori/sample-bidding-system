@extends('customer.homepage')

@section('content')
	<div style="margin: 100px 0 0 0" class="ui container segment" ng-app="myApp" ng-controller="myController" 
	ng-init="customerDiscount = {{$customerDiscount}}; serviceFee = {{$serviceFee}}; account = {{$account->membership[0]}}; account.ProvinceID = {{$account->membership[0]->city->province->ProvinceID}}; 
	eventFee = {{$eventFee}}; joinBid = {{$joinBid}}">
      @include('customer.topnav')
	<form class="ui form" action="/submitCheckout" method="POST">
		<a href="/cart/"><i class="arrow left icon"></i>back to cart</a>
		<div class="ui internally celled grid container">
				<div class="ui column nine wide segment" style="margin: 5px 5px 5px 15px;">
				<h2 class="ui header">
				  <i class="shop icon"></i>
				  <div class="content">
				    Checkout
				    <div class="sub header">Re-check things that you've bid.</div>
				  </div>
				</h2>
				<div class="ui divider"></div>
				<div class="ui grid">
					<div class="row"></div>
					<div class="field">
				      <div class="ui radio checkbox">
				        <input type="radio" name="checkoutType" id="radioDelivery" ng-click="checkoutType = 'Deliver'; computePrice();" checked="checked" value="Deliver">
				        <label>Delivery</label>
				      </div>
				    </div>
				    <div class="field">
				      <div class="ui radio checkbox">
				        <input type="radio" name="checkoutType" id="radioPickup" ng-click="checkoutType = 'Pick up'; computePrice();" value="Pick up">
				        <label>Pick up</label>
				      </div>
				    </div>
				</div>
				<br>
				<div class="ui divider"></div>
				<div class="field">
					<h3 class="ui centered header">ITEM DETAILS</h3>
					    <table class="ui definition celled table" datatable="ng">
						  <thead>
						    <tr>
						    	<th></th>
							    <th>Item ID</th>
							    <th>Item Name</th>
							    <th>Date Bidded</th>
							    <th>Price</th>
							</tr>
						  </thead>
						  <tbody>
						    
					    	<tr ng-repeat="item in itemsWon">
						      <td>
						      	<input type="checkbox" class="ui checkbox" name="itemsWon[]" value="@{{$item.ItemID}}" ng-click="addToCart(item, $index)"/>
						      </td>
						      <td>@{{item.ItemID}}</td>
						      <td>@{{item.Model}}</td>
						      <td>@{{item.DateTime}}</td>
						      <td>@{{item.Price}}</td>
						    </tr>
						    
						  </tbody>
						</table>

					</div>
				  	<h4 class="ui dividing header">Delivery Information</h4>
				  	<div class="field">
					    <label>Name</label>
					    <div class="three fields">
					      <div class="field">
					        <input type="text" name="firstName" pattern="([A-z '.-]){2,}" placeholder="First Name" value="@{{account.FirstName}}">
					      </div>
					      <div class="field">
					        <input type="text" name="middleName" pattern="([A-z '.-]){2,}" placeholder="Middle Name" value="@{{account.MiddleName}}">
					      </div>
					      <div class="field">
					        <input type="text" name="lastName" pattern="([A-z '.-]){2,}" placeholder="Last Name" value="@{{account.LastName}}">
					      </div>
					    </div>
					</div>

					<div class="equal width fields" id="pickupLocation">
						<div class="field">
						 	<div class="ui sub header">Pickup Location</div>
							<select class="ui fluid search normal selection dropdown" name="warehouse" id="warehouseLocation">
								<option value="" disabled selected>Select Warehouse</option>
								<option ng-repeat="warehouse in warehouses" value="@{{warehouse.WarehouseNo}}">@{{warehouse.Barangay_Street_Address}}, @{{warehouse.city.CityName}}, @{{warehouse.city.province.ProvinceName}}</option>
							</select>
						</div>
					</div>

					<div id="deliveryAddress" class="field">
						<div class="field">
						    <label>Complete Address</label>
							<input type="text" name="address" id="address" placeholder="Complete Address..." value="@{{account.Barangay_Street_Address}}">
						</div>

						<div class="equal width fields">
							<div class="field">
							 	<div class="ui sub header">Province</div>
								<select class="ui fluid search normal selection dropdown" id="province" ng-model="inputProvince" ng-change="reloadCities()" REQUIRED>
									<option value="" disabled selected>Select Province</option>
									<option ng-repeat="province in provinces" value="@{{province.ProvinceID}}">@{{province.ProvinceName}}</option>
								</select>
							</div>
							<div class="field">
							 	<div class="ui sub header">City</div>
								<select class="ui fluid search normal selection dropdown" name="city" id="city" ng-model="inputCity" ng-change="shipmentFee()" REQUIRED>
									<option value="" disabled selected>Select City</option>
									<option ng-repeat="city in cities" value="@{{city.CityID}}">@{{city.CityName}}</option>
								</select>
							</div>
					  	</div>
					</div>
					  
					<div class="equal width fields"> 
					  	<div class="field">
							<label>Cellphone Number</label>
							<input type="text" name="phoneNumber" pattern="([0-9 '.]){2,}" placeholder="+639 XX XXX XXXX" value="@{{account.CellphoneNo}}">
						</div>
						<div class="field">
							<label>Telephone Number</label>
							<input type="text" name="telNumber" pattern="([0-9 '.]){2,}" placeholder="XXX XXXX XXX" value="@{{account.LandLine}}">
						</div>
					</div>
					<div class="ui one column center aligned page grid">
						<div class="column">
				  			<button class="ui blue button" type="submit"><i class="checkmark icon"></i> Submit</button>
				  		</div>
				  	</div>
				
			</div>

			<div class="ui column six wide right floated" style="margin: 5px 0 5px 15px;">
				<h2 class="ui header">
				  <i class="payment icon"></i>
				  <div class="content">
				    Order Summary
				  </div>
				</h2>
				<div class="ui divider"></div>

				<table class="ui selectable green table">
				  	<thead>
				    	<tr>
				    		<th></th>
					    	<th>Item</th>
					    	<th>Price</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				    	<tr ng-repeat="item in cartItems">
				    		<td>
				    			<input type="checkbox" class="ui checkbox" name="items[]" value="@{{item.ItemID}}" ng-click="removeFromCart(item, $index)" checked/>
				    		</td>
				      		<td>@{{item.Model}}</td>
				      		<td>@{{item.Price | currency : 'P' : 2}}</td>
				    	</tr>
				    	<tr class="warning">
					      <td>Discount (%):</td>
					      <td></td>
					      <td>@{{customerDiscount }}</td>
					    </tr>
				    	<tr class="positive">
					      <td>Discounted Price:</td>
					      <td></td>
					      <td>@{{discountedPrice | currency : 'P' : 2}}</td>
					    </tr>
					    <tr><td></td><td></td><td></td></tr>
					    <tr class="warning">
					      <td>Service Fee (%):</td>
					      <td></td>
					      <td>@{{serviceFee}}</td>
					    </tr>
				    	<tr class="positive">
					      <td>Sub total:</td>
					      <td></td>
					      <td>@{{subTotalPrice | currency : 'P' : 2}}</td>
					    </tr>
					    <tr><td></td><td></td><td></td></tr>
				    	<tr class="warning" ng-if="checkoutType == 'Deliver'">
					      <td>Shipping fee:</td>
					      <td></td>
					      <td>@{{shippingFee | currency : 'P' : 2}}</td>
					    </tr>
					    <tr class="warning">
					      <td>Event fees:</td>
					      <td></td>
					      <td>@{{eventFee | currency : 'P' : 2}}</td>
					    </tr>
					    <tr class="positive">
					      <td>Total fee:</td>
					      <td></td>
					      <td>@{{totalPrice | currency : 'P' : 2}}</td>
					    </tr>
				  	</tbody>
				</table>
				<div class="ui sub header">
					Standard Shipping/Delivery days: 2-3 working days
				</div>
			</div>
	  	</div>
	</form>
	</div>

<script>
$('.ui.normal.dropdown')
  .dropdown()
;

//Delivery/Pickup
/*$(document).ready(function () {
      $('#radioDelivery').click(function () {
          var $this = $(this);
          if ($this.is(':checked')) {
              document.getElementById('delivery').style.display = 'block';
          } else {
              document.getElementById('delivery').style.display = 'none';
          }
     });
    });*/

	$(document).ready(function () {
		$('#pickupLocation').hide();
		$('#warehouseLocation').prop('required', false);
    	$('#address').prop('required', true);
    	$('#city').prop('required', true);

	    $("#radioDelivery").click(function () {
	       $('#deliveryAddress').show();
	       $('#pickupLocation').hide();

	       $('#warehouseLocation').prop('required', false);
	       $('#address').prop('required', true);
	       $('#city').prop('required', true);
	    });
	    $("#radioPickup").click(function () {
	    	$('#deliveryAddress').hide();
	    	$('#pickupLocation').show();

	    	$('#warehouseLocation').prop('required', true);
	       $('#address').prop('required', false);
	       $('#city').prop('required', false);
	    });
	});


	$(document).ready(function(){
	     $('#itemList').click(function(){
	        $('#itemModal').modal('show');    
	     });
	});

	var app = angular.module('myApp', ['datatables']);
	app.controller('myController', function($scope, $http, $timeout){
		$timeout(function(){
			$('#province').dropdown('set selected', $scope.account.ProvinceID);

			$http.get('/cityOptions?provID=' + $scope.inputProvince)
    	.then(function(response){
    		$scope.cities = response.data;
    		$('#city').dropdown('set selected', $scope.account.CityID);
    	});
		}, 1000);

		$scope.cartItems = [];
		$scope.shippingFee = 0;
		$scope.subTotalPrice = 0;
		$scope.discountedPrice = 0;
		$scope.checkoutType = 'Deliver';

		$http.get('/provinces')
	    .then(function(response){
	    	$scope.provinces = response.data;
	    });

	    $http.get('/itemsWon')
	    .then(function(response){
	    	$scope.itemsWon = response.data;
	    });

	    $scope.reloadCities = function(){
	    	$http.get('/cityOptions?provID=' + $scope.inputProvince)
	    	.then(function(response){
	    		$scope.cities = response.data;
	    	});
	    }

	    $http.get('/warehouses')
	    .then(function(response){
	      $scope.warehouses = response.data;
	    });

	    $scope.addToCart = function(item, index){
	    	$scope.cartItems.push(item);
	    	$scope.itemsWon.splice(index, 1);

	    	$scope.computePrice();
	    }

	    $scope.removeFromCart = function(item, index){
	    	$scope.cartItems.splice(index, 1);
	    	$scope.itemsWon.push(item);

	    	$scope.computePrice();
	    }

	    $scope.computePrice = function(){
	    	$scope.discountedPrice = 0;
	    	$scope.subTotalPrice = 0;
	    	for(var i=0; i<$scope.cartItems.length; i++){
	    		$scope.discountedPrice += $scope.cartItems[i].Price;
	    	}

	    	if($scope.checkoutType=="Pick up"){
	    		$scope.computeShippingFee = 0;
	    	}
	    	else {
	    		$scope.computeShippingFee = $scope.shippingFee;
	    	}

	    	//subTotal = subTotal - discountAmount;
	    	$scope.discountedPrice = $scope.discountedPrice - ($scope.discountedPrice * ($scope.customerDiscount / 100));

	    	$scope.subTotalPrice = Math.round(( ($scope.discountedPrice + ($scope.serviceFee*1/100 * $scope.discountedPrice)) + 0.00001) * 100) / 100;

	    	$scope.totalPrice = Math.round(( ($scope.computeShippingFee*1 + $scope.subTotalPrice*1 + $scope.eventFee*1) + 0.00001) * 100) / 100
	    	
	    }

	    $scope.shipmentFee = function(){
	    	$http.get('/shipmentFee?provinceID=' + $scope.inputProvince)
		    .then(function(response){
		      $scope.shippingFee = response.data.ShipmentFee;

		      $scope.computePrice();
		    });
	    }
	})
</script>
@endsection