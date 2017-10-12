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
$rowcount = 1;

	echo "<table class='table' width='100%' class='table'>
		<tr class='table_header'>
			<td colspan='8'>
				Images
			</td>
		</tr>
		<tr class='row3'>
			<td>Thumbnail</td>
			<td>Imagename</td>
			<td>Category</td>
			<td>Date uploaded</td>
			<td>Name / IP / E-Mail</td>
			<td>Description</td>
			<td>options</td>
		</tr>";


$query1 = mysql_query("SELECT * FROM ".$prefix."uploads ORDER BY upl_id");
while ($row1 = mysql_fetch_array($query1)) {
	$uplid = $row1['upl_id'];
	$uplname = $row1['upl_name'];
	$uplcategory = $row1['upl_category'];
		$query2 = mysql_query("SELECT * FROM ".$prefix."categories WHERE cat_id = ".$uplcategory);
		while ($row2 = mysql_fetch_array($query2)) {
			$catname = $row2['cat_name'];
		}
	$uplfilename = $row1['upl_filename'];
	$upldate = $row1['upl_date'];
	$upluploader = $row1['upl_uploader'];
	$uplemail = $row1['upl_email'];
	$uplip = $row1['upl_ip'];
	//$upldescription = $row1['upl_description'];
			$upldescription = htmlentities($row1['upl_description']);
			$upldescription = str_replace("\n", "<br>", $upldescription);

		echo "<tr class='row$rowcount'>
			<td><a href='../uploads/$uplfilename' target='_blank'><img border='0' src='../uploads/thumbs/$uplfilename'></a></td>
			<td>$uplname</td>
			<td>$catname</td>
			<td>$upldate</td>
			<td><a href='../useruploads.php?username=$upluploader'>$upluploader</a><br><a target='_blank' href='http://whois.domaintools.com/$uplip'>$uplip</a><br>$uplemail</td>
			<td>$upldescription</td>
			<td width='40'>
				<a href='submission_add.php?uplid=$uplid'><img border='0' src='images/add.png'></a>
				<a href='submission_delete.php?uplid=$uplid'><img border='0' src='images/delete.png'></a>
			</td>
		</tr>";

		$rowcount = $rowcount + 2;
		if ($rowcount == 5) {
			$rowcount = 1;
		}

}

	echo "</table><br>";






//echo "</table>";




require('include/footer.php');
?>