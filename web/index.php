<?php
define("___ACCESS", TRUE);

require("includes.php");
require("inc/loadtimer.php");
require("inc/pagehandler.php");

$pagehandler->CheckPageExists();

require_once("theme/".$theme."/main.phtml");

?>