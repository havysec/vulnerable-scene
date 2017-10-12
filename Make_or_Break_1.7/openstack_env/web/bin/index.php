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
$imgid = $_GET["imgid"];
$catid = $_GET["catid"];
$potd = $_GET["potd"];

//====================================
//====Begin Send message==============
//====================================
if (isset($_POST['send_message'])) {
	echo "<table class='table' width='700'>
		<tr class='table_header'>
			<td>Message results</td>
		</tr>
		<tr class='row1'>
			<td>";
				session_start();
				if (md5($_POST['norobot']) == $_SESSION['randomnr2'])	{
					if (empty($_POST[name])) {
				 	  echo "ERROR: You have to fill in a name.";
					} elseif (empty($_POST[message])) {
				 	  echo "ERROR: You have to fill in a message.";
					} else {
						$now = date('Y-m-d h:i:s');
						$sql="INSERT INTO ".$prefix."comment (com_img_id, com_poster_name, com_message, com_poster_ip) VALUES ('$imgid', '$_POST[name]', '$_POST[message]', '$userip')";
						if (!mysql_query($sql)) {
							die('Error: ' . mysql_error());
						} else {
							echo "Thank you for your message.";
						}
					}


				} else {  
					echo "Oops, Wrong Captcha code.<br>Please try again.";
				}
			echo "</td>
		</tr>
	</table><br>";
}
//====================================
//====END Send message================
//====================================


//====================================
//====is voted========================
//====================================
if (isset($_POST['vote'])) {
	if ($_POST['vote'] > 0) {

		$sql = "UPDATE ".$prefix."images SET img_total_votes=img_total_votes+1 WHERE img_id=".$_POST[imgid];
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}
		$sql = "UPDATE ".$prefix."images SET img_total_points=img_total_points+".$_POST[vote]." WHERE img_id=".$_POST[imgid];
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}

		$query3 = mysql_query("SELECT * FROM ".$prefix."images WHERE img_id=".$_POST[imgid]);
		while ($row3 = mysql_fetch_array($query3)) {
			$img_total_votes = $row3['img_total_votes'];
			$img_total_points = $row3['img_total_points'];
		}

		$img_average = $img_total_points / $img_total_votes;
		$sql = "UPDATE ".$prefix."images SET img_average=".$img_average." WHERE img_id=".$_POST[imgid];
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}

		$sql = "UPDATE ".$prefix."settings SET total_votes=total_votes+1 WHERE id=1";
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}

		$sql = "UPDATE ".$prefix."settings SET total_points=total_points+".$_POST[vote]." WHERE id=1";
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}



		$query4 = mysql_query("SELECT * FROM ".$prefix."settings WHERE id=1");
		while ($row4 = mysql_fetch_array($query4)) {
			$total_votes = $row4['total_votes'];
			$total_points = $row4['total_points'];
		}

		$average = $total_points / $total_votes;
		$sql = "UPDATE ".$prefix."settings SET average=".$average." WHERE id=1";
			if (!mysql_query($sql)) {
				die('Error: ' . mysql_error());
			}


		//begin votes
		$now = date('Y-m-d');
		$userip = $_SERVER['REMOTE_ADDR'];
		$ip=$_SERVER['REMOTE_ADDR'];
		$sql="INSERT INTO ".$prefix."votes (vote_ip, vote_date, vote_image_id, vote_points) VALUES ('$ip', '$now', '$_POST[imgid]', '$_POST[vote]')";
		if (!mysql_query($sql)) {
			die('Error: ' . mysql_error());
		}
	}
}
//====================================
//====END is voted====================
//====================================



//====================================
//====Begin read image to vote========
//====================================
if (isset($imgid)) {
	$result = mysql_query( " SELECT * FROM ".$prefix."images WHERE img_id=".$imgid);
} elseif (isset($catid)) {
		$result = mysql_query( " SELECT * FROM ".$prefix."images WHERE img_category=".$catid." ORDER BY RAND() LIMIT 0,1");
	} elseif (isset($potd)) {
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
		$result = mysql_query( " SELECT * FROM ".$prefix."images WHERE img_id=".$imgid);

	} else {
		$result = mysql_query( " SELECT * FROM ".$prefix."images ORDER BY RAND() LIMIT 0,1");	
	//}
}
while ($row = mysql_fetch_array($result)) {
	$imgid = $row['img_id'];
	$imgname = $row['img_name'];
	$imgfilename = $row['img_filename'];
	$imgcategory = $row['img_category'];
	$imgdate = $row['img_date'];
	$imguploader = $row['img_uploader'];
	$imgtotalvotes = $row['img_total_votes'];
	$imgtotalpoints = $row['img_total_points'];
	$imgaverage = $row['img_average'];
	//$imgdescription = $row['img_description'];
		$imgdescription = htmlentities($row['img_description']);
		$imgdescription = str_replace("\n", "<br>", $imgdescription);
}
?>
<div align="center">
	<table class="table" width="700">
	<tr class="table_header">
		<td>Voting for: <?php echo $imgname; ?></td>
	</tr>
	<tr class="row1">
		<td>
		<?php
			if (isset($imgfilename)) {
				echo "<img border='0' src='uploads/".$imgfilename."' width='700' alt='".$imgname."'>";
			} else {
				echo "There are no images in this category.";
					echo "</td>
						</tr>
				</table>";
				require('include/footer.php');
				exit();
			}
		?>
		</td>
	</tr>



	<?php




	$result = mysql_query("SELECT * FROM ".$prefix."votes WHERE vote_ip='".$userip."' AND vote_image_id=".$imgid);
	$num_rows1 = mysql_num_rows($result);
	while ($row = mysql_fetch_array($result)) {
		$votepoints = $row['vote_points'];
	}
	if ($num_rows1 > 0) {
		echo "<tr class='row1'>
			<td>";
				echo "<center>You gave this image <b>".$votepoints."</b> points.<br>";
				newimage();
			echo "</td>
		</tr>";
	} else {
	?>





	<tr class="row1">
		<td>
			<?php newvoteincat(); ?>
				<input type="hidden" name="imgid" value="<?php echo $imgid; ?>">
				<div align="center">
				<table border="0" width="420" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center" width="42">1</td>
						<td align="center" width="42">2</td>
						<td align="center" width="42">3</td>
						<td align="center" width="42">4</td>
						<td align="center" width="42">5</td>
						<td align="center" width="42">6</td>
						<td align="center" width="42">7</td>
						<td align="center" width="42">8</td>
						<td align="center" width="42">9</td>
						<td align="center" width="42">10</td>
					</tr>
					<tr>
						<td align="center" width="42">
						<input type="radio" value="1" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="2" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="3" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="4" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="5" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="6" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="7" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="8" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="9" name="vote"></td>
						<td align="center" width="42">
						<input type="radio" value="10" name="vote"></td>
					</tr>
					<tr>
						<td>Break</td>
						<td colspan="8">
						<p align="center"><br>
						<input type="submit" value="Vote" name="voting"></td>
						<td>
						<p align="right">Make</td>
					</tr>
				</table>
				</div>
			</form>
		</td>
	</tr>

	<?php } ?>


</table>
<?php
//====================================
//====End read image to vote==========
//====================================

//====================================
//====Begin Image Information=========
//====================================
echo "<br><table class='table' width='700'>
	<tr class='table_header'>
		<td colspan='2'>Image Information</td>
	</tr>
	<tr class='row1'>
		<td width='50%'>
			Image Name: $imgname<br>
			<a target='_blank' href='uploads/$imgfilename'>Download the orginal file</a><br>";

				$query3 = mysql_query("SELECT * FROM ".$prefix."categories WHERE cat_id=".$imgcategory);
				while ($row3 = mysql_fetch_array($query3)) {
					$catid = $row3['cat_id'];
					$catname = $row3['cat_name'];
				}
			echo "Category: <a href='index.php?catid=$catid'>$catname</a><br>
		</td>


		<td width='50%'>
			Date Added: $imgdate<br>
			Name Uploader: <a href='useruploads.php?username=$imguploader'>$imguploader</a><br>
			Image vote results: $imgtotalpoints / $imgtotalvotes = <b>$imgaverage</b>
		</td>
	</tr>
</table><br>";
//====================================
//====End Image Information===========
//====================================


//====================================
//====Begin Image Description=========
//====================================



if (strlen($imgdescription) > 0) {
?>
				<table class="table" width="700">
					<tr class="table_header">
						<td>Image Description</td>
					</tr>
					<tr class="row1">
						<td>
							<?php echo $imgdescription; ?>
						</td>
					</tr>
				</table><br>
<?php
}


//====================================
//====End Image Description===========
//====================================


//====================================
//====Begin Direct Links==============
//====================================

?>
<table class="table" width="700">
	<tr class="table_header">
		<td colspan="2">Image Codes</td>
	</tr>
	<tr class="row1">
		<td>
			BB-Code:<br>
			<input type="text" onFocus="this.select()" name="T1" size="80" value="[URL=<?php echo $scripturl; ?>index.php?imgid=<?php echo $imgid; ?>][IMG]<?php echo $scripturl; ?>uploads/thumbs/<?php echo $imgfilename; ?>[/IMG][/URL]"><br><br>
			HTML Code:<br>
			<input type="text" onFocus="this.select()" name="T1" size="80" value="&lt;a href=&quot;<?php echo $scripturl; ?>index.php?imgid=<?php echo $imgid; ?>&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;<?php echo $scripturl; ?>uploads/thumbs/<?php echo $imgfilename; ?>&quot;&gt;&lt;/a&gt;">



		</td>
		<td>
			Preview:<br>
			<a href="<?php echo $scripturl; ?>index.php?imgid=<?php echo $imgid; ?>"><img border="0" src="<?php echo $scripturl; ?>uploads/thumbs/<?php echo $imgfilename; ?>"></a>
		</td>
	</tr>
</table><br>
<?php


//====================================
//====End Direct Links================
//====================================

//====================================
//====Begin Show comments=============
//====================================
$row = 0;
echo "<table class='table' width='700'>
	<tr class='table_header'>
		<td>Image Comments</td>
	</tr>";



$query3 = mysql_query("SELECT * FROM ".$prefix."comment WHERE com_img_id=".$imgid);
$num_rows2 = mysql_num_rows($query3);
if ($num_rows2 == 0) {
		echo "<tr class='row1'>
			<td>There are no comments for this image.</b></td>
		</tr>";
} else {

	while ($row3 = mysql_fetch_array($query3)) {
		$row = $row+1;
		$comid = $row3['com_id'];
		$comimgid = $row3['com_img_id'];
		$compostername = $row3['com_poster_name'];
		$comdate = $row3['com_date'];

		$commessage = htmlentities($row3['com_message']);
		$commessage = str_replace("\n", "<br>", $commessage);



			echo "<tr class='row3'>
				<td>This message is posted by: <b>$compostername</b> on <b>$comdate</b></td>
			</tr>
			<tr class='row$row'>
				<td>
					$commessage<hr>
				</td>
			</tr>";
		if ($row == 2) { $row = 0; }

	}
}
	echo "</table><br>";


//====================================
//====END Show comments==============
//====================================

//====================================
//====Begin Add comment===============
//====================================
echo "
	<form method='post' action='index.php?imgid=$imgid'>
		<table class='table' width='700'>
			<tr class='table_header'>
				<td colspan='3'>Add a comment</td>
			</tr>

			<tr class='row1'>
				<td width='150'><br>
					Your Name:<br>
				</td>
				<td colspan='2'>
					<input type='text' name='name' size='25' />
				</td>
			</tr>

			<tr class='row2'>
				<td valign='top'><br>
					Message:
				</td>
				<td colspan='2'><br>
					<textarea rows='11' name='message' cols='60'></textarea><br>
				</td>
			</tr>

			<tr class='row1'>
				<td><br>
					Captcha Code:<br>
				</td>
				<td width='98'>
					<input class='input' type='text' name='norobot' size='8' />
				</td>
				<td width='438'>
					<br>
					<img src='include/captcha.php' /><br><br>
				</td>
			</tr>

			<tr class='row3'>
				<td>&nbsp;</td>
				<td colspan='2'><br>
					<input type='submit' name='send_message' value='Send Message' /><br>
				</td>
			</tr>
		</table>
	</form>
<br>";


//====================================
//====End Add comment=================
//====================================


require('include/footer.php');
?>