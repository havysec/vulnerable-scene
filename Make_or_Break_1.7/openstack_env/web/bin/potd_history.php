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



			$today = date('Y-m-d');

			$result5 = mysql_query("SELECT * FROM ".$prefix."potd WHERE potd_date = '$today'"); 
			$num_rows = mysql_num_rows($result5);
			if ($num_rows == 0) {
				$result5 = mysql_query( " SELECT * FROM ".$prefix."images ORDER BY RAND() LIMIT 0,1");	
				while ($row = mysql_fetch_array($result5)) {
					$imgid = $row['img_id'];
					$imgfilename = $row['img_filename'];
				}

				$sql="INSERT INTO ".$prefix."potd (potd_img_id, potd_date) VALUES ('$imgid', '$today')";
				if (!mysql_query($sql))
				{
					die('Error: ' . mysql_error());
				}
			}


$rowcount = 1;

	echo "<table class='table' width='100%' class='table'>
		<tr class='table_header'>
			<td colspan='7'>Picture of the day - History</td>
		</tr>
		<tr class='row3'>
			<td>Thumbnail</td>
			<td>Date</td>
			<td>Imagename</td>
			<td>Imagecategory</td>
			<td>Average</td>
		</tr>";


$query = mysql_query("SELECT * FROM ".$prefix."potd");
while ($row = mysql_fetch_array($query)) {
	$potdimgid = $row['potd_img_id'];
	$potddate = $row['potd_date'];


	$query1 = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id=".$potdimgid);
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

		$query3 = mysql_query("SELECT * FROM ".$prefix."votes WHERE vote_image_id='".$imgid."'");
		while ($row3 = mysql_fetch_array($query3)) {
			$voteimageid = $row3['vote_image_id'];
			$votepoints = $row3['vote_points'];
		}

			echo "<tr class='row$rowcount'>
				<td><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></td>
				<td>$potddate</td>
				<td>$imgname</td>
				<td><a href='index.php?catid=$catid'>$catname</a></td>
				<td>$imgtotalpoints / $imgtotalvotes = $imgaverage</td>

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