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
$comid = $_GET['comid'];
$result = mysql_query("SELECT * FROM ".$prefix."comment WHERE com_id = ".$comid." ORDER BY com_id");

while($row = mysql_fetch_array($result)) {
$comid = $row['com_id'];
$compostername = $row['com_poster_name'];
?>

<table class="table" width="100%">
	<tr class="table_header">
		<td>Delete a comment</td>
	</tr>
	<tr class="row1">
		<td>
			<form action="comment_delete.php?comid=<?php echo $comid ?>" method="post">
				<p align="center">Are you sure you want to delete the comment of: <b><?php echo $compostername; ?></b></p>
				<p align="center"><br><input type="submit" name="submit" value="Yes" />

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
		<td>Delete a comment results</td>
	</tr>
	<tr class="row1">
		<td>
			<?php
				$sql = "DELETE FROM ".$prefix."comment WHERE com_id=".$comid;
				if (!mysql_query($sql))
  				{
   					die('Error: ' . mysql_error());
   				}
 				echo "The comment is deleted succesfully from the database.";
			?>
		</td>
	</tr>
</table>
<?php
}



require('include/footer.php');
?>