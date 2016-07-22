@extends('customer.homepage')

@section('nav')
	<div class="ui fixed inverted menu">
        <a class="item" href="/">
            <img src="/icons/icon.png">
        </a>

        <a class="item" href="/">
            <i class="home icon"></i>Home
        </a>

        <a class="item" href="/cart">
            <i class="cart icon"></i>Cart
        </a>

        <a class="item" href="/bidList">
            <i class="list icon"></i>Items Bidded
        </a>
        
        <div class="right menu">
          <a class="ui item">
            help
            <i class="help icon"></i>
          </a>
        </div>
      </div>
@endsection

@section('content')
	<div style="margin: 35px 0 0 0" class="ui container segment" ng-app="myApp" ng-controller="myController">
		<div class="ui grid">
			<div class="ten wide column">
				<div class="ui segment">
					<h2 class="ui header">
					  <i class="shop icon"></i>
					  <div class="content">
					    Items Bidded
					  </div>
					</h2>
					<div class="ui divider"></div>

					<div class="ui top attached tabular menu">
					  <a class="active item" data-tab="first">First</a>
					  <a class="item" data-tab="second">Second</a>
					</div>
					<div class="ui bottom attached active tab segment" data-tab="first">
					  First
					</div>
					<div class="ui bottom attached tab segment" data-tab="second">
					  Second
					</div>


					<!-- start loop -->
					@foreach($bids as $key => $bid)
						<div class="ui grid">
							<div class="five wide column">
								<img class="ui small image" src="{{$bid->item->image_path}}">
							</div>
							<div class="eight wide column" ng-click="bidItem({{$bid->itemID}})">
								<div class="header">{{$bid->item->itemModel->ItemName}}</div>
								<div class="ui divider"></div>
								<div class="content">
									Bid: {{$bid->Price}}
									<p></p>
									Status: Currently Highest Bid
								</div>
							</div>
						</div>
						<div class="ui divider"></div>
					@endforeach
					<!-- end loop -->
				</div>	
			</div>

			<div class="six wide column">
				<div class="ui segment">
					<h2 class="ui header">
				  <i class="shopping cart icon"></i>
				  <div class="content">
				  	Items List
				  </div>
				</h2>
				<div class="ui divider"></div>
				Number of Items: 2
				<div class="ui divider"></div>
				Items won: 2
				<div class="ui divider"></div>
				Currently on Auction: 5
				</div>
			</div>
		</div>
	</div>

<script>
$('.menu .item').tab();


	var app = angular.module('myApp', ['datatables']);alert('sad');
	app.controller('myController', function($scope, $http){
		//$http.get('/auction?itemID=' + )
		$scope.bidItem = function(itemID){
			alert(itemID);//redirect to /auction for bidding of item
		}
	});
</script>
@endsection