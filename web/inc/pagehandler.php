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

class PageHandler
{
	public $page;
	private $files;
	
	public function init()
	{
		$this->page = $_GET["page"];
		
		$this->GetPages();
	}
	
	private function GetPages()
	{
		$pages = opendir("./pages/");
		
		while ($file = readdir($pages))
		{
			if (preg_match("/.phtml$/",$file))
			{
				$files[] = preg_replace("/.phtml$/", "", $file);
			}
		}
		
		closedir($pages);
		
		return $this->files = $files;
	}
	
	public function CheckPageExists()
	{
		if (empty($this->files))
		{
			header("Location: news.php");
		}
		
		if (!$this->page || !in_array($this->page, $this->files))
		{
			header("Location: news.php");
		}
	}
	
	public function GetButtons()
	{
		foreach ($this->files as $file => $value)
		{
			echo "<div class=\"button\" onclick=\"navigate('./?page=".$this->files[$file]."')\"><span>".ucfirst($this->files[$file])."</span></div>\n";
			if (empty($this->files[$file + 1]))
			{
				break;
			}
			else
			{
				echo "\t\t";
			}
		}
	}
}

$pagehandler = new PageHandler();
$pagehandler->init();

?>