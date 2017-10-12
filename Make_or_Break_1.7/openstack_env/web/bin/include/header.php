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

require('config.php');

mysql_connect("$host", "$username", "$password")or die("cannot connect to the database."); 
mysql_select_db("$db_name")or die("cannot select the database.");

include('ban_control.php');
include('include/functions.php');
$userip=$_SERVER['REMOTE_ADDR'];

$result = mysql_query("SELECT * FROM ".$prefix."settings WHERE id = 1");
while($row = mysql_fetch_array($result)) {
	$pagename = $row['pagename'];
	$slogan = $row['slogan'];
	$scripturl = $row['script_url'];
	$template = $row['template'];
	$hitcounter = $row['hitcounter'];
	$hitcounterimg = $row['hitcounterimg'];
	$totalvotes = $row['total_votes'];
	$average = $row['average'];
	$maxfilesize = $row['filesize'];
	$topimages = $row['topimages'];
	$advertising = $row['advertising'];
}
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title><?php echo $pagename; ?></title>
<?php
echo "<link href='template/$template' rel='stylesheet' type='text/css' />";
?>
</head>
<body>



<div align="center">
	<table border="0" width="1024" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" colspan="1">
			&nbsp;</td>
			<td valign="top" colspan="1">
			<p align="center"><b><font size="6"><?php echo $pagename; ?></font></b><br>
			<b><font size="4"><?php echo $slogan; ?></font></b><br><br></p>
			</td>
			<td valign="bottom" colspan="1"><?php include('include/time_script.php'); ?><br></td>
		</tr>
		<tr>
			<td valign="top" colspan="3">
			




<?php
if (strlen($advertising) > 0) {
?>
				<div align="center">
				<table class="table" width="100%">
					<tr class="table_header">
						<td>Advertising</td>
					</tr>
					<tr class="row1">
						<td>
							<?php echo $advertising; ?>
						</td>
					</tr>
				</table><br>
				</div>
<?php
}
?>




			</td>
		</tr>
		<tr>
			<td valign="top" width="150">
			

				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Main Menu:</td>
					</tr>
					<tr>
						<td class="cell_content">
							<a href="index.php">Main page</a><br>
							<a href="search.php">Search</a><br>
							<a href="upload.php">Upload image</a><br>
							<a href="topimages.php">Top <?php echo $topimages; ?> images</a><br>
							<a href="uservotes.php">My votes</a><br>
							<a href="contact_form.php">Contact</a><br>
						</td>
					</tr>
				</table>
				<br>
			


				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Categories:</td>
					</tr>
					<tr>
						<td class="cell_content">

							<?php
							echo "<a href='index.php'>All Categories</a><br>";
							$query1 = mysql_query("SELECT * FROM ".$prefix."categories ORDER BY cat_name");
							while ($row1 = mysql_fetch_array($query1)) {
								$catid = $row1['cat_id'];
								$catname = $row1['cat_name'];
								echo "<a href='index.php?catid=$catid'>$catname</a><br>";
							}
							?>


						</td>
					</tr>
				</table>			
				<br>



				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Picture of the day:</td>
					</tr>
					<tr>
						<td class="cell_content">

							<?php
								$today = date('Y-m-d');

								$result5 = mysql_query("SELECT * FROM ".$prefix."potd WHERE potd_date = '$today'"); 
								$num_rows = mysql_num_rows($result5);
								if ($num_rows == 0) {
									$result5 = mysql_query( " SELECT * FROM ".$prefix."images ORDER BY RAND() LIMIT 0,1");	
									while ($row = mysql_fetch_array($result5)) {
										$imgid = $row['img_id'];
										$imgfilename = $row['img_filename'];
									}

									$sql="INSERT INTO ".$prefix."potd (potd_img_id, potd_date) VALUES ('$imgid', '$today')";
									if (!mysql_query($sql))
									{
										die('Error: ' . mysql_error());
									}
								}

							$result5 = mysql_query("SELECT * FROM ".$prefix."potd WHERE potd_date = '$today'");
							while ($row = mysql_fetch_array($result5)) {
								$imgid = $row['potd_img_id'];
							}
							$result6 = mysql_query( " SELECT * FROM ".$prefix."images WHERE img_id=".$imgid);
							while ($row6 = mysql_fetch_array($result6)) {
								$imgname = $row6['img_name'];
								$imgfilename = $row6['img_filename'];
									echo "<center>
									$imgname<br>
									<a href='index.php?imgid=$imgid'><img border='0' src='uploads/thumbs/$imgfilename'></a><br><br>
									<a href='potd_history.php'>POTD History</a>
									</center>";
							}
							?>
						</td>
					</tr>
				</table>			
				<br>


				<table class="table" width="130">
					<tr class="table_header">
						<td class="table_header">Site Statics:</td>
					</tr>
					<tr>
						<td class="cell_content">
						<?php
							$result = mysql_query("SELECT * FROM ".$prefix."images");
							$num_rows1 = mysql_num_rows($result);
							echo "Total Images: ".$num_rows1."<br>";

							$result = mysql_query("SELECT * FROM ".$prefix."categories");
							$num_rows2 = mysql_num_rows($result);
							echo "Total Categories: ".$num_rows2."<br>";

							echo "Total Votes: ".$totalvotes."<br>";
							echo "Average vote: ".$average."<br>";

							$result = mysql_query("SELECT * FROM ".$prefix."votes WHERE vote_ip='".$userip."'");
							$num_rows2 = mysql_num_rows($result);
							echo "You voted: ".$num_rows2." times<br>";

							$usertotalvoted = $num_rows2 / $num_rows1 * 100;
							$usertotalvoted = round($usertotalvoted, 1);  
							echo "Total voted: ".$usertotalvoted."% <br>";
							
							$result = mysql_query("SELECT * FROM ".$prefix."comment");
							$num_rows1 = mysql_num_rows($result);
							echo "Total comments: ".$num_rows1."<br>";
						?>



						</td>
					</tr>
				</table>









			
			
			</td>
			<td valign="top" colspan="1">