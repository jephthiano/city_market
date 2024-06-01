<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	$error = []; $data = [];
	
	// validating and sanitizing name
	$nam = $_POST['fn'];
	if(empty($nam)){$error['fne'] = "* Name cannot be empty";}else{$name = strtolower(test_input($nam));}
	
	// validating and sanitizing email
	$emai = $_POST['em'];
	if(empty($emai)){$error['eme'] = "* Email cannot be empty";}elseif(!regex('email',$emai)){$error['eme'] = "* Invalid email";}else{$email = strtolower(test_input($emai));}
	
	// validating and phnumber1
	$ph = $_POST['ph'];
	if(empty($ph)){$error['phe'] = "* Phonenumber cannot be empty";}elseif(!regex('phonenumber',$ph)){$error['phe'] = "* Invalid phonumber";}else{$phnumber = test_input($ph);}
	
	// validating and sanitizing message
	$add = $_POST['ad'];
	if(empty($add)){$error['ade'] = "* Address cannot be empty";}else{$address = test_input($add);}
	
	
	if(empty($error)){
		$seller = new seller('admin');
		$seller->name = $name;
		$seller->email = $email;
		$seller->phnumber = $phnumber;
		$seller->details = $address;
		$insert = $seller->insert_become_seller_data();
		if($insert == true && is_numeric($insert)){
			$data["status"] = 'success';$data["message"] = 'Thanks!!!<br>Message successfully sent';
		}elseif($insert === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occur while sending message, try again later";
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>