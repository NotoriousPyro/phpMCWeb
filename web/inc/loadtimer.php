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