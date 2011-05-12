<?php

define("___ACCESS", TRUE);

require("../includes.php");
require("../inc/jsonapi.php");

$api = new JSONAPI($jsonapi_ip, $jsonapi_port, $jsonapi_username, $jsonapi_password, $jsonapi_salt);

$data = $api->callMultiple(array(
		"system.getJavaMemoryTotal",
		"system.getJavaMemoryUsage",
		), array(
		array(),
		array(),
		));

if ($data["result"] !== "success")
{
	$status = "theme/".$theme."/offline.gif";
}
else
{
	$status = "theme/".$theme."/online.gif";
}

$memtotal = round(($data["success"][0]["success"] / 1048576), 0);
$memusage = round(($data["success"][1]["success"] / 1048576), 0);
$memfree = $memtotal - $memusage;

$memformat = nl2br(_USED_.": ".$memusage." MB\n"._FREE_.": ".$memfree." MB\n"._TOTAL_.": ".$memtotal." MB");

echo "<div class=\"main_topright_left\">Memory:</div>
		<div id=\"memory\" class=\"main_topright_right\">".$memformat."</div>"
		."<div class=\"main_topright_left\">Status:</div>
		<div id=\"status\" class=\"main_topright_right\"><img class=\"status\" src=\"".$status."\" /></div>";

?>