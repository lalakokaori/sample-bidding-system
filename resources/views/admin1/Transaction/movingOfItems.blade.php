@extends('admin1.mainteParent')

@section('content')
<div class="ui grid" ng-app="myApp" ng-controller="myController">
 @include('admin1.Transaction.sideNav')

  <div class="twelve wide stretched column">
    <div class="ui segment">
      <h2 class="ui centered header">Request to move items</h2>
      <form action="itemMoveRequest" method="POST">

          <select class="ui dropdown" name="warehouse">
            <option disabled selected value="">Destination Warehouse</option>
            <option ng-repeat="warehouse in warehouses" value="@{{warehouse.WarehouseNo}}">@{{warehouse.Barangay_Street_Address}}, @{{warehouse.city.CityName}}, @{{warehouse.city.province.ProvinceName}}</option>
          </select>
          <button class="ui green button" type="submit">Confirm</button>

        <table class="ui celled table" datatable="ng">
          <thead>
            <tr>
              <th></th>
              <th>Warehouse</th>
              <th>Item</th>
              <th>Color</th>
              <th>Size</th>
              <th>Defect</th>
          </tr>
          </thead>
          <tbody>
            <tr ng-repeat="item in items">
              <td>
                <input name="movingItems[]" value="@{{item.ItemID}}" type="checkbox" class="ui checkbox">
              </td>
              <td>@{{item.current_warehouse.Barangay_Street_Address}}, @{{item.current_warehouse.city.CityName}}, @{{item.current_warehouse.city.province.ProvinceName}}</td>
              <td>@{{item.item_model.ItemName}}</td>
              <td>@{{item.color}}</td>
              <td>@{{item.size}}</td>
              <td>@{{item.DefectDescription}}</td>
            </tr>
          </tbody>
        </table>

        
      </form>
    </div><!-- segment -->
  </div><!-- twelve wide column -->
</div><!-- ui grid -->


<script>
$('.ui.dropdown').dropdown();

var app = angular.module('myApp', ['datatables']);
app.controller('myController', function($scope, $http){
  $http.get('itemsMoveSelect')
  .then(function(response){
    $scope.items = response.data;
  });

  $http.get('warehouses')
  .then(function(response){
    $scope.warehouses = response.data;
  });
});

</script>
@endsection