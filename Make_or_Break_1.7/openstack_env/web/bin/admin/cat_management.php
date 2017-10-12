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



if (isset($_POST['submit'])) {
?>
<table class="table" width="100%">
	<tr class="table_header">
		<th class="table_header" colspan="2">
		<p align="left">Add a category results</th>
	</tr>
	<tr>
		<td class="cell_content">
<?php


$sql="SELECT MAX(cat_order) AS cat_order FROM ".$prefix."categories";
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
	$cat_order=$row["cat_order"]+1;
}

$sql="INSERT INTO ".$prefix."categories (cat_name)
 VALUES
 ('$_POST[category]')";
 
if (!mysql_query($sql))
   {
   die('Error: ' . mysql_error());
   }
 echo "Your category is added succesfully to the database.";



?>
		</span></td>
	</tr>
	</table>
<?php

}


?>
<form action="cat_management.php" method="post">
 <div align="center">
 <table class="table" width="100%">
	<tr class="table_header">
		<td class="table_header" colspan="3">Add a Category</td>
	</tr>
	<tr class="row1">
		<td width="150">Category Name:</td>
		<td width="250"> <br>
		<input type="text" name="category" size="25" /><br>
&nbsp;</td>
		<td> 
 <input type="submit" name="submit" value="Add Category" /></td>
	</tr>

	</table>
 </div>
 </form>
<?php


//==================================
//===edit delete cats===============
//==================================
?>
 <table class="table" width="35%">
	<tr class="table_header">
		<td class="table_header" colspan="3">Edit/Delete Category</td>
	</tr>

<?php
$row=1;
$query1 = mysql_query("SELECT * FROM ".$prefix."categories ORDER BY cat_name");
while ($row1 = mysql_fetch_array($query1)) {
	$catid = $row1['cat_id'];
	$catname = $row1['cat_name'];
?>

	<tr class="row<?php echo $row; ?>">
		<td width="20"><?php echo $catid; ?></td>
		<td width="150"><?php echo $catname; ?></td>
		<?php echo "<td width='40'>
			<a href='cat_edit.php?catid=$catid'><img border='0' src='images/edit.png'></a>
			<a href='cat_delete.php?catid=$catid'><img border='0' src='images/delete.png'></a>
		</td>
	</tr>";


$row=$row+1;
if ($row == 3) {
	$row=1;
}
}
?>

	</table>








<?php
require('include/footer.php');
?>