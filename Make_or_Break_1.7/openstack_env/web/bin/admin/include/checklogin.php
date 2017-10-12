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

session_start(); // Start a new session
require('../../config.php'); // Holds all of our database connection information

mysql_connect("$host", "$username", "$password")or die("cannot connect to the database."); 
mysql_select_db("$db_name")or die("cannot select the database.");

$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = 1");
while($row = mysql_fetch_array($result)) {
	$pagename = $row['pagename'];
	$template = $row['template'];
}

// Get the data passed from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Do some basic sanitizing
$username = stripslashes($username);
$password = stripslashes($password);

$password = str_replace("'", "''", $password);

$sql = ("select * from ".$prefix."admin where username = '$username' and password = '$password'");
$result = mysql_query($sql) or die ( mysql_error() );

$count = 0;

while ($line = mysql_fetch_assoc($result)) {
	 $count++;
}

if ($count == 1) {
	 $_SESSION['loggedIn'] = "true";
	 header("Location: ../index.php"); // This is wherever you want to redirect the user to
} else {
	 $_SESSION['loggedIn'] = "false";
	 header("Location: ../login.php"); // Wherever you want the user to go when they fail the login
}

?>
