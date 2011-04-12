<?php

defined("___ACCESS") or header("HTTP/1.1 403 Forbidden");

class LoadTimer
{
	private $starttime;
	
	public function init()
	{
		$this->StartTimer();
	}
	
	private function GetCurrentTime()
	{
		$time = explode(" ", microtime());
		$time = $time[1] + $time[0];
		
		return $time;
	}
	
	private function StartTimer()
	{
		$this->starttime = $this->GetCurrentTime();
	}
	
	public function GetLoadTime()
	{
		$endtime = $this->GetCurrentTime();
		return round($endtime - $this->starttime, 5);
	}
}

$loadtimer = new LoadTimer();
$loadtimer->init();

?>