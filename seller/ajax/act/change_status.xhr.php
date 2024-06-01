<?php
if(isset($_GET["t"]) && isset($_GET["i"] )){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing type
	$ty = ($_GET['t']);
	if(empty($ty)){$error[] = "empty";}else{$type = test_input($ty);}
	
	// validating and sanitizing id
	$id = test_input(removenum($_GET['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	// validating and sanitizing status
	$st = ($_GET['s']);
	if(empty($st)){$error[] = "empty";}else{$status = test_input($st);}
	
	if(empty($error) and empty($missing)){
		if($type ===  "product"){
			$cur_status = content_data('product_table','p_status',$c_id,'p_id');
			$ind = content_data('product_table','p_name',$c_id,'p_id');
			$total_available = get_total_available($c_id);
			$seller_id = content_data('product_table','s_id',$c_id,'p_id');
			if($seller_id != $slid){
				$change = 'ineligible';
			}elseif($cur_status === 'deleted'){
				$change = 'deleted';
			}elseif($status === 'available' && $total_available < 1){
				$change = 'low';
			}else{
				$product = new product('admin');
				$product->id = $c_id;
				$product->status = $status;
				$change = $product->change_status();
			}
		}else{
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while updating status";
		}
		if($change === true){
			$data["status"] = 'success';$data["message"] = "Success!!!<br>Status successfully updated";
			// update user data counter
			if($type === 'pod'){
				if($status === 'enabled'){$counter = 'cancel';}else{$counter = 'delivery';}
				$user->new_counter = 0;
				$user->update_counter($counter);
			}
			//INSERT LOG
			$log = new log('admin');
			$log->brief = $type.' status was changed';
			$log->details = "changed {$type} status of <b>".ucwords($ind)."</b> from <b>{$cur_status}</b> to <b>{$status}</b>";
			$log->insert_seller_log();
		}elseif($change === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while updating status";
		}elseif($change === 'low'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Total Available is less than 1, update total available
			before updating availability status";
		}elseif($change === 'ineligible'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You are not eligible to carry out this operation.";
		}elseif($change === 'deleted'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>The product has been deleted and it status cannot be changed.";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while updating status";
	}
	echo json_encode($data);
}//end of if isset
?>