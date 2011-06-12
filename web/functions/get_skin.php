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

define("___ACCESS", TRUE);

require("../includes.php");

$player = $_GET["player"];
$url = "http://minecraft.net/skin/%s.png";
$imageurl = sprintf($url, $player);
$savepath = "../cache/players/";
$minupdate = 3600;

$player_original = $savepath.$player."_original.png";
$player_generated = $savepath.$player."_generated.png";

try
{
	if ($player !== "")
	{
		if (!preg_match("/^[A-Za-z0-9_]+$/", $player))
		{
			throw new Exception($phpmc["ERRORS"]["INJECT_CAUGHT"]);
		}
		
		if (substr(sprintf("%o", fileperms($savepath)), -4) != "0777")
		{
			if (!chmod($savepath, 0777))
			{
				throw new Exception($phpmc["ERRORS"]["PERMISSIONS"]);
			}
		}
		
		if (!file_exists($player_original) || time() - filemtime($player_original) > $minupdate)
		{
			$headers = get_headers($imageurl);
			if ($headers[16] != "HTTP/1.1 200 OK")
			{
				$imageurl = $savepath."../default.png";
				if (!file_exists($imageurl))
				{
					if (!file_put_contents($imageurl, file_get_contents("http://minecraft.net/img/char.png")))
					{
						throw new Exception($phpmc["ERRORS"]["RETRIEVING_SAVING_SKIN"]);
					}
				}
			}
			if (!file_put_contents($player_original, file_get_contents($imageurl)))
			{
				throw new Exception($phpmc["ERRORS"]["RETRIEVING_SAVING_SKIN"]);
			}
		}
		
		if (!file_exists($player_generated) || time() - filemtime($player_generated) > $minupdate)
		{
			$generated = imagecreatetruecolor(64, 124);
			
			if (!$generated)
			{
				throw new Exception($phpmc["ERRORS"]["GENERATING_IMAGE"]);
			}
			
			imagesavealpha($generated, TRUE);
			$alpha = imagecolorallocatealpha($generated, 0, 0, 0, 127);
			imagefill($generated, 0, 0, $alpha);
			
			$original = imagecreatefrompng($player_original);
			
			if (!$original)
			{
				throw new Exception($phpmc["ERRORS"]["GENERATING_IMAGE"]);
			}
			
			imagecopyresized($generated, $original, 16, 0, 7, 8, 32, 28, 10, 8);
			imagecopyresized($generated, $original, 16, 0, 39, 8, 32, 28, 10, 8);
			imagecopyresized($generated, $original, 0, 28, 44, 20, 16, 48, 4, 12);
			imagecopyresized($generated, $original, 16, 28, 20, 20, 32, 48, 8, 12);
			imagecopyresized($generated, $original, 16, 76, 4, 20, 16, 48, 4, 12);
			imagedestroy($original);
			imagecopy($generated, $generated, 48, 28, 12, 28, 4, 48);
			imagecopy($generated, $generated, 52, 28, 8, 28, 4, 48);
			imagecopy($generated, $generated, 56, 28, 4, 28, 4, 48);
			imagecopy($generated, $generated, 60, 28, 0, 28, 4, 48);
			imagecopy($generated, $generated, 44, 76, 16, 76, 4, 48);
			imagecopy($generated, $generated, 40, 76, 20, 76, 4, 48);
			imagecopy($generated, $generated, 36, 76, 24, 76, 4, 48);
			imagecopy($generated, $generated, 32, 76, 28, 76, 4, 48);
			
			imagepng($generated, $player_generated);
			imagedestroy($generated);
		}
		
		$display = imagecreatefrompng($player_generated);
		imagesavealpha($display, TRUE);
		
		header("Content-type: image/png");
		imagepng($display);
		imagedestroy($display);
	}
	else
	{
		throw new Exception($phpmc["ERRORS"]["NO_PLAYER_SPECIFIED"]);
	}
}
catch (Exception $e)
{
	die($e);
}

?>