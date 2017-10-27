<?php

  class Metar
  {

    public static function lastChekMetar()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM temperature ORDER BY dateendtime DESC LIMIT 1';
        $result = $db->query($sql);
        $lastEntry = $result->fetch();
        $lastEntryTime = $lastEntry['dateendtime'];

        return $lastEntryTime;
    }

    public static function fillingPeriod($last_period, $temperature)
    {
      $db = Db::getConnection();
      $sql = 'INSERT INTO temperature (dateendtime, temperature)' . 'VALUES (:dateendtime, :temperature)';
      $result = $db->prepare($sql);
      $result->bindParam(':dateendtime', $last_period, PDO::PARAM_STR);
      $result->bindParam(':temperature', $temperature, PDO::PARAM_STR);
      return $result->execute();
    }

    public static function getfullParams()
    {
      $params_list = array();

      $db = Db::getConnection();
      $result = $db->query('SELECT * FROM temperature');
      $result->setFetchMode(PDO::FETCH_ASSOC);

      $i = 0;
      while($row = $result->fetch()){
        $params_list[$i]['timestamp'] = $row['dateendtime'] . '000';
        $params_list[$i]['temperature'] = $row['temperature'];
        $i++;
      }
      return $params_list;
    }

  }

?>
