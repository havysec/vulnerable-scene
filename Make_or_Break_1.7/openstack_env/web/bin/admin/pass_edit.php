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
$usernameid = $_GET['username'];



if (isset($_POST['submit'])) {
?>	
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Change the password</td>
	</tr>
	<tr class="row1">
		<td>
		<span class="genmed">
<?php
$sql = "UPDATE ".$prefix."admin SET password='$_POST[password]' WHERE id=".$usernameid; 
if (!mysql_query($sql))
   {
   die('Error: ' . mysql_error());
   }
echo "Your password is edited succesfully in the database.";



?>
		</span></td>
	</tr>
</table>
<?php
}




$result = mysql_query("SELECT * FROM ".$prefix."admin WHERE username = 'admin' ORDER BY id");
while($row = mysql_fetch_array($result)) {
$username = $row['username'];
$password = $row['password'];


?>
<form action="pass_edit.php?username=<?php echo $usernameid; ?>" method="post">
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td colspan="3">Edit the password</td>
	</tr>
	<tr class="row1">
		<td width="120">
		Password: </td>
		<td>
		<br>
		<input type="password" name="password" size="20" value="<?php echo $password; ?>" /><br>
&nbsp;</td>
		<td width="75%">
 <input type="submit" name="submit" value="Edit Password" /></td>
	</tr>
	</table>
</form>
<?php
}







require('include/footer.php');

?>