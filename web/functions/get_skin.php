<?php

$player = $_GET["player"];
$url = "http://minecraft.net/skin/%s.png";
$imageurl = vsprintf($url, $player);
$savepath = "../content/players/";
$minupdate = 3600;

$player_original = $savepath.$player."_original.png";
$player_generated = $savepath.$player."_generated.png";

try
{
	if (substr(vsprintf("%o", fileperms($savepath)), -4) != "0777")
	{
		if (!chmod($savepath, 0777))
		{
			throw new Exception("Permissions error");
		}
	}
	if (!file_exists($player_original) || time() - filemtime($player_original) > $minupdate)
	{
		$headers = get_headers($imageurl);
		if ($headers[16] != "HTTP/1.1 200 OK")
		{
			$imageurl = "http://minecraft.net/img/char.png";
		}
		if (!file_put_contents($player_original, file_get_contents($imageurl)))
		{
			throw new Exception("Error retrieving/saving Minecraft skin");
		}
	}
	
	if (!file_exists($player_generated) || time() - filemtime($player_generated) > $minupdate)
	{
		$width = 64;
		$height = 124;
		
		$generated = imagecreatetruecolor($width, $height);
		
		if (!$generated)
		{
			throw new Exception("Error generating image.");
		}
		
		imagesavealpha($generated, TRUE);
		$alpha = imagecolorallocatealpha($generated, 0, 0, 0, 127);
		imagefill($generated, 0, 0, $alpha);
		
		$original = imagecreatefrompng($player_original);
		
		if (!$original)
		{
			throw new Exception("Error generating image.");
		}
		
		imagecopyresized($generated, $original, 16, 0, 7, 8, 32, 28, 10, 8);
		imagecopyresized($generated, $original, 16, 0, 39, 8, 32, 28, 10, 8);
		imagecopyresized($generated, $original, 0, 28, 44, 20, 16, 48, 4, 12);
		imagecopyresized($generated, $original, 16, 28, 20, 20, 32, 48, 8, 12);
		imagecopyresized($generated, $original, 16, 76, 4, 20, 16, 48, 4, 12);
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
catch (Exception $e)
{
	die($e);
}

?>