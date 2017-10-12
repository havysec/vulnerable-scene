<style>
.xyz {
	border:#333333 solid 1px;
	background-color:#CCCCCC;
	padding:10px;
}
.xh2 {
	color:#000033;
	font-size:14px;
}
</style>

<p>&nbsp;</p>
<?php
$uid = $_SESSION['user_id'];
$sql = "select * from tbl_plans where cid = $uid";
$result = dbQuery($sql);
extract(dbFetchAssoc($result));
?>
<div class="xyz">
<h2 class="xh2">You have subscribed for the <?php echo $plans; ?>, Amount : <?php echo $amt; ?> and Due Bill date : <?php echo $plan_date; ?> of every month.</h2>

</div>