<?php

define("___ACCESS", TRUE);

require("../includes.php");
require("../inc/jsonapi.php");

$api = new JSONAPI($jsonapi_ip, $jsonapi_port, $jsonapi_username, $jsonapi_password, $jsonapi_salt);

$data = $api->callMultiple(array(
		"getPlayerCount",
		"getPlayerLimit",
		"getPlayers",
		), array(
		array(),
		array(),
		array()
		));

$playercount = $data["success"][0]["success"];
$playerlimit = $data["success"][1]["success"];
$players = array($data["success"][2]["success"]);

foreach ($players[0] as $player => $value)
{
	$name = $players[0][$player]["name"];
	if ($players[0][$player]["op"] === TRUE)
	{
		$playerlist = $playerlist."<a class=\"op\" href=\"javascript:popup('functions/get_player.php?player=".$name."','playerinfo','700','500')\">".$name."</a>";
	}
	else
	{
		$playerlist = $playerlist."<a href=\"javascript:popup('functions/get_player.php?player=".$name."','playerinfo','700','500')\">".$name."</a>";
	}
	if (!empty($players[0][$player + 1]))
	{
		$playerlist = $playerlist.", ";
	}
}

echo "<strong>"._PLAYERS_.":</strong> ";
echo nl2br($playercount." / ".$playerlimit."\n".$playerlist);

?>