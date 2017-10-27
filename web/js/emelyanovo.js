$(document).ready(function(){

  current_temperature = "x";

  gettemperature();

  setInterval(function() {

    gettemperature();

    $.ajax({
      type: 'post',
      url: 'last_chek',
      success: function(time){

        currentdate = new Date();
        th_currentdate = currentdate.valueOf();
        th_currentdate = th_currentdate + (7*60*60*1000);
        if((th_currentdate - time*1000)>1800000){
          how_time_period = (th_currentdate - time*1000)/1800000;

          $.ajax({
            type: 'post',
            url: 'filling_log',
            data: {'how_time_period': how_time_period, 'temperature': current_temperature, 'last_period': time},
            success: function(result){
              console.log(result);
            }
          });
        }
      }
    });

  }, 60000);

});

function gettemperature(){
  $.ajax({
    type: 'GET',
    url: 'http://avwx.rest/api/metar/UNKL',
    dataType: 'json',
    success: function(metar){
      $.ajax({
        type: 'post',
        url: 'getTemperature',
        data: {'metar': metar['Raw-Report']},
        success: function(temperature){
          current_temperature = temperature;
          if(temperature > 0){
            $("#temperature").text("+"+temperature);
          }else {
            $("#temperature").text(temperature);
          }
        }
      });
    }
  });
}
