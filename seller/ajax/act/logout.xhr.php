<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));

$seller = new seller();
$log_out = $seller->log_out();
if($log_out === true){
	$data["status"] = true;$data["message"] = file_location('seller_url','login/');
	//INSERT LOG
	$log = new log('admin');
	$log->seller_id = $slid;
	$log->seller_storename =  content_data('seller_table','s_storename',$slid,'s_id');
	$log->brief = 'Seller signed out';
	$log->details = "logged out";
	$log->insert_seller_log('logout');
}elseif($log_out === false){
	$data["status"] = false;$data["message"] = "Error occur while running request";
}
echo json_encode($data);
?>