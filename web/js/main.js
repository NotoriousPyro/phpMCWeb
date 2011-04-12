function navigate(page)
{
	document.location=page;
}

function getcontent(page,div)
{
	$.get(page, function(data) {
		$("#"+div).html(data);
	});
}

function autoupdate(page,div,delay)
{
	var auto_refresh = setInterval(function()
	{
		$("#"+div).load(page);
	}, delay * 1000);
}

getcontent("functions/get_cpuload.php", "cpu");
autoupdate("functions/get_cpuload.php", "cpu", 5);
getcontent("functions/get_memory.php", "memory");
autoupdate("functions/get_memory.php", "memory", 5);
getcontent("functions/get_uptime.php", "uptime");
autoupdate("functions/get_uptime.php", "uptime", 5);
getcontent("functions/get_players.php", "players");
autoupdate("functions/get_players.php", "players", 5);
getcontent("functions/get_status.php", "status");
autoupdate("functions/get_status.php", "status", 5);