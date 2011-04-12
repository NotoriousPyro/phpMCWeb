<?php

define("___ACCESS", TRUE);

require("../config.php");

class ServerCheck
{
	private function GetStatus()
	{
		global $apicraft_ip;
		global $apicraft_port;
		global $theme;
		
		$offline = "theme/".$theme."/offline.gif";
		$online = "theme/".$theme."/online.gif";
		$check = @fsockopen($apicraft_ip, $apicraft_port, $errno, $errstr, 2);
		fclose($check);
		if (!$check)
			return $offline;
		else
			return $online;
	}
	
	public function ShowStatus()
	{
		echo "<img class=\"status\" src=\"".$this->GetStatus()."\" />";
	}
}

$showstatus = new ServerCheck;
$showstatus->ShowStatus();

?>