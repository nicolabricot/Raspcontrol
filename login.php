<?php

namespace lib;
use lib\Secret;

spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require 'config.php';

// logout
if (isset($_GET['logout'])) {
  unset($_SESSION['authentificated']);
  session_destroy();
}

// user want to regenerate his API token
else if (isset($_SESSION['authentificated']) && $_SESSION['authentificated'] && isset($_GET['regenerate_token'])) {
  $s = new Secret();
  $s->changeApiToken();
  header('Location: '.ME);
  exit();
}

// create new user & password
else if (isset($_POST['unicorn'])) {

  if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $s = new Secret();
    $s->setData($_POST['username'], $_POST['password']);
  }
  else {
    $_SESSION['message'] = 'Username and password must not be empty!';
  }

}

// check identification
else if (isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {

  if (!is_writable(realpath(dirname(__FILE__)))) die('<p style="text-align:center;"><span style="color:red;">ERROR</span><br />Application does not have the right to write in its own directory <code>'.realpath(dirname(__FILE__)).'</code>.</p>');
  
  $s = new Secret();

  if ($s->verify($_POST['username'], $_POST['password'])) {
    $_SESSION['authentificated'] = true;
  }
  else {
    $_SESSION['message'] = 'Incorrect username or password.';
  }

}

header('Location: '.INDEX);
exit();

?>