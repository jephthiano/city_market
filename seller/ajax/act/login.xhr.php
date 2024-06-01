<?php
if(isset($_POST["uname"]) && isset($_POST["pd"])){
	require_once($_SERVER["DOCUMENT_ROOT"]."/addons/function.inc.php");// all functions
	$error = []; $data = [];
	if(get_json_data('login','seller_act') == 0 || get_json_data('all','seller_act') == 0){//if checkout and all act is disabled
		$data["status"] = 'error';$data["errors"] = 'Sorry!!!<br> Login is not available at the moment';
	}else{
		// validating and sanitizing username
		$storename = ($_POST["uname"]);
		if(empty($storename)){$missing[] = "storename";}else{$storename = test_input($storename);}
		
		// validating and sanitizing password
		$password = ($_POST["pd"]);
		if(empty($password) OR strlen($password) < 7){$missing[] = "password";}else{$adpassword = $password;}
		
		if(empty($error) and empty($missing)){
			$seller = new seller('admin');
			$seller->storename = $storename;
			$seller->current_password = $adpassword;
			$authenticate = $seller->authenticate_login();
			//validate login
			if($authenticate == true && is_numeric($authenticate)){
				require_once(file_location('seller_inc_path','session_start.inc.php'));
				//set session
				$_SESSION['seller_id'] = ssl_encrypt_input(test_input($authenticate));
				session_regenerate_id();
				$data["status"] = 'success';$data["message"] = ($_POST["re"]);
				//INSERT LOG
				$log = new log('admin');
				$log->brief = 'new seller login';
				$log->details = "logged in";
				$log->insert_seller_log();
			}elseif($authenticate === 'suspended'){
				$data["status"] = 'error';$data["errors"] = "Sorry!!!<br> Account has been suspended, contact admin.<br>";
			}elseif($authenticate === false){
				$data["status"] = 'error';$data["errors"] = "Sorry!!!<br> Email/Username and Password not match<br>";
			}
		}else{
			$data["status"] = 'error';$data["errors"] = "Sorry!!!<br> All fields are required<br>";
		}
	}
	echo json_encode($data);
}//end of if isset
?>