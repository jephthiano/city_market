<?php
if(isset($_GET['t']) && isset($_GET['i'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = [];
	//validating and sanitising content type
	$ty = ($_GET['t']);
	if(empty($ty)){$error[] = "t";}else{$type = test_input($ty);}
	
	// validating and sanitizing percentage
	$id = test_input(removenum($_GET['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	if(empty($error)){
		//DELETE IMAGE AND DELETE IF FROM THE DB
		if($type === 'product'){
			$s_id = content_data('product_media_table','p_id',$c_id,'pm_id');
			$message = "removed product (<b>".content_data('product_table','p_name',$s_id,'p_id')."</b>) image";
			$product = new product('admin');
			$product->pm_id = $c_id;
			$seller_id = content_data('product_table','s_id',$s_id,'p_id');
			if($seller_id != $slid){
				$remove = 'ineligible';
			}else{
				$remove = $product->remove_image();
			}
		}else{
			$error[] = "no type";
		}
		if(empty($error)){
			if($remove === true){
				$data["status"] = 'success';$data["message"] = "Success!!!<br>Image successfully removed";
				//INSERT SELLER LOG
				$log = new log('admin');
				$log->brief = $type.' image was removed';
				$log->details = $message;
				$log->insert_seller_log();
			}elseif($remove === 'ineligible'){
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You are not eligible to carry out this operation.";
			}else{
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while removing image";
			}
		}else{
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while removing image";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while removing image";
	}
	//end of if empty
	echo json_encode($data);
}//end of if isset
?>