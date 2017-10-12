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
			<td colspan='7'>My voted images.</td>
		</tr>
		<tr class='row3'>
			<td>Thumbnail</td>
			<td>Imagename</td>
			<td>Category name</td>
			<td>Date uploaded</td>
			<td>Name uploader</td>
			<td>Average</td>
			<td>Your vote</td>
		</tr>";


$query = mysql_query("SELECT * FROM ".$prefix."votes WHERE vote_ip='".$userip."'");
while ($row = mysql_fetch_array($query)) {
	$voteimageid = $row['vote_image_id'];
	$votepoints = $row['vote_points'];


	$query1 = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id=".$voteimageid);
	while ($row1 = mysql_fetch_array($query1)) {
		$imgid = $row1['img_id'];
		$imgname = $row1['img_name'];
		$imgcategory = $row1['img_category'];
			$query2 = mysql_query("SELECT * FROM ".$prefix."categories WHERE cat_id = ".$imgcategory);
			while ($row2 = mysql_fetch_array($query2)) {
				$catname = $row2['cat_name'];
			}
		$imgfilename = $row1['img_filename'];
		$imgdate = $row1['img_date'];
		$imguploader = $row1['img_uploader'];
		$imgtotalvotes = $row1['img_total_votes'];
		$imgtotalpoints = $row1['img_total_points'];
		$imgaverage = $row1['img_average'];
		$average = $imgtotalpoints / $imgtotalvotes;
			if ($average == "") {
				$average = 0;
			}

			echo "<tr class='row$rowcount'>
				<td><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></td>
				<td>$imgname</td>
				<td><a href='index.php?catid=$catid'>$catname</a></td>
				<td>$imgdate</td>
				<td>$imguploader</td>
				<td>$imgtotalpoints / $imgtotalvotes = $imgaverage</td>
				<td>$votepoints</td>
			</tr>";

			$rowcount = $rowcount + 2;
			if ($rowcount == 5) {
				$rowcount = 1;
			}

	}
}
	echo "</table><br>";






//echo "</table>";




require('include/footer.php');
?>