<?php
if(isset($_GET["t"]) && isset($_GET["i"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	$error = []; $data = [];
	// validating and sanitizing skill
	$ty = ($_GET['t']);
	if(empty($ty)){$error[] = "empty";}else{$type = test_input($ty);}
	
	// validating and sanitizing percentage
	$id = test_input(removenum($_GET['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	if(empty($error)){
		if($type ===  "admin"){
			$name = content_data('admin_table','ad_username',$c_id,'ad_id');
			$admin = new admin('admin');
			$admin->id = $c_id;
			$delete = $admin->delete_admin();
		}elseif($type ===  "social_handle"){
			$name = content_data('social_handle_table','s_name',$c_id,'s_id');
			$social_handle = new social_handle('admin');
			$social_handle->id = $c_id;
			$delete = $social_handle->delete_social_handle();
		}elseif($type ===  "category"){
			$name = content_data('category_table','c_category',$c_id,'c_id');
			$category = new category('admin');
			$category->id = $c_id;
			$delete = $category->delete_category('category');
		}elseif($type ===  "subcategory"){
			$name = content_data('sub_category_table','sc_sub_category',$c_id,'sc_id');
			$category = new category('admin');
			$category->sc_id = $c_id;
			$category->id = content_data('sub_category_table','c_id',$c_id,'sc_id');;
			$delete = $category->delete_category('subcategory');
		}elseif($type ===  "user"){
			$name = content_data('user_table','u_fullname',$c_id,'u_id');
			$user = new user('admin');
			$user->id = $c_id;
			$delete = $user->delete_user();
		}elseif($type ===  "seller"){
			$sr_id = content_data('seller_request_table','sr_id',$c_id,'s_id',"AND sr_type = 'delete account' AND sr_mode IN ('pending','ongoing')");
			$name = content_data('seller_table','s_storename',$c_id,'s_id');
			$seller = new seller('admin');
			$seller->id = $c_id;
			$seller->sr_id = $sr_id;
			$delete = $seller->delete_seller();
		}elseif($type ===  "product"){
			$name = content_data('product_table','p_name',$c_id,'p_id');
			$product = new product('admin');
			$product->id = $c_id;
			$delete = $product->delete_product();
		}else{
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
		}
		if($delete === true){
			$data["status"] = 'success';$data["message"] = "Success!!!<br>Content successfully deleted";
			//INSERT LOG
			$log = new log('admin');
			$log->brief = $type.' was deleted';
			$log->details = "deleted the {$type} (<b>{$name}</b>)";
			$log->insert_log();
		}elseif($delete === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
		}
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while deleting content";
	}
	echo json_encode($data);
}//end of if isset
?>