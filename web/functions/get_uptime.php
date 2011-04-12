<?php

// get_uptime.php - Version 1.0.3
// A Linux /proc/uptime parser 
// by NotoriousPyro

$uptime = shell_exec("cut -d . -f 1 /proc/uptime");
$days = floor($uptime/60/60/24);
$hours = $uptime/60/60%24;
$mins = $uptime/60%60;
$secs = $uptime%60;

echo $days."d ".$hours."h ".$mins."m ".$secs."s";

?>