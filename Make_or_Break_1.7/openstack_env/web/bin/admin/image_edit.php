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



if (isset($_POST['submit'])) {
	$totalpoints = $_POST[total_points];
	$totalvotes = $_POST[total_votes];
	$imgaverage = $totalpoints / $totalvotes;
	if ($totalpoints == 0) {
		$imgaverage = 0;
		$totalvotes = 0;
	}
	if ($totalvotes == 0) {
		$imgaverage = 0;
		$totalpoints = 0;
	}
	$sql = ("UPDATE ".$prefix."images SET img_average=".$imgaverage." WHERE `img_id`=".$imgid);
		if (!mysql_query($sql)) {
			die('Error: ' . mysql_error());
		}



?>
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Edit a Image Results</td>
	</tr>
	<tr class="row1">
		<td>
<?php
//read out the faqs
$sql = "UPDATE ".$prefix."images SET img_category='$_POST[category]', img_name='$_POST[name]', img_uploader='$_POST[uploader]', img_total_votes='$totalvotes', img_total_points='$totalpoints', img_description='$_POST[description]' WHERE img_id=".$imgid; 
if (!mysql_query($sql)) {
	   die('Error: ' . mysql_error());
}
echo "Your image is edited succesfully in the database.";



?>
		</td>
	</tr>
</table>
<?php
}


?>
<form action="image_edit.php?imgid=<?php echo $imgid; ?>" method="post">
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td colspan="2">Edit a image</td>
	</tr>

	<tr class="row1">
		<td>
<?php
$result = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id = ".$imgid." ORDER BY img_id") or die("A MySQL error has occurred.<br />Your Query: " . $your_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
while($row = mysql_fetch_array($result)) {
$imgid = $row['img_id'];
$imgname = $row['img_name'];
$imgdate = $row['img_date'];
$imguploader = $row['img_uploader'];
$imgtotalvotes = $row['img_total_votes'];
$imgtotalpoints = $row['img_total_points'];
$imgdescription = $row['img_description'];

//read out the faqs
?>
		</td>
	</tr>

	<tr class="row1">
		<td width="150">Category:</td>
		<td><br>
		
    <?php
    $sql = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id='".$imgid."' LIMIT 1");
    $result = mysql_fetch_array($sql);
    $imgcategory = $result['img_category'];
//echo $linkcategory;
    $query = mysql_query("SELECT * FROM ".$prefix."categories");
    ?>
    <select name='category'>
    <?php
    while ($accessrow = mysql_fetch_array($query)) {
    ?>
    <option value="<?php echo $accessrow['cat_id']; ?>" <?php if ($imgcategory == $accessrow['cat_id']) { echo 'selected'; } ?> ><?php echo $accessrow['cat_name']; ?></option><br><br>
    <?php } ?>
		
&nbsp;</select><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Image Name:</td>
		<td><br>
		<input type="text" name="name" size="30" value="<?php echo $imgname; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>Name Uploader:</td>
		<td><br>
		<input type="text" name="uploader" size="30" value="<?php echo $imguploader; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Total Votes:</td>
		<td><br>
		<input type="text" name="total_votes" size="6" value="<?php echo $imgtotalvotes; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>Total Points:</td>
		<td><br>
		<input type="text" name="total_points" size="10" value="<?php echo $imgtotalpoints; ?>" /><br>
&nbsp;</td>
	</tr>

	<tr class="row2">
		<td>Image Description:</td>
		<td><br>
		<textarea rows="7" name="description" cols="40"><?php echo $imgdescription; ?></textarea><br>
&nbsp;</td>
	</tr>

	<tr class="row3">
		<td>&nbsp;</td>
		<td><br>
		<input type="submit" name="submit" value="Edit Image" /><br>
&nbsp;</td>
	</tr>
</table>
</form>




<?php

}

require('include/footer.php');

 ?>