<?php

define("___ACCESS", TRUE);

require("../includes.php");
require("../inc/loadtimer.php");
require("../inc/jsonapi.php");
require("../lang/".$language."/items.php");

$player = $_GET["player"];

if ($player !== "")
{
	if (preg_match("/^[A-Za-z0-9_]+$/", $player))
	{
		$api = new JSONAPI($jsonapi_ip, $jsonapi_port, $jsonapi_username, $jsonapi_password, $jsonapi_salt);

		$data = $api->call("getPlayer",array($player));
		
		if ($data["success"] === NULL)
		{
			$error = _PLAYERNOTONLINE_;
		}
	}
	else 
	{
		$error = _ERROR_.": "._INJECT_CAUGHT_;
	}
}
else
{
	$error = _ERROR_.": "._NOPLAYERSPEC_;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../theme/<?php echo $theme; ?>/main.css" rel="stylesheet" type="text/css" />
<link href="../content/content.css" rel="stylesheet" type="text/css" />
<link href="../content/jquery.alerts.css" rel="stylesheet" type="text/css" />
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
<title><?php echo _PLAYERINFO_; ?>: <?php echo $player; ?></title>
</head>

<body onload="HandleError('<?php echo $error; ?>')">
<div class="inventory">
	<div class="armour_area">
<?php

if (!isset($error))
{
	$data_armour = $data["success"]["inventory"]["armor"];
	echo "\t\t<div title=\"".$lang_items[$data_armour["helmet"]["type"]]
	."\" class=\"item\" style=\"background-image: url('../content/items/".$data_armour["helmet"]["type"].".png');\"></div>\n";
	echo "\t\t<div title=\"".$lang_items[$data_armour["chestplate"]["type"]]
	."\" class=\"item\" style=\"background-image: url('../content/items/".$data_armour["chestplate"]["type"].".png');\"></div>\n";
	echo "\t\t<div title=\"".$lang_items[$data_armour["leggings"]["type"]]
	."\" class=\"item\" style=\"background-image: url('../content/items/".$data_armour["leggings"]["type"].".png');\"></div>\n";
	echo "\t\t<div title=\"".$lang_items[$data_armour["boots"]["type"]]
	."\" class=\"item\" style=\"background-image: url('../content/items/".$data_armour["boots"]["type"].".png');\"></div>\n";
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
			echo "<img class=\"healthpip\" src=\"../content/halfpip.png\" />";
			break;
		}
		else
		{
			echo "<img class=\"healthpip\" src=\"../content/fullpip.png\" />";
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
		echo "\t\t<div title=\"".$lang_items[$data_inventory[$item + 9]["type"]]."\" class=\"item\" style=\"background-image: url('../content/items/".$data_inventory[$item + 9]["type"].".png');\">";
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
		echo "\t\t<div title=\"".$lang_items[$data_inventory[$item]["type"]]."\" class=\"item\" style=\"background-image: url('../content/items/".$data_inventory[$item]["type"].".png');\">";
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
<div class="version"><?php printf(_VERSION_, $version." by NotoriousPyro<br />\n"); printf(_LOADTIMER_, $loadtimer->GetLoadTime()); ?></div>
</body>
</html>