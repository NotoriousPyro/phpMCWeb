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

// These are set manually for now... ;)
$language = "english";
$theme = "default";
$site_name = "phpMCWeb";

// Full URL to phpMCWeb (e.g. http://www.somesite.com/phpmcweb)
$site_url = "http://";

// JSONAPI settings
$jsonapi_ip = "localhost";
$jsonapi_port = 20059;
$jsonapi_username = "";
$jsonapi_password = "";
$jsonapi_salt = "";

// Full URL to Dynmap (ignore if you've deleted map.phtml from the pages directory)
// (e.g. http://www.somesite.com/dynmap)
$dynmap = "http://";

?>