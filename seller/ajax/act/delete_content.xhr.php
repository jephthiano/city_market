<?php
if(isset($_GET["t"]) && isset($_GET["i"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing skill
	$ty = ($_GET['t']);
	if(empty($ty)){$error[] = "empty";}else{$type = test_input($ty);}
	
	// validating and sanitizing percentage
	$id = test_input(removenum($_GET['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	if(empty($error)){
		if($type ===  "product"){
			$name = content_data('product_table','p_name',$c_id,'p_id');
			$product = new product('admin');
			$product->id = $c_id;
			$seller_id = content_data('product_table','s_id',$c_id,'p_id');
			if($seller_id != $slid){
				$delete = 'ineligible';
			}else{
				$delete = $product->delete_product();
			}
		}else{
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
		}
		if($delete === true){
			$data["status"] = 'success';$data["message"] = "Success!!!<br>Content successfully deleted";
			//INSERT LOG
			$log = new log('admin');
			$log->brief = $type.' was deleted';
			$log->details = "deleted the {$type} (<b>{$name}</b>)";
			$log->insert_seller_log();
		}elseif($delete === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
		}elseif($delete === 'ineligible'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You are not eligible to carry out this operation.";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
	}
	echo json_encode($data);
}//end of if isset
?>