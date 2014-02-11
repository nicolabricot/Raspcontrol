<?php

namespace lib;
use lib\Secret;

$s = new Secret();

?>

      <div class="container">

        <div>
          <h3>Raspcontrol ID</h3>
        <dl class="dl-horizontal">
          <dt>Username</dt>
            <dd><?php echo $s->getUsername(); ?></dd>

          <dt>API token</dt>
            <dd><?php echo $s->getApiToken(); ?> <small style="margin-left:20px;"><a href="login.php?regenerate_token">regenerate token</a></small></dd>
        </dl>

        <p>The API is available at <code><?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); ?>/api.php</code>.</p>
        </div>

        <hr />

        <div>
        To change your ID, just remove the file <code><?php echo Secret::SECRET_FILE; ?></code> in the root directory of Rapscontrol.
      </div>

      </div>
