<h3>Engineer Details - Admin View</h3>
<p>To add New Engineer <a href="view.php?mod=admin&view=addEngg">Click Here</a> </p>
<form action="" method="post"  name="frmListUser" id="frmListUser">
  <table width="680" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
    <tr align="center" id="listTableHeader">
      <td width="453">Engineer Name </td>
      <td width="">Email</td>
      <td width="265">Mobile NNo. </td>
      <td width="207">Detail</td>
    </tr>
    <?php
	$cust_id = (int)$_SESSION['user_id'];
	$sql = "SELECT * 
			FROM tbl_engineer
			ORDER BY ename ASC";
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
      <td>&nbsp;<?php echo $ename; ?></td>
      <td width="371" align="center"><?php echo ucwords($email); ?></td>
      <td width="265" align="center"><?php echo ucwords($e_mobile); ?></td>
      <td width="207" align="center"><a href="javascript:editEnggDetail(<?php echo $eid; ?>);">Edit</a> / <a href="javascript:deleteEngg(<?php echo $eid; ?>);">Delete</a> </td>
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
