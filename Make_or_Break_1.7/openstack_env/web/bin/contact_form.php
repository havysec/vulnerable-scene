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

$query3 = mysql_query("SELECT * FROM ".$prefix."settings WHERE id=1");
while ($row3 = mysql_fetch_array($query3)) {
	$my_email = $row3['email'];
}
?>


<script>
 function goBack()
   {
     window.history.back()
   }
 </script>
</head>

<body>

<?php
if (isset($_REQUEST['email'])) {
	//send email
	$email = $_REQUEST['email'] ;
	$subject = $_REQUEST['subject'] ;
	$message = $_REQUEST['message'] ;

	echo "<div align='center'><table class='table' width='50%'>
		<tr class='table_header'>
			<td>Contact Form</td>
		</tr>
		<tr class='row1'>
			<td>";
				session_start();
				if (md5($_POST['norobot']) == $_SESSION['randomnr2'])	{
					if ($email == "") {
						echo "ERROR: you have to fill in a E-mail adress<br>";
						echo "<input type='button' value='Back' onclick='goBack()' />";
						exit;
					}
					if ($subject == "") {
						echo "ERROR: you have to fill in a subject<br>";
						echo "<input type='button' value='Back' onclick='goBack()' />";
						exit;
					}
					if ($message == "") {
						echo "ERROR: you have to fill in a message<br>";
						echo "<input type='button' value='Back' onclick='goBack()' />";
						exit;
					}
				mail($my_email, $subject,
				$message, "From:" . $email);
				echo "Thank you for using this form.<br>Your message has been send.";

				} else {  
					echo "<center>Oops, Wrong Captcha code.<br>Please try again.<br><br>";
					echo "<input type='button' value='Back' onclick='goBack()' /></center>";
				}


			echo "</td>
		</tr>
	</table></div>";
 
} else {

	echo "<div align='center'><form method='post' action='contact_form.php'>
		<table class='table' width='100%'>
			<tr class='table_header'>
				<td colspan='3'>Contact Form</td>
			</tr>
			<tr class='row1'>
				<td>Email:</td>
				<td colspan='2'>
					<input name='email' type='text' />
				</td>
			</tr>
			<tr class='row1'>
				<td>Subject:</td>
				<td colspan='2'>
					<input name='subject' type='text' />
				</td>
			</tr>
			<tr class='row1'>
				<td valign='top'>Message:</td>
				<td colspan='2'>
					<textarea name='message' rows='8' cols='40'></textarea>
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


			<tr class='row1'>
				<td>&nbsp;</td>
				<td colspan='2'>
					<input type='submit' value='Send Message' />
				</td>
			</tr>
		</table></div>
	</form>";
}



require('include/footer.php');
?>