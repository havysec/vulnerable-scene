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
$catid = $_GET['catid'];



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
$sql = "UPDATE ".$prefix."categories SET cat_name='$_POST[name]' WHERE cat_id=".$catid; 
if (!mysql_query($sql)) {
	   die('Error: ' . mysql_error());
}
echo "Your category is edited succesfully in the database.";



?>
		</td>
	</tr>
</table>
<?php
}


?>
<form action="cat_edit.php?catid=<?php echo $catid; ?>" method="post">
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td colspan="3">Edit a category</td>
	</tr>

	<tr class="row1">
		<td>
<?php
$result = mysql_query("SELECT * FROM ".$prefix."categories WHERE cat_id = ".$catid." ORDER BY cat_id") or die("A MySQL error has occurred.<br />Your Query: " . $your_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
while($row = mysql_fetch_array($result)) {
$catname = $row['cat_name'];


?>
		</td>
	</tr>

	<tr class="row1">
		<td width="150">Category Name:</td>
		<td width="250"><br>
		<input type="text" name="name" size="25" value="<?php echo $catname; ?>" /><br>
&nbsp;</td>
		<td>
		<input type="submit" name="submit" value="Edit Category" /></td>
	</tr>
	</table>
</form>




<?php

}

require('include/footer.php');

 ?>