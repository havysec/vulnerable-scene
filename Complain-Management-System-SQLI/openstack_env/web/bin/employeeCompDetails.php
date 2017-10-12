<h3>Complain Details - Employee View</h3>
<?php
	$emp_id = (int)$_SESSION['user_id'];
	$sql = "SELECT * 
			FROM tbl_complains
			WHERE status != 'close' 
			AND eng_id = $emp_id
			ORDER BY create_date DESC 
			LIMIT 0,20";
	$result = dbQuery($sql);
	if(dbNumRows($result) > 0){
?>	
<form action="processLeave.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
    <tr align="center" id="listTableHeader">
      <td width="747">Complain Title</td>
      <td width="260">Com. Type </td>
      <td width="139">Status</td>
      <td width="150">Detail</td>
    </tr>
    <?php
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
      <td width="150" align="center"><a href="javascript:viewEmployeeComDetail(<?php echo $cid; ?>);">Detail</a></td>
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
 <?php }//if 
 else {
 echo "<h3><font color=red>No Complains Assign to You.</font></h3>";
 }
 ?> 
  <p>&nbsp;</p>
</form>
<p>&nbsp;</p>
