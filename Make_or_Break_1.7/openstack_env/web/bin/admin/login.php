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

$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = 1");
while($row = mysql_fetch_array($result)) {
	$pagename = $row['pagename'];
	$template = $row['template'];
}
?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?php echo $pagename; ?> - Admin Login</title>
<link href="../template/basic.css" rel="stylesheet" type="text/css" />
</head>

<body>

<form name="form1" method="post" action="include/checklogin.php">
<div align="center">
<table class="table" width="300" class="table">
	<tr class="table_header">
		<td colspan="2"><?php echo $pagename; ?> - Admin Login</td>
	</tr>
	<tr class="row1">
		<td>Username</td>
		<td><input name="username" type="text" id="username"></td>
	</tr>
	<tr class="row1">
		<td>Password</td>
		<td><input name="password" type="password" id="password"></td>
	</tr>
	<tr class="row1">
		<td>&nbsp;</td>
		<td><br><input type="submit" name="Submit" value="Admin Login"></td>
	</tr>
</table>
</div>
</form>

<p align="center"><br>Powered by <a href="http://www.friendsinwar.com" class="copyright">Make or Break</a> © 2012 Friends in War</p>

</body>

</html>