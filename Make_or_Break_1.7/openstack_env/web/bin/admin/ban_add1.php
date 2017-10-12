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


<form action="ban_add2.php" method="post">
 <div align="center">
 <table class="table" width="100%">
	<tr class="table_header">
		<td class="table_header" colspan="2">Add a ban</td>
	</tr>
	<tr class="row1">
		<td>IP Adress:<br>
		<span style="font-size: 9pt">
		<a target="_blank" href="http://en.wikipedia.org/wiki/IP_address">
		Information</a></span></td>
		<td> <br>
		<input type="text" name="ip" size="15" /><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Reason:</td>
		<td> <br>
		<textarea rows="4" name="reason" cols="25"></textarea><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>Message:<br>
		<font style="font-size: 9pt">To banned user</font></td>
		<td> <br>
		<textarea rows="4" name="message" cols="25"></textarea><br>
&nbsp;</td>
	</tr>
	<tr class="row2">
		<td>Link:<br>
		<span style="font-size: 9pt">Redirect the user to</span></td>
		<td> 
		<br>
		<input type="text" name="link" size="30" value="http://www." /><br>
&nbsp;</td>
	</tr>
	<tr class="row1">
		<td>
 &nbsp;</td>
		<td>
 <p align="left"><br>
 <input type="submit" value="Add Ban" /></td>
	</tr>
	</table>
 </div>
 </form>
<?php
require('include/footer.php');
?>