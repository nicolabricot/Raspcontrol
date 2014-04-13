<?php

/*
 * To enable URL rewriting, please set the $rewriting variable on 'true'
 *
 * Ensure you have done every other steps described on
 * https://github.com/Bioshox/Raspcontrol/wiki/Enable-URL-Rewriting#configure-your-web-server
 */
$rewriting = false;

/*
 * Do NOT change the following lines
 */
error_reporting(0);
define('INDEX', './');
define('LOGIN', 'login.php');

if ($rewriting) {
  define('LOGOUT', './logout');
  define('DETAILS', './details');
  define('SERVICES', './services');
  define('DISKS', './disks');
  define('ME', './me');
}
else {
  define('LOGOUT', './login.php?logout');
  define('DETAILS', './?page=details');
  define('SERVICES', './?page=services');
  define('DISKS', './?page=disks');
  define('ME', './?page=me');
}

?>