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

//read out the faqs
?>






<table class="table" width="100%" class="table">
	<tr class="table_header">
		<td>Delete a Ban</td>
	</tr>
	<tr class="row1">
		<td>
<?php
//read out the faqs



echo $question;

$sql = "DELETE FROM ".$prefix."banned WHERE b_id=".$bannedid;
 

 
if (!mysql_query($sql))
   {
   die('Error: ' . mysql_error());
   }
 echo "Your ban is deleted succesfully from the database.";



?>
		</td>
	</tr>
</table>

<?php
//end read out the faqs
 

require('include/footer.php');

 ?>