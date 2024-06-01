<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	
	// validating and sanitizing id
	$id = test_input(removenum($_POST['tid']));
	if(empty($id) || !is_numeric($id)){$missing[] = "number";}else{$c_id = test_input($id);}
	
	// validating and sanitizing account name
	$acct_nam = $_POST['acn'];
	if(empty($acct_nam)){$missing['acne'] = "* account name cannot be empty";}else{$account_name = strtolower(test_input($acct_nam));}
	
	// validating and sanitizing account number
	$acct_num = $_POST['acnb'];
	if(empty($acct_num)){$missing['acnbe'] = "* account number cannot be empty";}elseif(!regex('account_number',$acct_num)){$missing['acnbe'] = "* invalid account number";}else{$account_number = test_input($acct_num);}
	
	// validating and sanitizing bank name
	$add = $_POST['bn'];
	if(empty($add)){$missing['bne'] = "* bank name cannot be empty";}else{$bank_name = test_input($add);}
	
	if(empty($missing)){
		$seller = new seller('admin');
		$seller->id = $c_id;
		$seller->account_name = $account_name;
		$seller->account_number = $account_number;
		$seller->bank_name = $bank_name;
		$update = $seller->update_seller_bank_details();
		if($update === true){
			$data["status"] = 'success';$data["message"] = file_location('admin_url','seller/preview_seller/'.addnum($c_id));
			//INSERT LOG
			$storename = content_data('seller_table','s_storename',$c_id,'s_id');
			$log = new log('admin');
			$log->brief = 'seller account data was updated';
			$log->details = "updated seller account data with the storename (<b>{$storename}</b>)";
			$log->insert_log();
		}elseif($update === false){
			$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>Error occurred, try again later';
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $missing;
	}
	echo json_encode($data);
}//end of if isset
?>