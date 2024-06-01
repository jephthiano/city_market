<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_GET['i']) && isset($_SESSION['user_id'])){
	$error = []; $data = [];
	
	// validating and sanitizing percentage
	$id = test_input($_GET['i']);
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$p_id = test_input($id);}
	if(empty($error)){
		$wishlist = new wishlist('admin');
		$wishlist->p_id = $p_id;
		$delete = $wishlist->run_request();
		if($delete === true){
			if(check_wishlist_content($p_id) === false){
				$data["status"] = 'success';$data["message"] = 'Product removed from wishlist';
			}else{
				$data["status"] = 'success';$data["message"] = 'Product added to wishlist';
			}
		}else{
			if(check_wishlist_content($this->p_id) === false){
				$data["status"] = 'fail';$data["message"] = 'Error occur while adding product to wishlist';
			}else{
				$data["status"] = 'fail';$data["message"] = 'Error occur while removing product from wishlist';
			}
		}
	}else{
		$data["status"] = 'fail';$data["message"] = 'Error occur while running request';
	}//end of if empty
	echo json_encode($data);
}//end of if isset
?>