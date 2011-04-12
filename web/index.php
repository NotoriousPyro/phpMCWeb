<?php
define("___ACCESS", TRUE);

require("includes.php");

$pagehandler->CheckPageExists();

require_once("theme/".$theme."/main.phtml");

?>