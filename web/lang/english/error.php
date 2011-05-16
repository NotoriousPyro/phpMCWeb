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

define("_ERROR_", "Error: ");
define("_FATAL_ERROR_", "Fatal error: ");
$phpmc["ERRORS"] = array(
	"PERMISSIONS"				=> _FATAL_ERROR_."Incorrect permissions.",
	"RETRIEVING_SAVING_SKIN"	=> _FATAL_ERROR_."Retrieving/saving Minecraft skin failed.",
	"INJECT_CAUGHT"				=> _FATAL_ERROR_."Inject attempt caught",
	"GENERATING_IMAGE"			=> _FATAL_ERROR_."Error generating image.",
	"NO_PLAYER_SPECIFIED"		=> _ERROR_."No player specified.",
);

?>