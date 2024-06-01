<?php
if(isset($_GET['i'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    require_once(file_location('inc_path','session_check_nologout.inc.php'));
    // validating and sanitizing content id
	$id = ($_GET['i']);
	if(empty($id) || !is_numeric($id)){$error[] = "number";}else{$c_id = test_input($id);}
    
    if(empty($error)){
        check_wishlist_content($c_id,'icon');
    }
}
?>