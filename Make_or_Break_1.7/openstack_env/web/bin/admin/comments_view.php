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
			<td colspan='6'>
				Images
			</td>
		</tr>
		<tr class='row3'>
			<td>Thumb</td>
			<td>Image name</td>
			<td>Name and IP</td>
			<td>Date posted</td>
			<td>Message</td>
			<td>options</td>
		</tr>";


$query1 = mysql_query("SELECT * FROM ".$prefix."comment ORDER BY com_id");
while ($row1 = mysql_fetch_array($query1)) {
	$comid = $row1['com_id'];
	$comimgid = $row1['com_img_id'];
		$query2 = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id = ".$comimgid);
		while ($row2 = mysql_fetch_array($query2)) {
			$imgid = $row2['img_id'];
			$imgname = $row2['img_name'];
			$imgfilename = $row2['img_filename'];
		}
	$compostername = $row1['com_poster_name'];
	$comdate = $row1['com_date'];
	$composterip = $row1['com_poster_ip'];

	$commessage = htmlentities($row1['com_message']);
	$commessage = str_replace("\n", "<br>", $commessage);
	$commessagecount = strlen($commessage);
	$commessage = substr($commessage, 0, 100);



		echo "<tr class='row$rowcount'>
			<td valign='top'><a target='_blank' href='../index.php?imgid=$imgid'><img border='0' src='../uploads/thumbs/$imgfilename'></td>
			<td valign='top'>$imgname</td>
			<td valign='top'>$compostername<br>
			<a target='_blank' href='http://whois.domaintools.com/$composterip'>$composterip</a></td>
			<td valign='top'>$comdate</td>
			<td valign='top'>
				$commessage";
				if ($commessagecount > 100) {
					echo " ...";
				}

			echo "</td>
			<td  valign='top' width='40'>
				<a href='comment_edit.php?comid=$comid'><img border='0' src='images/edit.png'></a>
				<a href='comment_delete.php?comid=$comid'><img border='0' src='images/delete.png'></a>
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