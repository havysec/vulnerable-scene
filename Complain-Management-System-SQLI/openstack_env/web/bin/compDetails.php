<h3>Complain Details</h3>
<form action="processLeave.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
    <tr align="center" id="listTableHeader">
      <td width="747">Complain Title</td>
      <td width="260">Com. Type </td>
      <td width="139">Status</td>
      <td width="150">Engineer Name </td>
    </tr>
    <?php
	$cust_id = (int)$_SESSION['user_id'];
	$sql = "SELECT * FROM tbl_complains 
			WHERE cust_id = $cust_id";
	$result = dbQuery($sql);
	$i=0;
	while($row = dbFetchAssoc($result)) {
	extract($row);
	if ($i%2) {
		$class = 'row1';
	} else {
		$class = 'row2';
	}
	$i += 1;
	?>
    <tr class="<?php echo $class; ?>" style="height:25px;">
      <td>&nbsp;<?php echo $comp_title; ?></td>
      <td width="260" align="center"><?php echo ucwords($comp_type); ?></td>
      <td width="139" align="center"><?php echo ucwords($status); ?></td>
      <td width="150" align="center"><?php echo ucwords($eng_name); ?></td>
    </tr>
    <?php
	} // end while
	?>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="right">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
