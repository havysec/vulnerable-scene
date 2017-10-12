<?php
$cid = (int)$_GET['compId'];
$sql = "SELECT * FROM tbl_complains 
		WHERE cid = $cid";
$result = dbQuery($sql);
while($row = dbFetchAssoc($result)) {
extract($row);
?>
<form action="process.php?action=assignComplain" method="post">
<table width="600" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#336699" class="entryTable">
  <tr id="entryTableHeader">
    <td>:: View Complains Details::</td>
  </tr>
  <tr>
    <td class="contentArea"><div class="errorMessage" align="center"></div>
        <table width="100%" border="0" cellpadding="2" cellspacing="1" class="text">
          <tr align="center">
            <td colspan="2">
			<input type="hidden" name="compId" value="<?php echo $cid; ?>"/>			</td>
          </tr>
          <tr class="entryTable">
            <td class="label">&nbsp;Complainer Name </td>
            <td class="content"><font color="#0066FF"><b><?php echo ucwords($cust_name); ?></b></font></td>
          </tr>
          <tr class="entryTable">
            <td class="label">&nbsp;Complain Title </td>
            <td class="content"><font color="#FF0000"><b><?php echo $comp_title; ?></b></font></td>
          </tr>

          <tr class="entryTable">
            <td valign="top" class="label">&nbsp;Complain Description .</td>
            <td class="content">
			<textarea name="compDesc" cols="50" rows="6" class="box" id="compDesc"  readonly="readonly"><?php echo $comp_desc; ?></textarea></td>
          </tr>
          <tr>
            <td valign="top" class="label">&nbsp;Status</td>
            <td class="content"><font color="#66FF00"><b><?php echo ucwords($status); ?></b></font></td>
          </tr>
          <tr>
            <td valign="top" class="label">&nbsp;Date Of Creation</td>
            <td class="content">
			<?php echo $create_date; ?>			</td>
          </tr>
          
		  <tr>
            <td valign="top" class="label">&nbsp;Assign Complain To</td>
            <td class="content">
			<select name="engId" class="box" id="engId">
				<?php
				$sql = "SELECT eid, ename
						FROM tbl_engineer";
				$result = dbQuery($sql);
				while($row = dbFetchAssoc($result)){		
				extract($row);
				?>
				<option value="<?php echo $eid; ?>"><?php echo $ename; ?></option>
				<?php } ?>
			</select>			</td>
          </tr>
          
		  <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="200">&nbsp;</td>
            <td width="372">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="btnLogin" type="submit" id="btnLogin" value=" Assing Complain "></td>
          </tr>
      </table></td>
  </tr>
</table>
</form>
<?php 
}//while
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>