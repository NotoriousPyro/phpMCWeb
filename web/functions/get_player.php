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
require("../inc/loadtimer.php");
require("../inc/jsonapi.php");
require("../lang/".$language."/items.php");

$player = $_GET["player"];

if ($player !== "")
{
	if (!preg_match("/^[A-Za-z0-9_]+$/", $player))
	{
		die($phpmc["ERRORS"]["INJECT_CAUGHT"]);
	}
	else 
	{
		$api = new JSONAPI($jsonapi_ip, $jsonapi_port, $jsonapi_username, $jsonapi_password, $jsonapi_salt);

		$data = $api->call("getPlayer",array($player));
		
		if ($data["result"] !== "success")
		{
			$error = $phpmc["MAIN"]["PLAYER_OFFLINE"];
		}
	}
}
else
{
	$error = $phpmc["ERRORS"]["NO_PLAYER_SPECIFIED"];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../theme/<?php echo $theme; ?>/main.css" rel="stylesheet" type="text/css" />
<link href="../theme/<?php echo $theme; ?>/player.css" rel="stylesheet" type="text/css" />
<link href="../theme/<?php echo $theme; ?>/jquery.alerts.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jquery.alerts.js"></script>
<script type="text/javascript">
function HandleError(error)
{
	if (error != '') {
		jAlert(error, '<?php echo _ERROR_; ?>', function() {
			window.close();
		});
	}
}
</script>
<title><?php echo $phpmc["MAIN"]["PLAYERINFO"].$player; ?></title>
</head>

<body onload="HandleError('<?php echo $error; ?>')">
<div class="inventory">
	<div class="armour_area">
<?php

if (!isset($error))
{
	$data_armour = $data["success"]["inventory"]["armor"];
	echo "\t\t<div title=\"".$phpmc["ITEMS"][$data_armour["helmet"]["type"]]."\" class=\"item\" "
	."style=\"background-image: url('../theme/".$theme."/items/".$data_armour["helmet"]["type"].".png');\"></div>\n"
	."\t\t<div title=\"".$phpmc["ITEMS"][$data_armour["chestplate"]["type"]]."\" class=\"item\" "
	."style=\"background-image: url('../theme/".$theme."/items/".$data_armour["chestplate"]["type"].".png');\"></div>\n"
	."\t\t<div title=\"".$phpmc["ITEMS"][$data_armour["leggings"]["type"]]."\" class=\"item\" "
	."style=\"background-image: url('../theme/".$theme."/items/".$data_armour["leggings"]["type"].".png');\"></div>\n"
	."\t\t<div title=\"".$phpmc["ITEMS"][$data_armour["boots"]["type"]]."\" class=\"item\" "
	."style=\"background-image: url('../theme/".$theme."/items/".$data_armour["boots"]["type"].".png');\"></div>\n";
}

?>
	</div>
	<img class="player" src="get_skin.php?player=<?php echo $player; ?>" />
	<div class="healtbar"><?php
	$data_health = $data["success"]["health"];
	echo "\n\t\t";
	$i = 0;
	do
	{
		if ($data_health === $i + 1)
		{
			echo "<img class=\"healthpip\" src=\"../theme/".$theme."/halfpip.png\" />";
			break;
		}
		else
		{
			echo "<img class=\"healthpip\" src=\"../theme/".$theme."/fullpip.png\" />";
		}
		$i = $i + 2;
	} while ($i < $data_health);
	
	?></div>
	<div class="inventory_area">
<?php
if (!isset($error))
{
	$data_inventory = $data["success"]["inventory"]["inventory"];
	foreach ($data_inventory as $item => $value)
	{
		echo "\t\t<div title=\"".$phpmc["ITEMS"][$data_inventory[$item + 9]["type"]]."\" class=\"item\" "
		."style=\"background-image: url('../theme/".$theme."/items/".$data_inventory[$item + 9]["type"].".png');\">";
		if ($data_inventory[$item + 9]["amount"] > 1)
		{
			echo "<div class=\"item_count\">".$data_inventory[$item + 9]["amount"]."</div>";
		}
		echo "</div>\n";
		if ($item === 26)
			break;
	}
}
?>
	</div>
	<div class="inventory_area_bottom">
<?php
if (!isset($error))
{
	foreach ($data_inventory as $item => $value)
	{
		echo "\t\t<div title=\"".$phpmc["ITEMS"][$data_inventory[$item]["type"]]."\" class=\"item\" "
		."style=\"background-image: url('../theme/".$theme."/items/".$data_inventory[$item]["type"].".png');\">";
		if ($data_inventory[$item]["amount"] > 1)
		{
			echo "<div class=\"item_count\">".$data_inventory[$item]["amount"]."</div>";
		}
		echo "</div>\n";
		if ($item === 8)
			break;
	}
}
?>
	</div>
</div>
<div class="version"><?php

// Please do not edit this line, if you wish to help develop phpMCWeb
// then please get in touch with me at craigcrawford1988 AT gmail DOT com
printf($phpmc["VERSION"].$phpmc["MAIN"]["LOADTIMER"], $loadtimer->GetLoadTime());

?></div>
</body>
</html>