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
	$result = mysql_query("SELECT * FROM ".$prefix."images ORDER BY `img_id` DESC LIMIT 1");
	while($row = mysql_fetch_array($result)) {
		$maxid = $row['img_id'];
		$maxid = $maxid+1;
	}

echo "<table class='table' width='100%'>
	<tr class='table_header'>
		<td>Image upload results</td>
	</tr>
	<tr class='row1'>
		<td>";
	$maxfilesize = $maxfilesize*1024;
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/pjpeg"))
	&& ($_FILES["file"]["size"] < $maxfilesize)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		} else {
			echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
 
			if (file_exists("../uploads/" . $_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . " already exists. ";
			} else {

				if ($_POST[category] == 0) {
					echo "<br><font color='#FF0000'>You have to select a category</font><br><br>";
				} else {

					$now = date('Y-m-d');
					$sql="INSERT INTO ".$prefix."images (img_name, img_category, img_filename, img_date, img_uploader, img_uploader_ip, img_description) VALUES
					('$_POST[imgname]', '$_POST[category]', '" . $maxid ."_". $_FILES["file"]["name"] . "', '$now', 'admin', '$userip', '$_POST[description]')";
					if (!mysql_query($sql))
					{
						die('Error: ' . mysql_error());
					} else {
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"../uploads/". $maxid ."_". $_FILES["file"]["name"]);
						echo "Stored in: " . "../uploads/" . $maxid ."_". $_FILES["file"]["name"] . "<br />";
						createThumbs("../uploads/","../uploads/thumbs/",100);
						echo "<img border='0' src='../uploads/thumbs/".$maxid ."_". $_FILES["file"]["name"]."'>";
					}
				}
			}
		}
	} else {
		echo "Invalid file";
	}

		echo "</td>
	</tr>
</table><br>";


}


?>






<form action="image_upload.php" method="post" enctype="multipart/form-data">
<table class="table" width="100%">
	<tr class="table_header">
		<td colspan="2">Upload a image</td>
	</tr>


	<tr class="row2">
		<td>
				<br>
				Filename: <br>
&nbsp;</td>
		<td>
				<input type="file" name="file" id="file" /> 
				</td>
	</tr>




	<tr class="row1">
		<td width="200">
			<br>
			image Name:<br>
&nbsp;</td>
		<td>
			<input type="text" name="imgname" size="25" /></td>
	</tr>




	<tr class="row2">
		<td><br>
		Image Category:<br>
&nbsp;</td>
		<td>
		
					<br>
		
					<?php
			$sql="SELECT cat_id, cat_name FROM ".$prefix."categories ORDER BY cat_name ASC";
			$result=mysql_query($sql);
			$options="";
			while ($row=mysql_fetch_array($result)) {
				$id=$row["cat_id"];
				$name=$row["cat_name"];
				$options.="<OPTION VALUE=\"$id\">".$name.'</option>';
			}
			?>
			<SELECT NAME=category>
			<OPTION VALUE=0>Choose category
			<?php echo $options?>
			</SELECT><br>
&nbsp;</td>
	</tr>





	<tr class="row1">
		<td valign="top">
		<br>
		Image Description:<br>
&nbsp;</td>
		<td>
		<br>
		<textarea rows="7" name="description" cols="40"></textarea><br>
&nbsp;</td>
	</tr>

	<tr class="row3">
		<td>
		&nbsp;</td>
		<td>
		<br>
				<input type="submit" name="submit" value="Submit" /><br>
&nbsp;</td>
	</tr>

</table>
</form>
<?php

require('include/footer.php');
?>