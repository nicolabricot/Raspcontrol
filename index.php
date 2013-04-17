<?php

namespace lib;

spl_autoload_extensions('.php');
spl_autoload_register();

session_start();

require 'config.php';

// authentification
if (isset($_SESSION['authentificated']) && $_SESSION['authentificated']) {
  if (empty($_GET['page'])) $_GET['page'] = 'home';
  $_GET['page'] = htmlspecialchars($_GET['page']);
  str_replace("\0", '', $_GET['page']);
  str_replace(DIRECTORY_SEPARATOR, '', $_GET['page']);
  $display = true;
  function is_active($page) {
    if ($page == $_GET['page'])
      echo ' class="active"';
  }
}
else {
  $_GET['page'] = 'login';
  $display = false;
}

$page = 'pages'. DIRECTORY_SEPARATOR.$_GET['page']. '.php';
$page = file_exists($page) ? $page : 'pages'. DIRECTORY_SEPARATOR .'404.php';

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Raspcontrol</title>
    <meta name="author" content="Nicolas Devenet" />
    <meta name="robots" content="noindex, nofollow, noarchive" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link rel="icon" type="image/png" href="img/favicon.ico" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="css/raspcontrol.css" rel="stylesheet" media="screen" />
  </head>

  <body>

    <header>
      <div class="container">
        <a href="<?php echo INDEX; ?>"><img src="img/raspcontrol.png" alt="rbpi" /></a>
        <h1><a href="<?php echo INDEX; ?>">Raspcontrol</a></h1>
        <h2>The Raspberry Pi Control Center</h2>
      </div>
    </header>

    <?php if ($display) : ?>

    <div class="navbar navbar-static-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <ul class="nav">
            <li<?php is_active('home'); ?>><a href="<?php echo INDEX; ?>"><i class="icon-home icon-white"></i> Home</a></li>
            <li<?php is_active('details'); ?>><a href="<?php echo DETAILS; ?>"><i class="icon-search icon-white"></i> Details</a></li>
          </ul>
          <ul class="nav pull-right">
            <li><a href="<?php echo LOGOUT; ?>"><i class="icon-off icon-white"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </div>

    <?php endif; ?>

    <div id="content">
      <?php if (isset($_SESSION['message'])) { ?>
      <div class="container">
        <div class="alert alert-error">
          <strong>Oups!</strong> <?php echo $_SESSION['message']; ?>
        </div>
      </div>
      <?php unset($_SESSION['message']); } ?>
      
<?php
  include $page;
?>

    </div> <!-- /content -->

    <footer>
      <div class="container">
        <p>Initially powered by <a href="https://github.com/Bioshox/Raspcontrol">Raspcontrol</a> and adapted by <a href="//twitter.com/nicolabricot">@nicolabricot</a>.</p>
        <p>Sources are available on <a href="https://github.com/nicolabricot/Raspcontrol">Github</a>.</p>
      </div>
    </footer>

    <?php
      if ($display)
        echo '<!--<script src="js/bootstrap.min.js"></script>-->';
      else
        echo '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    ?>

  </body>
</html>