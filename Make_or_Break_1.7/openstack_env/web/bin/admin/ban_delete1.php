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
$result = mysql_query("SELECT * FROM ".$prefix."banned WHERE b_id = ".$bannedid." ORDER BY b_id");

while($row = mysql_fetch_array($result)) {
$ip = $row['b_ip'];
$answer = $row['answer'];

//read out the faqs
?>



<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Delete a Ban</td>
	</tr>
	<tr class="row1">
		<td>
		<span class="genmed">





<form action="ban_delete2.php?id=<?php echo $bannedid ?>" method="post">
<p align="center">Are you sure you want to delete the ip: <b><?php echo $ip; ?></b>






 </p>






 <p align="center"><br>
 <input type="submit" value="Yes" />

<script>
function goBack()
	   {
	   window.history.back()
	   }
</script>
<input type="button" value="No" onclick="goBack()" />
 



 </form>





		</td>
	</tr>
</table>





<?php
//end read out the faqs

}

require('include/footer.php');

 ?>