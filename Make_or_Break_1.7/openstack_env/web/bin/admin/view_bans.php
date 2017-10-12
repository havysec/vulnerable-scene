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
?>

<table class="table" width="100%">
	<tr class="table_header">
		<td>ID:</td>
		<td>Date & ip:</td>
		<td>Reason:</td>
		<td>Message:</td>
		<td>link & Options:</td>
	</tr>
<?php
$rowcount = 1;
$result = mysql_query("SELECT * FROM ".$prefix."banned ORDER BY b_id");
while($row = mysql_fetch_array($result)) {
//$date = $row['b_date'];
$date = $rest = substr($row['b_date'], 0,10);
//read out the faqs
?>

	<tr class="row<?php echo $rowcount; ?>">
		<td valign="top"><?php echo $row['b_id']; ?></td>
		<td valign="top"><?php echo $date ?><br><a target="_blank" href="http://www.ip-adress.com/ip_tracer/<?php echo $row['b_ip']; ?>"><?php echo $row['b_ip']; ?></a></td>
		<td valign="top"><?php echo $row['b_reason']; ?></td>
		<td valign="top"><?php echo $row['b_message']; ?></td>
		<td valign="top">
			<a target="_blank" href="<?php echo $row['b_link']; ?>"><?php echo $row['b_link']; ?></a><br>
			<a href="ban_edit1.php?id=<?php echo $row['b_id']; ?>"><img border="0" src="images/edit.png"></a>
			<a href="ban_delete1.php?id=<?php echo $row['b_id']; ?>"><img border="0" src="images/delete.png"></a>
		</td>
	</tr>

<?php
$rowcount = $rowcount + 1;
if ($rowcount == 3) {
	$rowcount = 1;
}
 
}

//end read out the faqs
?>
</table>







<?php
require('include/footer.php');
?>