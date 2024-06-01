<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	
	// validating and sanitizing account name
	$acct_nam = $_POST['acn'];
	if(empty($acct_nam)){$error['acne'] = "* account name cannot be empty";}else{$account_name = strtolower(test_input($acct_nam));}
	
	// validating and sanitizing account number
	$acct_num = $_POST['acnb'];
	if(empty($acct_num)){$error['acnbe'] = "* account number cannot be empty";}elseif(!regex('account_number',$acct_num)){$error['acnbe'] = "* invalid account number";}else{$account_number = test_input($acct_num);}
	
	// validating and sanitizing bank name
	$add = $_POST['bn'];
	if(empty($add)){$error['bne'] = "* bank name cannot be empty";}else{$bank_name = test_input($add);}
	
	
	if(empty($error)){
		$sa_id = content_data('seller_account_table','sa_id',$slid,'s_id');
		if($sa_id !== false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You already have a bank account registered, to update your account details,
			please contact the administative through update profile data button.";
		}else{
			$seller = new seller('admin');
			$seller->account_name = $account_name;
			$seller->account_number = $account_number;
			$seller->bank_name = $bank_name;
			$insert = $seller->insert_seller_bank_details();
			if($insert == true && is_numeric($insert)){
				$data["status"] = 'success';$data["message"] = '';
				//INSERT SELLER LOG
				$log = new log('admin');
				$log->brief = 'Bank account details uploaded';
				$log->details = "Uploaded his/her account details";
				$log->insert_seller_log();
			}elseif($insert === false){
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occur while uploading data, try again later";
			}
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>