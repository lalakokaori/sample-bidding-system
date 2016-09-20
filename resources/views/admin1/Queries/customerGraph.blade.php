@extends('admin1.mainteParent')

@section('content')
<div class="ui grid">
  @include('admin1.Queries.sideNav')

  <div class="twelve wide stretched column">
    <div class="ui segment">
     <form method="post" action="/customer">
        <button type="submit" name="list">All Approved Customer</button>
        <button type="submit" name="area">Per Area</button>
        <button type="submit" name="region">Per Region</button>
    </form><br>
    <br>
        <script src="js/js/highstock.js"></script>
        <script src="js/js/modules/exporting.js"></script>
        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
  </div>
</div>


<script>
    <?php
        if(is_null($customer)){
            echo "alert('Nothing to display!');";
        }
    ?>
$(function() {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Approved Accounts of 2016'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Approved Accounts'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                '<td style="padding:0"><b>{point.y:.0f} Account/s</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            /*name: 'asdasd',
            data: [1,2,3],
            name: 'asdadasdasd',
            data: [3,2,1]*/
            <?php
                //echo "alert(JSON.stringify(".$customer."))";
                if(!is_null($customer)){
                    echo "name: ' ',data:[";
                    $k=count($customer);
                    $j=0;
                    for ($i=1; $i<=12; $i++) { 
                        if($j!=$k){
                            if($customer[$j][0]==$i){
                                echo $customer[$j][1].",";
                                $j++;
                            } else{
                                echo "0,";
                            }
                        } else{
                            echo "0,";
                        }
                    }
                    echo "]";
                } else{
                    echo "name: 'Nothing to show'";
                }
            ?>
        }]
    });
});

</script>
@endsection