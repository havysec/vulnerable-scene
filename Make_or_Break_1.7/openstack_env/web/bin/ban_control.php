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

$ip=$_SERVER['REMOTE_ADDR'];

$result = mysql_query("SELECT * FROM ".$prefix."banned WHERE b_ip = '$ip'");
if (mysql_errno()) { 
	header('Location: ./install/index.php');
} 



$num_rows = mysql_num_rows($result);






if ($num_rows == 0) {

} else {
while($row = mysql_fetch_array($result)) {
?>


	<html>
	<head>
	<script type="text/javascript">
	<!--
	function delayer(){
		window.location = "<?php echo $row['b_link'];?>"
	}
	//-->
	</script>

	</head>
	<body onLoad="setTimeout('delayer()', 5000)">

	<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<center><h2><?php echo $row['b_message']; ?></h2></center>
			</td>
		</tr>
	</table>

	</body>
	</html>

<?php
	}
exit();
}
?>
