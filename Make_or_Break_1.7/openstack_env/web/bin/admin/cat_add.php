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
		<p align="left">Add a category</th>
	</tr>
	<tr>
		<td class="cell_content">
<?php
//read out the faqs


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
<form action="cat_add.php" method="post">
 <div align="center">
 <table class="table" width="100%">
	<tr class="table_header">
		<td class="table_header" colspan="2">Add a Category</td>
	</tr>
	<tr class="row1">
		<td width="150">Category Name:</td>
		<td> <br>
		<input type="text" name="category" size="15" /><br>
&nbsp;</td>
	</tr>

	<tr class="row3">
		<td>
 &nbsp;</td>
		<td>
 <p align="left"><br>
 <input type="submit" name="submit" value="Add Category" /><br>
&nbsp;</td>
	</tr>
	</table>
 </div>
 </form>
<?php
require('include/footer.php');
?>