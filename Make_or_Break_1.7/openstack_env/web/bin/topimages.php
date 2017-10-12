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
?>


<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
	
	
	
		<td valign="top">
			<table class="table" width="100%">
				<tr class="table_header">
					<td colspan="2">Top <?php echo $topimages; ?> Best Voted</td>
				</tr>
				<?php
					$row=1;
					$query1 = mysql_query("SELECT * FROM ".$prefix."images ORDER BY img_average DESC LIMIT 10");
					while ($row1 = mysql_fetch_array($query1)) {
						$imgid = $row1['img_id'];
						$imgname = $row1['img_name'];
						$imgcategory = $row1['img_category'];
						$imgfilename = $row1['img_filename'];
						$imgdate = $row1['img_date'];
						$imguploader = $row1['img_uploader'];
						$imgtotalvotes = $row1['img_total_votes'];
						$imgaverage  = $row1['img_average'];

						echo "<tr class='row$row'>
							<td width='100'><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a></td>
							<td valign='top'>
								Name: $imgname<br>
								Date: $imgdate<br>
								Average: $imgaverage<br>
								Total Votes: $imgtotalvotes
							</td>
						</tr>";

						$row=$row+1;
						if ($row == 3) {
							$row=1;
						}
					}
				?>
				</table>
			</td>
		
		
		



		<td width="20">
			&nbsp;</td>







		<td  valign="top">
			<table class="table" width="100%">
				<tr class="table_header">
					<td colspan="2">Top <?php echo $topimages; ?> Most Voted</td>
				</tr>
				<?php
					$row=1;
					$query1 = mysql_query("SELECT * FROM ".$prefix."images ORDER BY img_total_votes DESC LIMIT 10");
					while ($row1 = mysql_fetch_array($query1)) {
						$imgid = $row1['img_id'];
						$imgname = $row1['img_name'];
						$imgcategory = $row1['img_category'];
						$imgfilename = $row1['img_filename'];
						$imgdate = $row1['img_date'];
						$imguploader = $row1['img_uploader'];
						$imgtotalvotes = $row1['img_total_votes'];
						$imgaverage  = $row1['img_average'];

						echo "<tr class='row$row'>
							<td width='100'><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a></td>
							<td valign='top'>
								Name: $imgname<br>
								Date: $imgdate<br>
								Average: $imgaverage<br>
								Total Votes: $imgtotalvotes
							</td>
						</tr>";

						$row=$row+1;
						if ($row == 3) {
							$row=1;
						}
					}
				?>
				</table>
			</td>







	</tr>
	<tr>
		<td><br></td>
		<td>&nbsp;</td>
		<td>
			&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">
			<table class="table" width="100%">
				<tr class="table_header">
					<td colspan="2">Top <?php echo $topimages; ?> Newest Images</td>
				</tr>
				<?php
					$row=1;
					$query1 = mysql_query("SELECT * FROM ".$prefix."images ORDER BY img_date DESC LIMIT 10");
					while ($row1 = mysql_fetch_array($query1)) {
						$imgid = $row1['img_id'];
						$imgname = $row1['img_name'];
						$imgcategory = $row1['img_category'];
						$imgfilename = $row1['img_filename'];
						$imgdate = $row1['img_date'];
						$imguploader = $row1['img_uploader'];
						$imgtotalvotes = $row1['img_total_votes'];
						$imgaverage  = $row1['img_average'];

						echo "<tr class='row$row'>
							<td width='100'><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a></td>
							<td valign='top'>
								Name: $imgname<br>
								Date: $imgdate<br>
								Average: $imgaverage<br>
								Total Votes: $imgtotalvotes
							</td>
						</tr>";

						$row=$row+1;
						if ($row == 3) {
							$row=1;
						}
					}
				?>
				</table>
			</td>
		<td>&nbsp;</td>
		<td valign="top">
			<table class="table" width="100%">
				<tr class="table_header">
					<td colspan="2">All images</td>
				</tr>
				<?php
					$row=1;
					$query1 = mysql_query("SELECT * FROM ".$prefix."images ORDER BY img_id");
					while ($row1 = mysql_fetch_array($query1)) {
						$imgid = $row1['img_id'];
						$imgname = $row1['img_name'];
						$imgcategory = $row1['img_category'];
						$imgfilename = $row1['img_filename'];
						$imgdate = $row1['img_date'];
						$imguploader = $row1['img_uploader'];
						$imgtotalvotes = $row1['img_total_votes'];
						$imgaverage  = $row1['img_average'];

						echo "<tr class='row$row'>
							<td width='100'><a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a></td>
							<td valign='top'>
								Name: $imgname<br>
								Date: $imgdate<br>
								Average: $imgaverage<br>
								Total Votes: $imgtotalvotes
							</td>
						</tr>";

						$row=$row+1;
						if ($row == 3) {
							$row=1;
						}
					}
				?>
				</table>
			</td>
	</tr>
</table>


<?php
require('include/footer.php');
?>