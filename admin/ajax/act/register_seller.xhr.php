<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	// validating and sanitizing email
	$ema = ($_POST['em']);
	if(empty($ema)){
		$missing['eme'] = "* email cannot be empty";
	}elseif(!regex('email',$ema)){
		$missing['eme'] = "* invalid email";
	}elseif(content_data('seller_table','s_id',$ema,'s_email') !== false){
		$missing['eme'] = "* email already taken";
	}else{$email = strtolower(test_input($ema));}
	
	// validating and sanitizing fullname
	$full = ($_POST['fn']);
	if(empty($full)){$missing['fne'] = "* fullname cannot be empty";}else{$fullname = strtolower(test_input($full));}
	
	// validating and sanitizing storename
	$strn = ($_POST['sn']);
	if(empty($strn)){
		$missing['sne'] = "* storename cannot be empty";
	}elseif(content_data('seller_table','s_id',$strn,'s_storename') !== false){
		$missing['sne'] = "* storename already taken";
	}else{$storename = strtolower(test_input($strn));}
	
	// validating and phnumber1
	$ph = $_POST['ph'];
	if(empty($ph)){
		$missing['phe'] = "* phonenumber cannot be empty";
	}elseif(!regex('phonenumber',$ph)){
		$missing['phe'] = "* invalid phonumber";
	}elseif(content_data('seller_contact_table','s_id',$ph,'sc_phnumber1') !== false){
		$missing['phe'] = "*phonenumber already used by another seller";
	}elseif(content_data('seller_contact_table','s_id',$ph,'sc_phnumber2') !== false){
		$missing['phe'] = "*phonenumber already used by another seller";
	}else{
		$phnumber1 = test_input($ph);
	}
	
	// validating and phnumber2
	$ph2 = $_POST['ph2'];
	if(empty($ph2)){
		$phnumber2 = NULL;
	}elseif(!regex('phonenumber',$ph2)){
		$missing['ph2e'] = "* invalid phonumber";
	}elseif(content_data('seller_contact_table','s_id',$ph2,'sc_phnumber1') !== false){
		$missing['ph2e'] = "*phonenumber already used by another seller";
	}elseif(content_data('seller_contact_table','s_id',$ph2,'sc_phnumber2') !== false){
		$missing['ph2e'] = "*phonenumber already used by another seller";
	}else{
		$phnumber2 = test_input($ph2);
	}
	
	// validating and sanitizing address
	$add = $_POST['ad'];
	if(empty($add)){$missing['ade'] = "* address cannot be empty";}else{$address = test_input($add);}
	
	// validating type
	if(isset($_POST['ty']) && $_POST['ty'] === 'yes'){
		$type = 'official';
	}else{
		$type = 'unofficial';
	}
	
	// generating password
	$password = 1234567890;//addnum('');
	if(empty($missing)){
		$seller = new seller('admin');
		$seller->email = $email;
		$seller->fullname = $fullname;
		$seller->storename = $storename;
		$seller->address = $address;
		$seller->phnumber1 = $phnumber1;
		$seller->phnumber2 = $phnumber2;
		$seller->type = $type;
		$seller->password = hash_pass($password);
		$seller->registered_by = $adid;
		$register = $seller->register_seller();
		if($register == true && is_numeric($register)){
			$data["status"] = 'success';$data["message"] = file_location('admin_url','seller/preview_seller/'.addnum($register));
			//INSERT LOG
			$log = new log('admin');
			$log->brief = 'new seller was registered';
			$log->details = "registered new seller with the storename (<b>{$storename}</b>)";
			$log->insert_log();
		}elseif($register === false){
			$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>Error occurred, try again later';
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $missing;
	}
	echo json_encode($data);
}//end of if isset
?>