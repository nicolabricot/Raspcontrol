<?php

namespace lib;

class Rbpi {
  
  public static function distribution() {
    $distroTypeRaw = exec("cat /etc/*-release | grep PRETTY_NAME=", $out);
    $distroTypeRawEnd = str_ireplace('PRETTY_NAME="', '', $distroTypeRaw);
    $distroTypeRawEnd = str_ireplace('"', '', $distroTypeRawEnd);

    return $distroTypeRawEnd;
  }

  public static function kernel() {
    return exec("uname -mrs");
  }

  public static function firmware() {
    return exec("uname -v");
  }

  public static function hostname($full = false) {
    return $full ? exec("hostname -f") : gethostname();
  }

  public static function internalIp() {
    return $_SERVER['SERVER_ADDR'];
  }

  public static function externalIpByJson() {
    if (!function_exists('file_get_contents'))
      return FALSE;
    $ip_json = file_get_contents('http://pv.sohu.com/cityjson?ie=utf-8');
    if ($ip_json==FALSE)
      return FALSE;
    $ip_json = trim($ip_json);
    $ip_json = substr($ip_json, 19);
    $ip_json = substr($ip_json, 0, -1);
    $ip_arr = json_decode($ip_json,true);
    return $ip_arr['cip'];
  }

  public static function externalIpByCurl() {
    if(!function_exists('curl_init'))
      return FALSE;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://ifconfig.me');
    curl_setopt($curl, CURLOPT_HEADER, 1);
    $ip = curl_exec($curl);
    curl_close($curl);
    if($ip=='')
      return FALSE;
    return $ip;
  }

  public static function externalIp() {
    $ip = self::externalIpByCurl();
    if($ip==FALSE)
      $ip = self::externalIpByJson();
    if($ip==FALSE)
      return 'Unavailable';
    return $ip;
}

  public static function webServer() {
    return$_SERVER['SERVER_SOFTWARE'];
  }

}

?>
