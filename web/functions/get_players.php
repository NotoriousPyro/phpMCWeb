<?php

define("___ACCESS", TRUE);

require("../config.php");

class PlayerList
{
	private function GetData()
	{
		global $apicraft_ip;
		global $apicraft_port;
		
		$server = "http://".$apicraft_ip.":".$apicraft_port."/";
		$check = file_get_contents($server);
		
		if (empty($check))
		{
			return FALSE;
		}
		else
		{
			$currplayers = file_get_contents($server."serverinfos/online");
			$maxplayers = file_get_contents($server."serverinfos/max-players");
			$playersonline = preg_replace("/,/", ", ", file_get_contents($server."serverinfos/players-online"));
			
			return array("currplayers" => $currplayers, "maxplayers" => $maxplayers, "playersonline" => $playersonline);
		}
	}
	
	public function DisplayData()
	{
		$data = $this->GetData();
		
		if ($data === FALSE)
		{
			echo "Unknown";
		}
		elseif($data["currplayers"] === 0)
		{
			echo "0 / ".$data["maxplayers"];
		}
		else
		{
			echo nl2br("<strong>Players:</strong> ".$data["currplayers"]." / ".$data["maxplayers"]."\n"
			.$data["playersonline"]);
		}
	}
}

$playerlist = new PlayerList();
$playerlist->DisplayData();

?>