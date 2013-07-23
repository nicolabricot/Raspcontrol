<?php

namespace lib;
use lib\Uptime;
use lib\Memory;
use lib\CPU;
use lib\Storage;
use lib\Network;
use lib\Rbpi;
use lib\Services;
use lib\Users;

spl_autoload_extensions('.php');
spl_autoload_register();

require 'config.php';

$result = array();

try {
  $db = json_decode(file_get_contents(FILE_PASS));
  $username = $db->{'user'};
  $password = $db->{'password'};
  
  if (!empty($_GET['username']) && !empty($_GET['password']) && $_GET['username'] == $username && $_GET['password'] == $password){
    //Login is ok, building full api response
    if(!empty($_GET['data'])){
      switch($_GET['data']){
        case 'all':
          $result['rbpi']['hostname'] = Rbpi::hostname(true);
          $result['rbpi']['distribution'] = Rbpi::distribution();
          $result['rbpi']['kernel'] = Rbpi::kernel();
          $result['rbpi']['firmware'] = Rbpi::firmware();
          $result['rbpi']['ip']['internal'] = Rbpi::internalIp();
          $result['rbpi']['ip']['external'] = Rbpi::externalIp();
          $result['uptime'] = Uptime::uptime();
          $result['memory']['ram'] = Memory::ram();
          $result['memory']['swap'] = Memory::swap();
          $result['cpu']['usage'] = CPU::cpu();
          $result['cpu']['heat'] = CPU::heat();
          $result['hdd'] = Storage::hdd();
          $result['net']['connections'] = Network::connections();
          $result['net']['ethernet'] = Network::ethernet();
          $result['users'] = Users::connected();;
          $result['services'] = Services::services();
        break;
        default:
          $result['error'] = 'Incorrect data request.'; 
      }
    }
    else{
      $result['error'] = 'Empty data request.'; 
    }
  }
  else{
    //Login error, api error response
    $result['error'] = 'Incorrect username or password.'; 
  }
} catch(Exception $e) {
  //FILE_PASS error, api error response
  $result['error'] = $e->getMessage();
}

header('Content-type: application/json');
echo json_encode($result);

?>