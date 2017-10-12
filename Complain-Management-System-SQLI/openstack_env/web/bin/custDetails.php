<h3>Customer Details - Admin View</h3>
<p>To add New Customer <a href="view.php?mod=admin&view=addCust">Click Here</a> </p>
<form action="" method="post"  name="frmListUser" id="frmListUser">
  <table width="680" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
    <tr align="center" id="listTableHeader">
      <td width="453">Customer Name </td>
      <td width="">Email</td>
      <td width="265">Mobile No. </td>
      <td width="207">Detail</td>
    </tr>
    <?php
	$cust_id = (int)$_SESSION['user_id'];
	$sql = "SELECT * 
			FROM tbl_customer
			ORDER BY cname ASC";
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
      <td>&nbsp;<?php echo ucwords($cname); ?></td>
      <td width="371" align="center"><?php echo ucwords($email); ?></td>
      <td width="265" align="center"><?php echo ucwords($c_mobile); ?></td>
      <td width="207" align="center"><a href="javascript:editCustDetail(<?php echo $cid; ?>);">Edit</a> / <a href="javascript:deleteCust(<?php echo $cid; ?>);">Delete</a> </td>
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
