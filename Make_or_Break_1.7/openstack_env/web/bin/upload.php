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
require('admin/include/functions.php');

if (isset($_POST['submit'])) {
echo "<table class='table' width='100%'>
	<tr class='table_header'>
		<td>Image upload results</td>
	</tr>
	<tr class='row1'>
		<td>";


	session_start();
	if (md5($_POST['norobot']) == $_SESSION['randomnr2'])	{

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
			//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
 
			if (file_exists("uploads/" . $_FILES["file"]["name"]))
			{
				echo $_FILES["file"]["name"] . " already exists. ";
			} else {

				if ($_POST[category] == 0) {
					echo "<br><font color='#FF0000'>You have to select a category</font><br><br>";
				} else {

					$now = date('Y-m-d');
					$sql="INSERT INTO ".$prefix."uploads (upl_name, upl_category, upl_filename, upl_description, upl_date, upl_uploader, upl_email, upl_ip) VALUES
					('$_POST[imgname]', '$_POST[category]', '". $_FILES["file"]["name"] . "', '$_POST[description]', '$now', '$_POST[username]', '$_POST[email]', '$userip')";
					if (!mysql_query($sql))
					{
						die('Error: ' . mysql_error());
					} else {
						move_uploaded_file($_FILES["file"]["tmp_name"],
						"uploads/". $_FILES["file"]["name"]);
						//echo "Stored in: " . "uploads/". $_FILES["file"]["name"] . "<br />";
						createThumbs("uploads/","uploads/thumbs/",100);
						echo "<center><img border='0' src='uploads/thumbs/". $_FILES["file"]["name"]."'>";
						echo "<br><br><br><Thank you for uploading your image.<br>A admin will review you submission soon.</center><br><br>";
					}
				}
			}
		}
	} else {
		echo "Invalid file";
	}


	} else {  
		echo "<center>Oops, Wrong Captcha code.<br>Please try again.</center><br><br>";

	}


		echo "</td>
	</tr>
</table><br>";


}


?>






<form action="upload.php" method="post" enctype="multipart/form-data">
<table class="table" width="100%">
	<tr class="table_header">
		<td colspan="3">Upload a image</td>
	</tr>


	<tr class="row1">
		<td width="200">
			<br>
			Image Name:<br>
&nbsp;</td>
		<td colspan='2'>
			<input type="text" name="imgname" size="25" /></td>
	</tr>




	<tr class="row2">
		<td><br>
		Image Category:<br>
&nbsp;</td>
		<td colspan='2'>
		
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
			<OPTION VALUE=0>Choose
			<?php echo $options?>
			</SELECT><br>
&nbsp;</td>
	</tr>





	<tr class="row1">
		<td>
				<br>
				Filename: <br>
&nbsp;</td>
		<td colspan='2'>
				<input type="file" name="file" id="file" /> 
				Max <?php echo $maxfilesize; ?> KB</td>
	</tr>

	<tr class="row2">
		<td valign="top">
		<br>
		Image Decription:<br>
&nbsp;</td>
		<td colspan='2'>
			<textarea rows="7" name="description" cols="40"></textarea></td>
	</tr>

	<tr class="row1">
		<td>
		<br>
		Your Name<br>
&nbsp;</td>
		<td colspan='2'>
			<input type="text" name="username" size="25" /></td>
	</tr>

	<tr class="row2">
		<td>
		<br>
		Your E-Mail Adress<br>
&nbsp;</td>
		<td colspan='2'>
			<input type="text" name="email" size="25" /></td>
	</tr>


	<tr class='row1'>
		<td><br>
			Captcha Code:<br>
		</td>
		<td width='98'>
			<input class='input' type='text' name='norobot' size='8' />
		</td>
		<td width='438'>
			<br>
			<img src='include/captcha.php' /><br><br>
		</td>
	</tr>



	<tr class="row3">
		<td>
		&nbsp;</td>
		<td colspan='2'>
		<br>
				<input type="submit" name="submit" value="Submit" /><br>
&nbsp;</td>
	</tr>

</table>
</form>
<?php

require('include/footer.php');
?>