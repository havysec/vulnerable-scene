<?php 
$id = $_GET['id'];  
?>
<h3>Report - Admin View</h3>
<form action="processLeave.php?action=addUser" method="post"  name="frmListUser" id="frmListUser">
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text">
    <tr align="center" id="listTableHeader">
      <td width="583">Complain Title</td>
      <td width="303">Eng Name </td>
      <td width="260">Customer Name </td>
      <td width="150">Status</td>
    </tr>
    <?php
	$sql = "SELECT *
			FROM tbl_complains
			WHERE status = '$id'
			AND  eng_name != ''
			ORDER BY create_date DESC 
			LIMIT 0,20";
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
      <td width="303" align="center"><?php echo ucwords($eng_name); ?></td>
      <td width="260" align="center"><?php echo ucwords($cust_name); ?></td>
      <td width="150" align="center"><?php echo ucwords($status); ?></td>
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
