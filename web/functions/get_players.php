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

if ($data["result"] !== "success")
{
	$playercount = "?";
	$playerlimit = "?";
}
else
{
	foreach ($players[0] as $player => $value)
	{
		$name = $players[0][$player]["name"];
		if ($players[0][$player]["op"] === TRUE)
		{
			$playerlist = $playerlist."<a id=\"op\" href=\"javascript:popup('functions/get_player.php?player=".$name."','playerinfo','700','500')\">".$name."</a>";
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
}

echo nl2br("<strong>".$phpmc["MAIN"]["PLAYERS"]."</strong> "
	.$playercount." / ".$playerlimit."\n".$playerlist);

?>