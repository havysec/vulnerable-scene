<?php
require_once './library/config.php';
require_once './library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	
	case 'makeComplain' :
		makeComplain();
	break;
	
	case 'assignComplain' :
		assignComplain();
	break;
	
	case 'commentOnComplain' :
		commentOnComplain();
	break;
	
	case 'closeComplain' :
		closeComplain();
	break;
	//deleteCust
	case 'deleteEngg' :
		deleteEngg();
	break;
	
	case 'deleteCust' :
		deleteCust();
	break;
	
	case 'addEngg' :
		addEngg();
	break;
	
	case 'addCust' :
		addCust();
	break;
	
	case 'editEngg' :
		editEngg();
	break;
	
	case 'selectPlan' :
		selectPlan();
	break;
	
	case 'editCust' :
		editCust();
	break;
		
		
	default :
	    // if action is not defined or unknown
		// move to main user page
		header('Location: index.php');
}


function makeComplain()
{
	//echo 'Make Complain...';
    $compType = $_POST['compType'];
	$compTitle = $_POST['compTitle'];
	$compDesc = $_POST['compDesc'];
	$cust_id = (int)$_SESSION['user_id'];
	$cust_name = $_SESSION['user_name'];
	
	$sql = "INSERT INTO tbl_complains (cust_id, cust_name, comp_type, comp_title, comp_desc, status, eng_id, eng_name, eng_comment, create_date, close_date)
			VALUES ($cust_id, '$cust_name', '$compType', '$compTitle', '$compDesc', 'open', 0, '' , '', NOW(), '' )";
		
	//	echo $sql;		
	$result = dbQuery($sql);
	//header("Location: index.php?view=bal&error=" . urlencode("$data"));	
	header("Location: view.php?mod=customer&view=compDetails");	
	exit;	
}

function addEngg()
{
	//echo 'Make Complain...';
    $EngineerName = $_POST['EngineerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$Mobile = $_POST['Mobile'];
	
	$sql = "INSERT INTO tbl_engineer (ename, epass, address, email, e_mobile, date_time) 
			VALUES ('$EngineerName', '$Password', '$Address', '$Email', '$Mobile', NOW())";
		
	$result = dbQuery($sql);
	//header("Location: index.php?view=bal&error=" . urlencode("$data"));	
	header("Location: view.php?mod=admin&view=enggDetails");	
	exit;	
}

function addCust()
{
	//echo 'Make Complain...';
    $CustomerName = $_POST['CustomerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$Mobile = $_POST['Mobile'];
	
	$sql = "INSERT INTO tbl_customer (cname, cpass, address, email, c_mobile, date_time) 
			VALUES ('$CustomerName', '$Password', '$Address', '$Email', '$Mobile', NOW())";
		
	$result = dbQuery($sql);
	//header("Location: index.php?view=bal&error=" . urlencode("$data"));	
	header("Location: view.php?mod=admin&view=custDetails");	
	exit;	
}

function assignComplain()
{
	//echo 'Make Complain...';
    $compId = $_POST['compId'];
	$engId = (int)$_POST['engId'];
	$sql = "SELECT ename FROM tbl_engineer WHERE eid = $engId";	
	$result = dbQuery($sql);
	while($row = dbFetchAssoc($result)){
		$eng_name = $row['ename'];
	}
	$sql = "UPDATE tbl_complains 
			SET status = 'assigned', 
				eng_id = $engId, 
				eng_name = '$eng_name'
			WHERE cid = $compId";	
			
	//	echo $sql;		
	$result = dbQuery($sql);
	header("Location: view.php?mod=admin&view=compDetails");	
	exit;	
}

function commentOnComplain()
{
	//echo 'Add Comment on Complain...';
    $compId = $_POST['compId'];
	$empComment = $_POST['empComment'];
	$engId = (int)$_SESSION['user_id'];
	$sql = "UPDATE tbl_complains 
			SET status = 'working',
				eng_comment = '$empComment' 
			WHERE cid = $compId";	
	$result = dbQuery($sql);
	header("Location: view.php?mod=employee&view=viewComplain");	
	exit;	
}

function closeComplain()
{
	//echo 'Add Comment on Complain...';
    $compId = $_POST['compId'];
	$empComment = $_POST['empComment'];
	$sql = "UPDATE tbl_complains 
			SET status = 'close',
				eng_comment = '$empComment' 
			WHERE cid = $compId";	
	$result = dbQuery($sql);
	header("Location: view.php?mod=employee&view=viewComplain");	
	exit;	
}

function deleteEngg()
{
	//echo 'Add Comment on Complain...';
    $eId = $_GET['eId'];
	//$empComment = $_POST['empComment'];
	$sql = "DELETE FROM tbl_engineer 
				WHERE eid = $eId";	
	$result = dbQuery($sql);
	header("Location: view.php?mod=admin&view=enggDetails");	
	exit;	
}

function deleteCust()
{
	//echo 'Add Comment on Complain...';
    $cId = $_GET['cId'];
	//$empComment = $_POST['empComment'];
	$sql = "DELETE FROM tbl_customer 
				WHERE cid = $cId";	
	$result = dbQuery($sql);
	header("Location: view.php?mod=admin&view=custDetails");	
	exit;	
}


function editEngg()
{
	//echo 'Make Complain...';
    $eid = $_POST['eid'];
	$EngineerName = $_POST['EngineerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$Mobile = $_POST['Mobile'];
	
	$sql = "UPDATE tbl_engineer 
			SET ename = '$EngineerName', 
				epass = '$Password', 
				address = '$Address', 
				email = '$Email', 
				e_mobile = '$Mobile'
			WHERE eid = $eid"; 	
	$result = dbQuery($sql);
	//header("Location: index.php?view=bal&error=" . urlencode("$data"));	
	header("Location: view.php?mod=admin&view=enggDetails");	
	exit;	
}

function editCust()
{
	//echo 'Make Complain...';
    $cid = $_POST['cid'];
	$CustomerName = $_POST['CustomerName'];
	$Password = $_POST['Password'];
	$Address = $_POST['Address'];
	$Email = $_POST['Email'];
	$Mobile = $_POST['Mobile'];
	
	$sql = "UPDATE tbl_customer 
			SET cname = '$CustomerName', 
				cpass = '$Password', 
				address = '$Address', 
				email = '$Email', 
				c_mobile = '$Mobile'
			WHERE cid = $cid"; 	
	$result = dbQuery($sql);
	header("Location: view.php?mod=admin&view=custDetails");	
	exit;	
}

function selectPlan(){
	$plansDetails = array('120'=>'Basic Plan',
					'30'=>'Music Plan',
					'100'=>'Movie Plan',
					'50'=>'Knowledge Plan'); 
	$plan =$_POST['plan'];
	$plan_string = "";
	$userId = $_SESSION['user_id'];
	$amt = 0;
	for($i=0;$i<count($plan);$i++){
		$price = $plan[$i];
		$plan_string .= $plansDetails["$price"].", ";//$plan[$i]
		$amt += (int)$price;	
	}
	$date= date('d');
	$sql_check = "SELECT * FROM tbl_plans WHERE cid = $userId";
	$res = dbQuery($sql_check);
	if(dbNumRows($res)==1){
		header("Location: view.php?mod=customer&view=planExist");
	}else {
		$sql = "INSERT INTO tbl_plans (cid, plans, amt, plan_date)
				VALUES ($userId,'$plan_string',$amt,'$date')";
		dbQuery($sql);
		header("Location: view.php?mod=customer&view=planSuccess");
	}
}


?>