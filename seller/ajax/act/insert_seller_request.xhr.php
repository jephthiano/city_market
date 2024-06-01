<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	
	$ty = $_POST['type'];
	if(empty($ty)){$error['ty'] = "error";}else{$type = test_input($ty);}
	
	if($type === 'update account'){
		// validating and sanitizing details
		$dt = $_POST['det'];
		if(empty($dt)){$error['dete'] = "* details cannot be empty";}else{$details = test_input($dt);}
	}elseif($type === 'delete account'){
		// validating and sanitizing reason
		$dt = $_POST['rfar'];
		if(empty($dt)){$error['rfare'] = "* reason for request cannot be empty";}else{$details = test_input($dt);}
	}
	
	
	if(empty($error)){
		$exists = content_data('seller_request_table','sr_id',$slid,'s_id',"AND sr_type = '{$type}' AND sr_mode = 'pending'");
		if($exists !== false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>We have received your request and one of our seller Rep. is going through it. we will get back to you soon.";
		}else{
			$seller = new seller('admin');
			$seller->type = $type;
			$seller->details = $details;
			$insert = $seller->insert_seller_request();
			if($insert == true && is_numeric($insert)){
				$data["status"] = 'success';$data["message"] = '';
				//INSERT SELLER LOG
				if($type === 'update account'){
					$brief = "Request to update an account";
					$message = "Wants to update his/her account. <br> <b>Details:</b><br>'{$details}'";
				}elseif($type === 'delete account'){
					$brief = "Request to delete an account";
					$message = "Wants to delete his/her account. <br> <b>Reason:</b><br>'{$details}'";
				}
				$log = new log('admin');
				$log->brief = $brief;
				$log->details = $message;
				$log->insert_seller_log();
			}elseif($insert === false){
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occur while sending request, try again later";
			}
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>