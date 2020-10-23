<?php
elgg_admin_gatekeeper();

$string = get_input('str');

$lines = get_spam_log_from_txt();
if(count($lines) > 0 ) {
  foreach ($lines as $linenum => $value) {
    if(strpos($value, $string) !== false){
      $logs[] = $value;
    }
  }
}
sort($logs);
?>
<table class="popup_tab" cellspacing="2" cellpadding="5" style="margin: 20px; width:90%">
  <tr>
    <th><b>Date</b></th>
    <th><b>Source</b></th>
    <th><b>Email</b></th>
    <th><b>Domain</b></th>
    <th><b>IP</b></th>
  </tr>
    <?php
    foreach ($logs as $key => $value) {
      $elem = explode("|", $value);
      echo "<tr>";
      echo    "<td>{$elem[0]}</td>";
      echo    "<td>{$elem[1]}</td>";
      echo    "<td>{$elem[2]}</td>";
      echo    "<td>{$elem[3]}</td>";
      echo    "<td>{$elem[4]}</td>";
      echo "</tr>";
    }
    ?>
</table>