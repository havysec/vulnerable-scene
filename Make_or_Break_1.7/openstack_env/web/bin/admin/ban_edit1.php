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
$bannedid = $_GET['id'];
?>


<form action="ban_edit2.php?id=<?php echo $bannedid; ?>" method="post">
<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td colspan="2">Edit a Ban</td>
	</tr>





	<tr class="row1">
		<td>
<?php
$result = mysql_query("SELECT * FROM ".$prefix."banned WHERE b_id = ".$bannedid." ORDER BY b_id") or die("A MySQL error has occurred.<br />Your Query: " . $your_query . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
while($row = mysql_fetch_array($result)) {
echo $row['ip'];
$ip = $row['b_ip'];
$reason = $row['b_reason'];
$message = $row['b_message'];
$link = $row['b_link'];

//read out the faqs
?>
		</td>
	</tr>









	<tr class="row1">
		<td>IP:</td>
		<td><br>
		<input type="text" name="ip" size="15" value="<?php echo $ip; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Reason:</td>
		<td><br>
		<textarea rows="4" name="reason" cols="25"><?php echo $reason; ?></textarea><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>Message:</td>
		<td><br>
		<textarea rows="4" name="message" cols="25"><?php echo $message; ?></textarea><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Link:</td>
		<td><br>
		<input type="text" name="link" size="30" value="<?php echo $link; ?>" /><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>&nbsp;</td>
		<td><br>
		<input type="submit" value="Edit Ban" /><br>
&nbsp;</td>
	</tr>
</table>
</form>




<?php
//end read out the faqs

}

require('include/footer.php');

 ?>