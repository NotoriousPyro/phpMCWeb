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

$version = "0.8.0";

// Please do not edit this line, if you wish to help develop phpMCWeb
// then please get in touch with me at craigcrawford1988 AT gmail DOT com
$phpmc["VERSION"] = nl2br(sprintf("<a class=\"version\" target=\"_blank\" href=\"http://forums.bukkit.org/threads/tool-web-info-phpmcweb.12642/\">phpMCWeb</a> %s by NotoriousPyro\n", $version));

?>