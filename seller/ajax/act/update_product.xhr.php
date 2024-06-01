<?php
if(isset($_POST)){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = []; $data = [];
	// validating and sanitizing name
	$nam = ($_POST['nm']);
	if(empty($nam)){$error['nme'] = "* name cannot be empty";}else{$name = test_input($nam);}
	
	// validating and sanitizing brand
	$brd = ($_POST['bd']);
	if(empty($brd)){$error['bde'] = "* brand cannot be empty";}else{$brand = strtolower(test_input($brd));}
	
	// validating and sanitizing category
	$cat = ($_POST['ct']);
	if($cat == 0){$category = 0;}elseif(empty($cat)){$error['cte'] = "* category cannot be empty";}else{$category = strtolower(test_input($cat));}
	
	// validating and sanitizing sub category
	$sbcat = ($_POST['sct']);
	if($sbcat == 0){$sub_category = 0;}elseif(empty($sbcat)){$error['scte'] = "* sub category cannot be empty";}else{$sub_category = strtolower(test_input($sbcat));}
	
	// validating and sanitizing max order
	$max = ($_POST['mo']);
	if(empty($max) || !is_numeric($max)){$error['moe'] = "* max order cannot be empty and must be a number";}else{$max_order = test_input($max);}
	
	// validating and sanitizing original_price
	$ori = ($_POST['op']);
	if(empty($ori) || !is_numeric($ori)){$error['ope'] = "* original price cannot be empty and must a money value";}else{$original_price = test_input($ori);}
	
	// validating and sanitizing discounted_price
	$dis = ($_POST['dp']);
	if(empty($dis) || !is_numeric($dis)){$error['dpe'] = "* discounted price cannot be empty and must money value";}else{$discounted_price = test_input($dis);}
	
	// validating and sanitizing color
	$cl = ($_POST['cl']);$cl_json = '{'.$cl.'}';
	if(empty($cl)){$error['cle'] = "* color cannot be empty";}elseif(is_json($cl_json) === false){$error['cle'] = "* incorrect format, review the data";}else{$color = strtolower(test_input($cl_json));}
	
	// validating and sanitizing content
	$cont = ($_POST['cp']);
	if(empty($cont)){$error['cpe'] = "* contents cannot be empty";}else{$content = test_input($cont);}
	
	// validating and sanitizing details
	$det = ($_POST['dt']);
	if(empty($det)){$error['dte'] = "* details cannot be empty";}else{$details = test_input($det);}
	
	// validating and sanitizing weight
	$wgt = ($_POST['wt']);
	if(empty($wgt) || !is_numeric($wgt)){$error['wte'] = "* weight cannot be empty and must be a number";}else{$weight = test_input($wgt);}
	
	// validating and sanitizing id
	$id = test_input(removenum($_POST['tid']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	if(empty($error)){
		//$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>It works man';
		$product = new product('admin');
		$product->id = $c_id;
		$product->name = $name;
		$product->brand = $brand;
		$product->category = $category;
		$product->sub_category = $sub_category;
		$product->max_order = $max_order;
		$product->original_price = $original_price;
		$product->discounted_price = $discounted_price;
		$product->color = $color;
		$product->content = $content;
		$product->details = $details;
		$product->weight = $weight;
		$seller_id = content_data('product_table','s_id',$c_id,'p_id');
		$p_status = content_data('product_table','p_status',$c_id,'p_id');
		if($p_status === 'deleted'){
			$update = 'deleted';
		}elseif($seller_id != $slid){
			$update = 'ineligible';
		}else{
			$update = $product->update_product();
		}
		if($update === true){
			$data["status"] = 'success';$data["message"] = file_location('seller_url','product/preview_product/'.addnum($c_id));
			//INSERT SELLER LOG
			$log = new log('admin');
			$log->brief = 'product was updated';
			$log->details = "updated the product (<b>{$name}</b>)";
			$log->insert_seller_log();
		}elseif($update === false){
			$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>Error occurred while updating product, try again later';
		}elseif($update === 'ineligible'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You are not eligible to carry out this operation.";
		}elseif($update === 'deleted'){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>This product has been deleted, you can't carry out this operation.";
		}
	}else{
		$data["status"] = 'error';$data["errors"] = $error;
	}
	echo json_encode($data);
}//end of if isset
?>