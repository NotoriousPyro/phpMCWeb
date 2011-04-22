<?php

define("___ACCESS", TRUE);

require("../config.php");

class PlayerList
{
	private function GetData()
	{
		global $apicraft_ip;
		global $apicraft_port;
		
		$server = "http://".$apicraft_ip.":".$apicraft_port."/serverinfos/";
		$check = @file_get_contents($server);
		
		if (empty($check))
			return FALSE;
		else
		{
			$currplayers = file_get_contents($server."online");
			$maxplayers = file_get_contents($server."max-players");
			$playersonline = preg_replace("/,/", ", ", file_get_contents($server."players-online"));
			
			return array("currplayers" => $currplayers, "maxplayers" => $maxplayers, "playersonline" => $playersonline);
		}
	}
	
	public function DisplayData()
	{
		$data = $this->GetData();
		
		if ($data === FALSE)
			echo "<strong>Players:</strong> Unknown";
		elseif($data["currplayers"] === 0)
			echo "<strong>Players:</strong> 0 / ".$data["maxplayers"];
		else
			echo nl2br("<strong>Players:</strong> ".$data["currplayers"]." / ".$data["maxplayers"]."\n".$data["playersonline"]);
	}
}

$playerlist = new PlayerList();
$playerlist->DisplayData();

?>