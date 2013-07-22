<?php

namespace lib;
use lib\Services;

$services = Services::services();


?>

<div class="container details">
  <table>
    <tr class="services" id="check-services">
      <td class="check" rowspan="<?php echo sizeof($services); ?>"><i class="icon-cog"></i> Services</td>
      <?php
        for ($i = 0; $i < sizeof($services); $i++) {
          echo '<td class="icon" style="padding-left: 10px;">', $services[$i]['status'], '</td>
            <td class="infos">', $services[$i]['name'] , '</td>
          </tr>
          ', ($i == sizeof($hdd)-1) ? null : '<tr class="service">';
        }
      ?>
  </table>
</div>