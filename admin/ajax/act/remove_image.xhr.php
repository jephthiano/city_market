<?php
if(isset($_GET['t']) && isset($_GET['i'])){
	require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	$error = [];
	//validating and sanitising content type
	$ty = ($_GET['t']);
	if(empty($ty)){$error[] = "t";}else{$type = test_input($ty);}
	
	// validating and sanitizing percentage
	$id = test_input(removenum($_GET['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	if(empty($error)){
		//DELETE IMAGE AND DELETE IF FROM THE DB
		if($type === 'admin'){
			$message = "removed his/her profile pics";
			$admin = new admin('admin');
			$admin->id = $c_id;
			$remove = $admin->remove_image();
		}elseif($type === 'product'){
			$s_id = content_data('product_media_table','p_id',$c_id,'pm_id');
			$message = "removed product (<b>".content_data('product_table','p_name',$s_id,'p_id')."</b>) image";
			$product = new product('admin');
			$product->pm_id = $c_id;
			$remove = $product->remove_image();
		}elseif($type === 'category'){
			$message = "removed category (<b>".content_data('category_table','c_category',$c_id,'c_id')."</b>) image";
			$category = new category('admin');
			$category->id = $c_id;
			$remove = $category->remove_image($type);
		}elseif($type === 'subcategory'){
			$message = "removed subcategory (<b>".content_data('sub_category_table','sc_sub_category',$c_id,'sc_id')."</b>) image";
			$category = new category('admin');
			$category->id = $c_id;
			$remove = $category->remove_image($type);
		}else{
			$error[] = "no type";
		}
		if(empty($error)){
			if($remove === true){
				$data["status"] = 'success';$data["message"] = "Success!!!<br>Image successfully removed";
				//INSERT LOG
				$log = new log('admin');
				$log->brief = $type.' image was removed';
				$log->details = $message;
				$log->insert_log();
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