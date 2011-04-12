<?php

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
			if (empty($this->files[$file + 1])) break;
			else echo "\t\t";
		}
	}
}

$pagehandler = new PageHandler();
$pagehandler->init();

?>