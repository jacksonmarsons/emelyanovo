<?php

  require_once(ROOT . '/components/metar_decoder/src/MetarDecoder.inc.php');

  class SiteController
  {

    public function actionIndex()
    {
      require_once(ROOT . '/views/site/index.php');
      return true;
    }

    public function actionGetTemperature()
    {
      $metar = $_POST['metar'];
      $decoder = new MetarDecoder\MetarDecoder();
      $d = $decoder->parse($metar);
      $temperature = $d->getAirTemperature()->getValue();

      echo $temperature;

      return true;
    }

    public function actionChekLastEntry()
    {
      $last_chek_metar = Metar::lastChekMetar();
      echo $last_chek_metar;
      return true;
    }

    public function actionFillingLog()
    {
      $temperature = $_POST['temperature'];
      $filling_period = intval($_POST['how_time_period']);
      $last_period = $_POST['last_period'];
      $rs = 0;
      while($filling_period > 0){
        $last_period = $last_period + 1800;

        $result = Metar::fillingPeriod($last_period, $temperature);
        $rs = $rs + $result;

        $filling_period--;
      }
      return true;
    }

    public function actionGetFullParams()
    {
      $result_params_list = array();

      $result_params_list = Metar::getfullParams();
      echo json_encode($result_params_list);

      return true;
    }

  }
?>
