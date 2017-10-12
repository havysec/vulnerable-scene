<?php
/************************************************************************
 * This file is part of Make or Break.					*
 *									*
 * Make or Break is free software: you can redistribute it and/or modify*
 * it under the terms of the GNU General Public License as published by	*
 * the Free Software Foundation, either version 3 of the License, or	*
 * (at your option) any later version.					*
 *									*
 * Make or Break is distributed in the hope that it will be useful,	*
 * but WITHOUT ANY WARRANTY; without even the implied warranty of	*
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the	*
 * GNU General Public License for more details.				*
 *									*
 * You should have received a copy of the GNU General Public License	*
 * along with Make or Break.  If not, see <http://www.gnu.org/licenses>.*
 ************************************************************************/

function newimage() 
{
	if (isset($_GET["catid"])) {
		echo "Click <a href='index.php?catid=".$_GET["catid"]."'>here</a> to get a new image.</center>";
	} else {
		echo "Click <a href='index.php'>here</a> to get a new image.</center>";
	}
}


function newvoteincat() 
{
	if (isset($_GET["catid"])) {
		echo "<form action='index.php?catid=".$_GET["catid"]."' method='post'>";
	} else {
		echo "<form action='index.php' method='post'>";
	}
}

			
?>