<?php

// get_cpuload.php - CPU Load Class
// Version 1.0.1
// Copyright 2001-2002, Steve Blinch
// http://code.blitzaffe.com
// Modified by NotoriousPyro
// Version: 1.1.0

define("TEMP_PATH","/tmp/");

class CPULoad
{
	function check_load()
	{
		$fd = fopen("/proc/stat","r");
		if ($fd)
		{
			$statinfo = explode("\n",fgets($fd, 1024));
			fclose($fd);
			$fileit = "0";
			foreach($statinfo as $line)
			{
				$info = explode(" ",$line);
				if($info[0]=="cpu")
				{
					array_shift($info);
					if(!$info[0]) array_shift($info);
					$this->user = $info[0];
					$this->nice = $info[1];
					$this->system = $info[2];
					$this->idle = $info[3];
					return;
				}
			}
		}
	}
	
	function store_load()
	{
		$this->last_user = $this->user;
		$this->last_nice = $this->nice;
		$this->last_system = $this->system;
		$this->last_idle = $this->idle;
	}
	
	function save_load()
	{
		$this->store_load();
		$fp = @fopen(TEMP_PATH."cpuinfo.tmp","w");
		if ($fp)
		{
			fwrite($fp,time()."\n");
			fwrite($fp,$this->last_user." ".$this->last_nice." ".$this->last_system." ".$this->last_idle."\n");
			fwrite($fp,$this->load["user"]." ".$this->load["nice"]." ".$this->load["system"]." ".$this->load["idle"]." ".$this->load["cpu"]."\n");
			fclose($fp);
		}
	}
	
	function load_load()
	{
		$fp = @fopen(TEMP_PATH."cpuinfo.tmp","r");
		if ($fp) {
			$lines = explode("\n",fread($fp,1024));
			$this->lasttime = $lines[0];
			list($this->last_user,$this->last_nice,$this->last_system,$this->last_idle) = explode(" ",$lines[1]);
			list($this->load["user"],$this->load["nice"],$this->load["system"],$this->load["idle"],$this->load["cpu"]) = explode(" ",$lines[2]);
			fclose($fp);
		}
		else
		{
			$this->lasttime = time() - 60;
			$this->last_user = $this->last_nice = $this->last_system = $this->last_idle = 0;
			$this->user = $this->nice = $this->system = $this->idle = 0;
		}
	}
	
	function calculate_load()
	{
		$d_user = $this->user - $this->last_user;
		$d_nice = $this->nice - $this->last_nice;
		$d_system = $this->system - $this->last_system;
		$d_idle = $this->idle - $this->last_idle;

		$total=$d_user+$d_nice+$d_system+$d_idle;
		if ($total<1) $total=1;
		$scale = 100 / $total;
		
		$cpu_load = ($d_user+$d_nice+$d_system)*$scale;
		$this->load["user"] = $d_user*$scale;
		$this->load["nice"] = $d_nice*$scale;
		$this->load["system"] = $d_system*$scale;
		$this->load["idle"] = $d_idle*$scale;
		$this->load["cpu"] = ($d_user+$d_nice+$d_system)*$scale;
	}
	
	function print_load()
	{
		$cpu = $this->load["cpu"];
		
		if ($cpu <= "32.9")
		{
			printf("<font color=\"green\">%.1f%%</font>",$cpu);
		}
		else if ($cpu >= "33" && $cpu <= "65.9")
		{
			printf("<font color=\"orange\">%.1f%%</font>",$cpu);
		}
		else
		{
			printf("<font color=\"red\"><b>%.1f%%</b></font>",$cpu);
		}
	}
	
	function sample_load($interval=1) {
		$this->check_load();
		$this->store_load();
		sleep($interval);
		$this->check_load();
		$this->calculate_load();
	}
	
	function get_load($fastest_sample=4)
	{
		$this->load_load();
		$this->cached = (time()-$this->lasttime);
		if ($this->cached>=$fastest_sample)
		{
			$this->check_load(); 
			$this->calculate_load();
			$this->save_load();
		}
	}
}

$cpuload = new CPULoad();
$cpuload->sample_load();
$cpuload->print_load();

?>