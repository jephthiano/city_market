<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	
	// validating and sanitizing id
	$id = test_input(removenum($_POST['tid']));
	if(empty($id) || !is_numeric($id)){$missing[] = "number";}else{$c_id = test_input($id);}
	
	// validating and sanitizing fullname
	$full = ($_POST['fn']);
	if(empty($full)){$missing['fne'] = "* fullname cannot be empty";}else{$fullname = strtolower(test_input($full));}
	
	// validating and sanitizing email
	$ex_email = content_data('seller_table','s_email',$c_id,'s_id');
	$ema = ($_POST['em']);
	if(empty($ema)){
		$missing['eme'] = "* email cannot be empty";
	}elseif(!regex('email',$ema)){
		$missing['eme'] = "* invalid email";
	}elseif(($ex_email !== $ema) && (content_data('seller_table','s_id',$ema,'s_email') !== false)){
		$missing['eme'] = "* email already taken";
	}else{$email = strtolower(test_input($ema));}
	
	// validating and sanitizing storename
	$ex_storename = content_data('seller_table','s_storename',$c_id,'s_id');
	$strn = ($_POST['sn']);
	if(empty($strn)){
		$missing['sne'] = "* storename cannot be empty";
	}elseif(($ex_storename !== $strn) && (content_data('seller_table','s_id',$strn,'s_storename') !== false)){
		$missing['sne'] = "* storename already taken";
	}else{$storename = strtolower(test_input($strn));}
	
	if(empty($missing)){
		$seller = new seller('admin');
		$seller->id = $c_id;
		$seller->email = $email;
		$seller->fullname = $fullname;
		$seller->storename = $storename;		
		$update = $seller->update_seller_data();
		if($update === true){
			$data["status"] = 'success';$data["message"] = file_location('admin_url','seller/preview_seller/'.addnum($c_id));
			//INSERT LOG
			$log = new log('admin');
			$log->brief = 'seller data was updated';
			$log->details = "updated seller data with the storename (<b>{$storename}</b>)";
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