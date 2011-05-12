<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body,td,th {
	font-family: "Lucida Console", Monaco, monospace;
	font-size: 11px;
}
</style>
</head>

<body>
<?php

define("___ACCESS", TRUE);

require("../../includes.php");
require("../../inc/jsonapi.php");

$api = new JSONAPI($jsonapi_ip, $jsonapi_port, $jsonapi_username, $jsonapi_password, $jsonapi_salt);

$data = $api->call("getLatestChats");

$data = array_reverse($data["success"]);

foreach ($data as $message => $value)
{
	echo "<div style=\"width: 25%; float: left;\">".date("H:i", $data[$message]["time"])." ".$data[$message]["player"].":</div>";
	echo "<div style=\"width: 75%; float: left;\">".$data[$message]["message"]."</div>\n";
}

?>
</body>
</html>