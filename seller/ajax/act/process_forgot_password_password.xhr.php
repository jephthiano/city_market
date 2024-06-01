<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
$error = []; $missing = []; $data = [];
if(isset($_POST) && isset($_POST['psw'])){
	$cookie_email = get_seller_forgot_password_token('email');
	$cookie_code = get_seller_forgot_password_token('code');
	$db_code = content_data('seller_emailcode_table','c_code',$cookie_email,'c_email');
	$verify = content_data('seller_emailcode_table','c_verify',$cookie_email,'c_email');
	//if  verify is no
	if($verify !== 'yes'){
		$error[] = 'error';
		$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/enter_code/');
	}
	//if cookie email and cookie code are empty or flase || if cookie code is not equal to db code
	if(empty($cookie_email) || $cookie_email === false || empty($cookie_code) || $cookie_code === false || $cookie_code !== $db_code){
		$error[] = 'error';
		insert_delete_seller_code('delete',$cookie_email);
		$data["status"] = 'success';$data["message"] = file_location('home_url','forgot_password/');
	}
	
	// validating and sanitizing re_password
	$re_pass = ($_POST['psw']);
	if(empty($re_pass)){
		$missing['pswe'] = "* field cannot be empty";
	}elseif((strlen($re_pass) < 7)){
		$missing['pswe'] = "* passwords must be more than 6 chars";
	}else{
		$newpass = hash_pass(test_input($re_pass));
	}
	
	if(empty($error) and empty($missing)){
		$seller = new seller('admin');
		$seller->new_password = $newpass;
		$seller->email = $cookie_email;
		$change_password = $seller->change_password('email');
		if($change_password === true){
			$data["status"] = 'fail';$data["message"] = "Success!!!<br>Password successfully reset<br><br>
			<a href='".file_location('seller_url','login')."'>
			<div class='j-clickable j-color1 j-btn j-padding j-round'style='width:100%'>Go Back to Login</div>
			</a>";
			insert_delete_seller_code('delete',$cookie_email);
			//INSERT LOG
			$log = new log('admin');
			$log->seller_id = content_data('seller_table','s_id',$cookie_email,'s_email');;
			$log->seller_storename =  content_data('seller_table','s_storename',$cookie_email,'s_email');
			$log->brief = 'Seller reset password';
			$log->details = "reset password";
			$log->insert_seller_log('logout');
		}elseif($change_password === false){
			$data["status"] = 'fail';$data["message"] = "Sorry!!!<br>Error occcur while resetting password";
		}
	}else{
		if(!empty($missing)){$data["status"] = 'error';$data["errors"] = $missing;}
	}
}else{
	$data["status"] = 'fail';$data["message"] = 'Sorry!!!<br>Error occurred while processing email';
}//end of if empty
echo json_encode($data);
?>