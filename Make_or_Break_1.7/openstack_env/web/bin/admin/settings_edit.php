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
$settingsid = $_GET['settings'];




if (isset($_POST['submit'])) {
?>	
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Change Settings</td>
	</tr>
	<tr class="row1">
		<td>
		<span class="genmed">
<?php
$sql = "UPDATE ".$prefix."settings SET pagename='$_POST[pagename]', slogan='$_POST[slogan]', script_url='$_POST[scripturl]', email='$_POST[email]', filesize='$_POST[filesize]', template='$_POST[template]', hitcounterimg='$_POST[hitcounterimg]', topimages='$_POST[topimages]', advertising='$_POST[advertising]' WHERE id=".$settingsid; 
if (!mysql_query($sql))
   {
   die('Error: ' . mysql_error());
   }
 echo "Your settings are edited succesfully in the database.";
?>
		</span></td>
	</tr>
</table>
<?php
}





$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = ".$settingsid." ORDER BY id");
while($row = mysql_fetch_array($result)) {
$pagename = $row['pagename'];
$slogan = $row['slogan'];
$scripturl = $row['script_url'];
$email = $row['email'];
$filesize = $row['filesize'];
$template = $row['template'];
$hitcounterimg = $row['hitcounterimg'];
$topimages = $row['topimages'];
$advertising = $row['advertising'];
?>



<form action="settings_edit.php?settings=<?php echo $settingsid; ?>" method="post">
<table class="table" border="0" width="100%">
	<tr class="table_header">
		<td colspan="2">Edit settings</td>
	</tr>
	<tr class="row2">
		<td width="200">
		Header Name: </td>
		<td>
		<br>
		<input name="pagename" size="20" value="<?php echo $pagename; ?>" /><br>&nbsp;</td>
	</tr>
	<tr class="row1">
		<td width="200">
		Slogan: </td>
		<td>
		<br>
		<input name="slogan" size="40" value="<?php echo $slogan; ?>" /><br>&nbsp;</td>
	</tr>
	<tr class="row2">
		<td width="200">
		Script url: </td>
		<td>
		<br>
		<input name="scripturl" size="40" value="<?php echo $scripturl; ?>" /> with '/' at the end of the url.<br>&nbsp;</td>
	</tr>
	<tr class="row1">
		<td width="200">
		<br>
		Your E-Mail<br>
&nbsp;</td>
		<td>
		<input name="email" size="30" value="<?php echo $email; ?>" /></td>
	</tr>

	<tr class="row2">
		<td width="200">
		<br>
		Maximum image filesize<br>
&nbsp;</td>
		<td>
		<input name="filesize" size="5" value="<?php echo $filesize; ?>" /> KB</td>
	</tr>


	<tr class="row1">
		<td width="200">
		template: </td>
		<td><br>
		<select size="5" name="template">
			<?php
				$directory = "../template/";
				$images = glob($directory . "*.css");
				foreach($images as $image)

				{
					$files = str_replace($directory, "", $image);
					echo "<option";

					if ($template == $files) 
						echo " selected";
					


					echo ">";
					echo $files;
					echo "</option>";
				}
			?>
		</select>
		<br><br></td>
	</tr>



	<tr class="row2">
		<td width="200">
		Counter Image: </td>
		<td><br>
			<?php
				$directory1 = "../counterimages/";
				$images1 = glob($directory1 . "*.gif");
				foreach($images1 as $image1)
				{
					$files1 = str_replace($directory1, "", $image1);
					$dirname = substr($files1, 0, -4);  
					echo "<input type='radio' value='".$dirname."' name='hitcounterimg'";

					if ($hitcounterimg == $dirname) {
						echo " checked";
					}
							
					echo ">";
					echo "<img border='0' src='../counterimages/".$files1."'><br>";
				}
			?>
		<br></td>
	</tr>

	<tr  class="row1">
		<td width="200">
		<br>
		Toplist images<br>
&nbsp;</td>
		<td>
		<input name="topimages" size="5" value="<?php echo $topimages; ?>" /></td>
	</tr>
	<tr  class="row2">
		<td width="200" valign="top">
		<br>
		Header advertising:<br>
		<br>
		<i><font size="2">Leave this box emty when you don't want to show 
		anything.</font></i><br>
		<br>
		<b><u><font size="2">use HTML here ontherwise it will not show your 
		advertising correctly.</font></u></b><br>
&nbsp;</td>
		<td>
		<br>
		<textarea rows="8" name="advertising" cols="36"><?php echo $advertising; ?></textarea><br>
&nbsp;</td>
	</tr>


	<tr class="row3">
		<td width="150">
		&nbsp;</td>
		<td>
 <br>
 <input type="submit" name="submit" value="Edit Settings" /><br>&nbsp;</td>
	</tr>
	</table>
</form>

<?php

}

require('include/footer.php');

?>