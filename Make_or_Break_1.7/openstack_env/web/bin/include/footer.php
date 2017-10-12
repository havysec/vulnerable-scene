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
?>

			</td>

			<td valign="top" width="150">
			


				<div align="right">
			


				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Other Images:</td>
					</tr>
					<tr>
						<td class="cell_content">

						<?php
							$result = mysql_query( " SELECT * FROM ".$prefix."images ORDER BY RAND() LIMIT 0,5");
							while ($row = mysql_fetch_array($result)) {
								$imgid = $row['img_id'];
								$imgname = $row['img_name'];
								$imgfilename = $row['img_filename'];
								echo "<center>
									$imgname<br>
									<a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a>
								</center><br>";
							}
						?>

						</td>
					</tr>
				</table>			
			
			
			
				</div>
			
			
			
</td>
		</tr>
		<tr>
			<td valign="top" colspan="3">
			<p align="center"><br>



<?php
$sql = "UPDATE ".$prefix."settings SET hitcounter=hitcounter+1 WHERE id=1";
	if (!mysql_query($sql)) {
		die('Error: ' . mysql_error());
	}

$arr1 = str_split($hitcounter);
foreach ($arr1 as $arr1) {
	echo "<img border='0' src='counterimages/$hitcounterimg/$arr1.gif'>";
}

?>

				<br><br>
				<a href="index.php">Home</a> | 
				<a href="contact_form.php">Contact Webmaster</a> | 
				<a href="admin/index.php">Admin Panel</a>
				<br><br>
				Powered by <a href="http://software.friendsinwar.com" class="copyright">Make or Break</a> <?php echo $version; ?> © 2017 Friends in War Software
			</p>


			</td>
		</tr>
	</table>
</div>

</body>

</html>