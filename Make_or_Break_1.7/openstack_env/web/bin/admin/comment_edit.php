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



if (isset($_POST['submit'])) {
?>
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Edit a category Results</td>
	</tr>
	<tr class="row1">
		<td>
<?php
//read out the faqs
$sql = "UPDATE ".$prefix."comment SET com_poster_name='$_POST[postername]', com_message='$_POST[message]'  WHERE com_id=".$comid; 
if (!mysql_query($sql)) {
	   die('Error: ' . mysql_error());
}
echo "Your comment is edited succesfully in the database.";



?>
		</td>
	</tr>
</table>
<?php
}


?>
<form action="comment_edit.php?comid=<?php echo $comid; ?>" method="post">
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td colspan="3">Edit a comment</td>
	</tr>

	<tr class="row1">
		<td>
<?php
$result = mysql_query("SELECT * FROM ".$prefix."comment WHERE com_id = ".$comid." ORDER BY com_id") or die("A MySQL error has occurred.<br />Your Query: " . $your_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
while($row1 = mysql_fetch_array($result)) {
	$comid = $row1['com_id'];
	$compostername = $row1['com_poster_name'];
	$commessage = $row1['com_message'];



?>
		</td>
	</tr>

	<tr class="row1">
		<td width="150">Comment Poster:</td>
		<td width="250"><br>
		<input type="text" name="postername" size="25" value="<?php echo $compostername; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row2">

		<td width="150">Comment Poster:</td>
		<td width="250"><br>
		<textarea rows="10" name="message" cols="40"><?php echo $commessage; ?></textarea><br>

&nbsp;</td>
	</tr>
	<tr class="row3">
		<td></td>
		<td><input type="submit" name="submit" value="Edit Comment" /></td>
	</tr>
	</table>
</form>




<?php

}

require('include/footer.php');

 ?>