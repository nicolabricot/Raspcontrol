<?php

namespace lib;

class Services{

	public static function services() {
    
    $result = array();
    
    exec('service --status-all', $servicesArray);
    
    for ($i = 0; $i < count($servicesArray); $i++) {
      $servicesArray[$i] = preg_replace('!\s+!', ' ', $servicesArray[$i]);
      preg_match_all('/\S+/', $servicesArray[$i], $serviceDetails);
      list($status, $name) = $serviceDetails[0];
      
      $result[$i]['name'] = $name;
      $result[$i]['status'] = $status;
    }
    
    return $result;
	}
  
  public static function servicesRunning() {
    $services = self::services();
    
    $result = array();
    
    for($i = 0; $i < count($services); $i++){
      if($services[$i]['status'] == '[+]'){
        array_push($result, $services[$i]);
      }
    }
  
    return $result;
  }
}

?>