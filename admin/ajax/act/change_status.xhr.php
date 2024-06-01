<?php
if(isset($_GET["t"]) && isset($_GET["i"] )){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
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
		if($type ===  "admin"){
			$cur_status = content_data('admin_table','ad_status',$c_id,'ad_id');
			$ind = content_data('admin_table','ad_username',$c_id,'ad_id');
			$admin = new admin('admin');
			$admin->id = $c_id;
			$admin->status = $status;
			$change = $admin->change_status();
		}elseif($type ===  "seller"){
			$cur_status = content_data('seller_table','s_status',$c_id,'s_id');
			$ind = content_data('seller_table','s_storename',$c_id,'s_id');
			$seller = new seller('admin');
			$seller->id = $c_id;
			$seller->status = $status;
			$change = $seller->change_status($type);
		}elseif($type ===  "seller_type"){
			$cur_status = content_data('seller_table','s_type',$c_id,'s_id');
			$ind = content_data('seller_table','s_storename',$c_id,'s_id');
			$seller = new seller('admin');
			$seller->id = $c_id;
			$seller->status = $status;
			$change = $seller->change_status($type);
		}elseif($type ===  "seller_request"){
			$cur_status = content_data('seller_request_table','sr_mode',$c_id,'sr_id');
			$cur_type = content_data('seller_request_table','sr_type',$c_id,'sr_id');
			$seller_id = content_data('seller_request_table','s_id',$c_id,'sr_id');
			$ind = content_data('seller_table','s_storename',$seller_id,'s_id'). ' '.$cur_type;
			$seller = new seller('admin');
			$seller->id = $c_id;
			$seller->status = $status;
			$change = $seller->change_status($type);
		}elseif($type ===  "product"){
			$cur_status = content_data('product_table','p_status',$c_id,'p_id');
			$ind = content_data('product_table','p_name',$c_id,'p_id');
			$total_available = get_total_available($c_id);
			$seller_id = content_data('product_table','s_id',$c_id,'p_id');
			$seller_status = content_data('seller_table','s_status',$seller_id,'s_id');
			if($cur_status === 'deleted'){
				$change = 'deleted';
			}elseif($status === 'available' && $total_available < 1){
				$change = 'low';
			}elseif($status === 'available' && $seller_status !== 'active'){
				$change = 'seller suspended';
			}else{
				$product = new product('admin');
				$product->id = $c_id;
				$product->status = $status;
				$change = $product->change_status();
			}
		}elseif($type ===  "user"){
			$cur_status = content_data('user_table','u_status',$c_id,'u_id');
			$ind = content_data('user_table','u_fullname',$c_id,'u_id');
			$user = new user('admin');
			$user->id = $c_id;
			$user->status = $status;
			$change = $user->change_status();
		}elseif($type ===  "pod"){
			$cur_status = content_data('user_table','u_pod',$c_id,'u_id');
			$ind = content_data('user_table','u_fullname',$c_id,'u_id');
			$user = new user('admin');
			$user->id = $c_id;
			$user->status = $status;
			$change = $user->change_status('pod');
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
			$log->insert_log();
		}elseif($change === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while updating status";
		}elseif($change === 'low'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Total Available is less than 1, update total available
			before updating availability status";
		}elseif($change === 'deleted'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>The product has been deleted and it status cannot be changed.";
		}elseif($change === 'seller suspended'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>The product seller has been suspended/deleted and the product status cannot be made available.";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while updating status";
	}
	echo json_encode($data);
}//end of if isset
?>