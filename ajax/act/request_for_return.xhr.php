<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	
	// validating return reason
	$rr = $_POST['rr'];
	if(empty($rr)){
		$error['rre'] = "* select the reason you want to return the product";
	}elseif($rr === 'other'){
		$orr = $_POST['orr'];
		if(empty($orr)){
			$error['rre'] = "* input the reason for return in the textbox below";
		}else{
			$return_reason = test_input($orr);
		}
	}else{
		$return_reason = test_input($rr);
	}
	
	
	// validate id
	$id = removenum($_POST['cid']);
	$delivered_day = content_data('order_history_table','oh_regdatetime',$id,'or_id',"AND oh_status = 'delivered'");
	$days = get_json_data('return_days','about_us');
	$no_days = (60*60*24*$days);
	if(empty($id)){
		$error['empty'] = "empty";
	}else{
		// if product id delivered and no request for return has been applied
		if(content_data('return_table','rh_id',$id,'or_id')){
			$error['applied'] = "applied";
		}elseif(time_validity($no_days,$delivered_day)){
			$error['expired'] = "expired";
		}else{
			$cid = test_input($id);
		}
	}
	
	//validate time frame
	
	$new_status = 'request opened';
	if(empty($error)){
		$reason = "<br><b>Reason:</b> {$return_reason}";
		$order_id = content_data('order_table','or_order_id',$cid,'or_id');
		$return = new return_product('admin');
		$return->new_status = $new_status;
		$return->return_reason = $return_reason;
		$return->or_id = $cid;
		$return->or_order_id = $order_id;
		$return->p_id = content_data('order_table','p_id',$cid,'or_id');
		$return->u_id = $u_id;
		$return->n_title = notification_subject($new_status);
		$return->n_message = notification_message($new_status).$reason;
		$insert = $return->run_return_data($new_status);
		if($insert === true){
			$data["status"] = 'success';$data["message"] = file_location('home_url','return/track/'.$order_id.'/');
		}else{
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occur while submitting form, try again later.";
		}
	}else{
		if(in_array('empty',$error)){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occur while submitting form, try again later.";
		}elseif(in_array('applied',$error)){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You've already applied for refund.";
		}elseif(in_array('expired',$error)){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Return duration has expired.";
		}else{
			$data["status"] = 'error';$data["errors"] = $error;
		}
	}
	echo json_encode($data);
}//end of if isset
?>