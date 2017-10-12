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
mysql_connect("$host", "$username", "$password")or die("cannot connect to the database."); 
mysql_select_db("$db_name")or die("cannot select the database.");

$domain = $_SERVER['SERVER_NAME'];
$url = $_SERVER['PHP_SELF'];
$path = str_replace("install/index.php", "", "http://".$domain.$url);

$installed = 0;
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Make or Break - Setup</title>
<link href="../template/basic.css" rel="stylesheet" type="text/css" />
</head>

<body>


<div align="center">
<table class="table">
	<tr class="table_header">
		<td colspan="2">Setup - Database settings</td>
	</tr>
	<tr class="row1">
		<td>Hostname:</td>
		<td><b><?php echo $host; ?></b></td>
	</tr>
	<tr class="row1">
		<td>DB Username:</td>
		<td><b><?php echo $username; ?></b></td>
	</tr>
	<tr class="row1">
		<td>DB Password:</td>
		<td><b>********</b></td>
	</tr>
	<tr class="row1">
		<td>DB Name:</td>
		<td><b><?php echo $db_name; ?></b></td>
	</tr>
	<tr class="row1">
		<td>DB Prefix:</td>
		<td><b><?php echo $prefix; ?></b></td>
	</tr>
	<tr class="row1">
		<td colspan="2">
			<br><p align="center">

				<?php
				$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = 1");
				while($row = mysql_fetch_array($result)) {
					//$installed = $row['installed'];
					if ($row['installed'] == 1) {
						echo "<b>Make or Break already exist with prefix: <br><u>".$prefix."</u><br><br>
						Please choose a other prefix.</b>";
						exit;
					}
				}
						echo "<center><b>Connection with the database is made.<br>We can install Make or Break.</b></center>";
				?>
				</td>
	</tr>

	<tr class="row1">
		<td colspan="2">
		<form method='post' action='index.php'>
			<p align="center">&nbsp;</p>
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr class="row1">
					<td>Website Name:</td>
					<td>
			<input type="text" name="pagename" size="20" value="Make or Break"></td>
				</tr>
				<tr>
					<td>Your E-Mail:</td>
					<td>
			<input type="text" name="email" size="20" value="your@email.com"></td>
				</tr>
				<tr>
					<td>Script Url:</td>
					<td>
			<input type="text" name="scripturl" size="40" value="<?php echo $path; ?>"> 
			Please end with a '<font color="#FF0000">/</font>' </td>
				</tr>
				<tr>
					<td colspan="2">
					<p align="center"><br>
					<input type='submit' name='submit' value='Install Make or Break'></td>
				</tr>
			</table>
		</form>
		</td>
	</tr>

	<tr class="row3">
		<td colspan="2"><b>
			<?php
				if(isset($_POST['submit']))
				{
					include ('sql.php');
					echo "<center><br>Make or Break is installed correctly.<br><br>";
					echo "You can now go to the:<br>";
					echo "<a href='../admin/index.php'>Admin Panel</a><br>";
					echo "(username=admin and password=password)";
					echo "<br>";
					echo "<a href='../index.php'>Make or Break</a><br></center>";
				}
			?>
		</b></td>
	</tr>
</table>
</div>



<?php

?>