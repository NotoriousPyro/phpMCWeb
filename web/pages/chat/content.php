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

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body,td,th 
{
	font-family: "Lucida Console", Monaco, monospace;
	font-size: 11px;
}
</style>
</head>

<body><?php

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

?></body>
</html>