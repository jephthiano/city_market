<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
if(isset($_POST['t']) && isset($_POST['i'])){
	require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
	$error = [];
	//validating and sanitising content type
	$ty = ($_POST['t']);
	if(empty($ty)){$error[] = "t";}else{$type = test_input($ty);}
	
	// validating and sanitizing id
	$id = test_input(removenum($_POST['i']));
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
	
	// validating and sanitizing second id
	$sid = test_input(removenum($_POST['s']));
	if(empty($sid) || !is_numeric($sid)){$error[] = "number";}else{$s_id = test_input($sid);}
	
	if(isset($_FILES["{$type}_pics"]['name']) && empty($error)){
		if($_FILES["{$type}_pics"]["error"] !== UPLOAD_ERR_OK) { // IF ERROR IS NOT 0 i.e file is not uploaded (SERVER ERROR)
			switch($_FILES["{$type}_pics"]["error"]){
				case UPLOAD_ERR_INI_SIZE:
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>File is larger than 8mb";$error[] = 1;break;
				case UPLOAD_ERR_FORM_SIZE:
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>File is larger than 8mb";$error[] = 2;break;
				case UPLOAD_ERR_NO_FILE:
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>No picture uploaded";$error[] = 3;break;
				default:
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error uploading Picture";$error[] = 4;
				}
		}else{// if file error is 0 i.e false
			if(!validate_uploaded_file($_FILES["{$type}_pics"],'image',["image/png","image/jpeg"],80000000)){ //if the file is not valid
				$error[] = "not valid";
				$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>File must be jpg & png and must not exceed 8mb";
			}else{//if the file is valid and correct
				// getting the extension of the file and assigning . to it
				$extension =".". strtolower(pathinfo($_FILES["{$type}_pics"]['name'],PATHINFO_EXTENSION));
				// to be used for naming the uploaded file
				$file_name = "IMG_".time_token();
				$imagename = basename($file_name.$extension);
				// filepath
				
				$dir = file_location('media_path',$type.'/');
				$file = $dir.$imagename;
				if(@!move_uploaded_file( $_FILES["{$type}_pics"]["tmp_name"],$file)) {//if file is not move
					$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error uploading image, try again later";
					$error[] = "not upload";
				}elseif(empty($error)){// if no error is found continue the process
					// correct image extension type and unlink image that does not have correct image extension
					$newfile = correct_image_extension($file,[2,3]);
					if($newfile === false){
						$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Invalid image selected";
						$error[] = "wrong image type";
					}else{//correct iamge extension and assign file name and extension
						correct_image_rotation($newfile);
						$correct =pathinfo($newfile);
					}
					
					if(empty($error)){
						if($type === 'seller'){
							$message = "changed his/her profile pics";
							$seller = new seller('admin');
							$seller->file_name = $correct['filename'];
							$seller->extension = $correct['extension'];
							$seller->id= $c_id;
							$change = $seller->change_image();
						}elseif($type === 'product'){
							$message = "changed product (<b>".content_data('product_table','p_name',$s_id,'p_id')."</b>) image";
							$product = new product('admin');
							$product->file_name = $correct['filename'];
							$product->extension = $correct['extension'];
							$product->pm_id= $c_id;
							$product->id= $s_id;
							$seller_id = content_data('product_table','s_id',$s_id,'p_id');
							if($seller_id != $slid){
								$change = 'ineligible';
							}else{
								$change = $product->change_image();
							}
						}else{
							$missing[] = 'missing';
						}
						if($change === true && empty($missing)){
							$data["status"] = 'success';$data["message"] = "Success!!!<br>Image successfully uploaded";
							//INSERT SELLER LOG
							$log = new log('admin');
							$log->brief = $type.' image was changed';
							$log->details = $message;
							$log->insert_seller_log();
						}elseif($change === 'ineligible'){
							$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>You are not eligible to carry out this operation.";
						}else{// else if not updated
							$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while uploading image";
						}// end of else if not updated
					}//end of if empty error
				} //end of if empty error
			}//end of if the file is valid and correct
		}// end of if else the upload is olay
	}else{
		$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occurred while uploading image";
	}
	echo json_encode($data);
}
?>