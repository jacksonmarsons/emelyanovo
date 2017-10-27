<?php include ROOT . '/views/header.php' ?>

<h3 class="text-center"><span>Температура воздуха в аэропорту Емельяново: </span><span id="temperature"></span><h3>
</br>
<h3 class="text-center">Динамика изменения погоды</h3>

<div id="container" style="height: 400px; min-width: 310px"></div>


<script type="text/javascript">
  var chart1;

  $.getJSON('getFullParams', function (data) {

    var temperature = [];
    for(var e = 0; e < data.length; e++){
      var time = [];
      time.push(Number(data[e]['timestamp']));
      time.push(Number(data[e]['temperature']));
      temperature.push(time);
    }
    // Create the chart
    chart1 = Highcharts.stockChart('container', {
         rangeSelector: {
            selected: 1
         },
         series: [{
            name: 'Температура :',
            data: temperature,  // predefined JavaScript array

         }]
    });
});

</script>
  
<?php include ROOT . '/views/footer.php' ?>
