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
$imgid = $_GET['imgid'];
$result = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id = ".$imgid." ORDER BY img_id");

while($row = mysql_fetch_array($result)) {
$imgid = $row['img_id'];
$imgname = $row['img_name'];
$imgfilename = $row['img_filename'];
?>

<table class="table" width="100%">
	<tr class="table_header">
		<td>Delete a link</td>
	</tr>
	<tr class="row1">
		<td>
			<form action="image_delete.php?imgid=<?php echo $imgid ?>" method="post">
				<p align="center">Are you sure you want to delete the image: <b><?php echo $imgname; ?></b><br>
				<img border='0' src='../uploads/thumbs/<?php echo $imgfilename; ?>'></p>
				<p align="center"><br>
				<input type="submit" name="submit" value="Yes" />

					<script>
					function goBack()
					   {
					   window.history.back()
					   }
					</script>
				
				<input type="button" value="No" onclick="goBack()" />
 			</form>
		</td>
	</tr>
</table>

<?php
}


if (isset($_POST['submit'])) {
?>
<br><br><table class="table" width="100%">
	<tr class="table_header">
		<td>Delete a image results</td>
	</tr>
	<tr class="row1">
		<td>
			<?php
				$sql = "DELETE FROM ".$prefix."images WHERE img_id=".$imgid;
				if (!mysql_query($sql))
  				{
   					die('Error: ' . mysql_error());
   				}
 				echo "Your image is deleted succesfully from the database.";
				unlink('../uploads/'.$imgfilename);
				unlink('../uploads/thumbs/'.$imgfilename);
			?>
		</td>
	</tr>
</table>
<?php
}



require('include/footer.php');
?>