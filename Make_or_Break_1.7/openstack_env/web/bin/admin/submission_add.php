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
	$upldescription = $row1['upl_description'];
}



$result = mysql_query("SELECT * FROM ".$prefix."images ORDER BY `img_id` DESC LIMIT 1");
while($row = mysql_fetch_array($result)) {
	$maxid = $row['img_id'];
	$maxid = $maxid+1;
}

$sql="INSERT INTO ".$prefix."images (img_name, img_category, img_filename, img_date, img_uploader, img_uploader_ip, img_description) VALUES
('$uplname', '$uplcategory', '".$maxid."_".$uplfilename."', '$upldate', '$upluploader', '$uplip', '$upldescription')";
if (!mysql_query($sql))
{
	die('Error: ' . mysql_error());
} else {
	rename("../uploads/".$uplfilename, "../uploads/".$maxid."_".$uplfilename);
	rename("../uploads/thumbs/".$uplfilename, "../uploads/thumbs/".$maxid."_".$uplfilename);
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
			The Submission is added succesfully to the database.
		</td>
	</tr>
</table>
<?php



}




require('include/footer.php');
?>