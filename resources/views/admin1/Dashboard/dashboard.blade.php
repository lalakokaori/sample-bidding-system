@extends('admin1.mainteParent')


@section('content')
<div class="ui grid">
  <div class="sixteen wide stretched column">
    <div class="ui segment">
      <h1 class="ui centered header">DASHBOARD</h1>
      <p id="curDate" style="font-size:25px" class="ui basic right aligned segment"></p>
      <div class="ui segment" ng-app="announcementApp" ng-controller="adminDashboardController">
        <div class="ui inverted segment">
          <div class="ui three statistics">
            <div class="ui inverted statistic">
              <div class="value">
                 @{{customerStat}}
              </div>
              <div class="label">
                Current Bidders
              </div>
            </div>
            <div class="ui red inverted statistic">
              <div class="value">
                @{{ongoingEvents}}
              </div>
              <div class="label">
                Current ongoing event
              </div>
            </div>
            <div class="ui orange inverted statistic">
              <div class="value">
                @{{pendingCheckout}}
              </div>
              <div class="label">
                Pending Checkout requests
              </div>
            </div>
            <div class="ui yellow inverted statistic">
              <div class="value">
                @{{items}}
              </div>
              <div class="label">
                Items In Inventory
              </div>
            </div>
          </div><!-- statistics -->
        </div>

        <div class="ui divider"></div>

        <div class="ui inverted segment">
          <div id='calendar'></div>
        </div>

        <div class="ui divider"></div>

        <div class="ui inverted segment">
          <h2 class="ui center aligned icon header">
            <i class="circular building outline icon"></i>
            Company Details
          </h2>
          <div class="ui divider"></div>
          <div class="ui two column grid" id="announcement" >
            <div class="column">
              <h2 class="ui inverted header">
                <i class="circular building icon" ></i>
                <div class="content">
                Company Name:<br>
                <u style="color:green">
                  @{{company.CompanyName}}
                </u>
                </div>
              </h2>
              <h2 class="ui inverted header">
                <i class="circular marker icon"></i>
                <div class="content">
                Address:<br>
                <u style="color:red">
                  @{{company.ComapanyAddress}}
                </u>
                </div>
              </h2>
              <h2 class="ui inverted header">
                <i class="circular book icon"></i>
                <div class="content">
                Contact Information:<br>
                <u style="color:yellow">
                  @{{company.CompanyEmail}}
                  @{{company.CellphoneNo}}
                  </u>
                </div>
              </h2>
            </div>
            <div class="column">
              <h2 class="ui inverted header">
                <i class="photo icon"></i>
                <div class="content">
                 <img class="ui rounded small image" src="@{{company.valid_id}}" >
                </div>
              </h2>            
            </div><!--2nd column-->
          </div>  
        </div><!--company details-->
      </div>

      
     
    </div><!-- segment -->
  </div><!-- column -->
</div><!-- grid -->

<script>
  var d = new Date();
  document.getElementById("curDate").innerHTML = d.toDateString();



  $(document).ready(function() {
      $('#calendar').fullCalendar({
        height: 650,
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: 'Calendar_events',
        eventColor: '#378006'
      });
    });

  var app = angular.module('announcementApp', ['datatables']);
    app.controller('adminDashboardController', function($scope, $http){
      $http.get('/latestCompanyDetails')
      .then(function(response){
        if(response.data != 'empty'){
          $scope.company = response.data;
        }
        else {
          $scope.company = null;
        }
      });

      $http.get('/Calendar_events')
      .then(function(response){
        if(response.data != 'empty'){
          $scope.events = response.data;
        }
      });

      $scope.randomInRangeOf = function(min, max){
        return Math.floor((Math.random() * max)) + min;
      }

      $http.get('/getOngoingEvent')
      .then(function(response){
        $scope.ongoingEvents = response.data.length;
      });

      $http.get('/currentTime')
      .then(function(response){
        $scope.currentTime = response.data;
      });

      $http.get('customerStat')
      .then(function(response){
        $scope.customerStat = response.data.length;
      });

      $http.get('pendingCheckout')
      .then(function(response){
        $scope.pendingCheckout = response.data.length;
      });


      $http.get('itemsInventory')
      .then(function(response){
        $scope.items = response.data.length;
      });
    });

    //angular.bootstrap(document.getElementById("announcement"), ['announcementApp']);

  /* var app = angular.module('myApp', ['datatables']);
    app.controller('myController', function($scope, $http){
      

    }); */
</script>
@endsection