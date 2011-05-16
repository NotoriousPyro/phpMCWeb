<?php

/**
 * This file is part of phpMCWeb.
 * phpMCWeb is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * phpMCWeb is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with phpMCWeb. If not, see <http://www.gnu.org/licenses/>.
 */

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
	$memtotal = "?";
	$memusage = "?";
	$memfree = "?";
}
else
{
	$status = "theme/".$theme."/online.gif";
	$memtotal = round(($data["success"][0]["success"] / 1048576), 0);
	$memusage = round(($data["success"][1]["success"] / 1048576), 0);
	$memfree = $memtotal - $memusage;
}

$memusage = sprintf($phpmc["MAIN"]["MEM_USED"], $memusage);
$memfree = sprintf($phpmc["MAIN"]["MEM_FREE"], $memfree);
$memtotal = sprintf($phpmc["MAIN"]["MEM_TOTAL"], $memtotal);

$memformat = nl2br($memusage."\n".$memfree."\n".$memtotal);

echo "<div class=\"main_topright_left\">Memory:</div>
		<div id=\"memory\" class=\"main_topright_right\">".$memformat."</div>"
		."<div class=\"main_topright_left\">Status:</div>
		<div id=\"status\" class=\"main_topright_right\"><img class=\"status\" src=\"".$status."\" /></div>";

?>