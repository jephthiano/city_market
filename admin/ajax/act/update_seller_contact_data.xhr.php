<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
	$error = []; $missing = []; $data = [];
	
	// validating and sanitizing id
	$id = test_input(removenum($_POST['tid']));
	if(empty($id) || !is_numeric($id)){$missing[] = "number";}else{$c_id = test_input($id);}
	
	// validating and phnumber1 and phnumber2
	$ex_phnumber1 = content_data('seller_contact_table','sc_phnumber1',$c_id,'s_id');
	$ex_phnumber2 = content_data('seller_contact_table','sc_phnumber2',$c_id,'s_id');
	$ph = $_POST['ph'];
	if(empty($ph)){
		$missing['phe'] = "* phonenumber cannot be empty";
	}elseif(!regex('phonenumber',$ph)){
		$missing['phe'] = "* invalid phonumber";
	}elseif(($ex_phnumber1 !== $ph) && (content_data('seller_contact_table','s_id',$ph,'sc_phnumber1') !== false)){
		$missing['phe'] = "*phonenumber already used by another seller";
	}elseif(($ex_phnumber2 !== $ph) && (content_data('seller_contact_table','s_id',$ph,'sc_phnumber2') !== false)){
		$missing['phe'] = "*phonenumber already used by another seller";
	}else{
		$phnumber1 = test_input($ph);
	}
	
	$ph2 = $_POST['ph2'];
	if(empty($ph2)){
		$phnumber2 = NULL;
	}elseif(!regex('phonenumber',$ph2)){
		$missing['ph2e'] = "* invalid phonumber";
	}elseif(($ex_phnumber1 !== $ph2) && (content_data('seller_contact_table','s_id',$ph2,'sc_phnumber1') !== false)){
		$missing['ph2e'] = "*phonenumber already used by another seller";
	}elseif(($ex_phnumber2 !== $ph2) && (content_data('seller_contact_table','s_id',$ph2,'sc_phnumber2') !== false)){
		$missing['ph2e'] = "*phonenumber already used by another seller";
	}else{$phnumber2 = test_input($ph2);}
	
	// validating and sanitizing address
	$add = $_POST['ad'];
	if(empty($add)){$missing['ade'] = "* address cannot be empty";}else{$address = test_input($add);}
	
	if(empty($missing)){
		$seller = new seller('admin');
		$seller->id = $c_id;
		$seller->address = $address;
		$seller->phnumber1 = $phnumber1;
		$seller->phnumber2 = $phnumber2;
		$update = $seller->update_seller_contact_data();
		if($update === true){
			$data["status"] = 'success';$data["message"] = file_location('admin_url','seller/preview_seller/'.addnum($c_id));
			//INSERT LOG
			$storename = content_data('seller_table','s_storename',$c_id,'s_id');
			$log = new log('admin');
			$log->brief = 'seller contact data was updated';
			$log->details = "updated seller contact data with the storename (<b>{$storename}</b>)";
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