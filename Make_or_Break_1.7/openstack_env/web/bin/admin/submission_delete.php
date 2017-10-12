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

require('include/header.php');
$uplid = $_GET['uplid'];


$query1 = mysql_query("SELECT * FROM ".$prefix."uploads WHERE upl_id=".$uplid);
while ($row1 = mysql_fetch_array($query1)) {
	$uplfilename = $row1['upl_filename'];
}


$sql = "DELETE FROM ".$prefix."uploads WHERE upl_id=".$uplid;
if (!mysql_query($sql))
{
   	die('Error: ' . mysql_error());
}

?>
<table class="table" width="100%">
	<tr class="table_header">
		<th class="table_header" colspan="2">
		<p align="left">Add a category results</th>
	</tr>
	<tr>
		<td class="cell_content">
<?php

echo "The submission is deleted succesfully from the database.";
unlink("../uploads/".$uplfilename);
unlink("../uploads/thumbs/".$uplfilename);
			?>
		</td>
	</tr>
</table>
<?php




require('include/footer.php');
?>