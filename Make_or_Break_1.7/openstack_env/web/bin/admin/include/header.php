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

require('../config.php');
require('include/functions.php');

mysql_connect("$host", "$username", "$password")or die("cannot connect to the database."); 
mysql_select_db("$db_name")or die("cannot select the database.");

$userip=$_SERVER['REMOTE_ADDR'];

$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = 1");
while($row = mysql_fetch_array($result)) {
	$pagename = $row['pagename'];
	$template = $row['template'];
	$maxfilesize = $row['filesize'];
}

session_start();
if ($_SESSION['loggedIn'] != "true") {
	 header("Location: login.php");
}


?>

<html>

<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?php echo $pagename; ?> - Admin Panel</title>
<?php
echo "<link href='../template/$template' rel='stylesheet' type='text/css' />";
?>
</head>

<body>

<div align="center">
	<table border="0" width="1024" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" colspan="2" width="1024">
			<p align="center"><b><font size="6"><?php echo $pagename; ?></font></b><font size="5"><br>
			admin panel</font><br><br></td>
		</tr>
		<tr>
			<td valign="top" width="150">
			


				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Menu:</td>
					</tr>
					<tr>
						<td class="cell_content">
						<a href="index.php">Admin home</a><br>
						<a href="../index.php">Main website</a><br><br>
						<a href="submissions_view.php">Submissions</a><br><br>
						<a href="cat_management.php">Cat management</a><br>
						<a href="comments_view.php">Comments control</a><br>
						<a href="image_upload.php">Upload Image</a><br><br>

						<a href="view_bans.php">View Bans</a><br>
						<a href="ban_add1.php">Ban Add</a><br><br>

						<a href="settings_edit.php?settings=1">Edit settings</a><br>
						<a href="pass_edit.php?username=1">Edit password</a><br>
						<br><a href="logout.php">Logout</a></td>
					</tr>
				</table>			
			
			
			
			</td>
			<td valign="top" width="850">