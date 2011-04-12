<?php

$get_meminfo = file("/proc/meminfo");

foreach ($get_meminfo as $key => $value)
{
	if (!preg_match("/^Mem/i", $get_meminfo[$key]))
	{
		unset($get_meminfo[$key]);
	}
	else
	{
		$get_meminfo[$key] = preg_replace("/[^\d]/", "", $get_meminfo[$key]);
	}
}

$get_meminfo = array_values($get_meminfo);

$mem_usedmb		= round(($get_meminfo[0] - $get_meminfo[1]) / 1024);
$mem_freemb		= round($get_meminfo[1] / 1024);
$mem_totalmb	= round($get_meminfo[0] / 1024);

echo nl2br("Used: ".$mem_usedmb." MB\n"
	."Free: ".$mem_freemb." MB\n"
	."Total: ".$mem_totalmb." MB");

?>