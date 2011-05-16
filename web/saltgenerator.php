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
?><pre>Enter the password that you require a salt for.<br />
Passwords must be more 8 or more characters.<br />
You require both the salt and original password to use phpMCWeb &amp; JSONAPI</pre>
<form id="form1" name="form1" method="post" action="saltgenerator.php">
	<input type="text" name="password" />
	<input type="submit" name="button" value="Generate!" />
</form>
<?php

$password = $_POST["password"];

function GenerateKey()
{
	$string = "";
	$possible = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	
	for($i=0; $i < 40; $i++)
	{
		$char = $possible[mt_rand(0, strlen($possible)-1)];
		$string .= $char;
	}
	
	return $string;
}

echo "<pre>";
if ($password != "" && strlen($password) >= 8)
{
	$key = GenerateKey();
	
	echo "Salt: ".crypt($password, "$5$rounds=".rand(1000, 999999)."$".$key."$");
}
echo "</pre>";

?>