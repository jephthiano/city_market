<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('seller_inc_path','session_start.inc.php'));
if(isset($_SESSION['seller_id']) && content_data('seller_table','s_id',test_input(ssl_decrypt_input($_SESSION['seller_id'])),'s_id') !== false
   && content_data('seller_table','s_status',test_input(ssl_decrypt_input($_SESSION['seller_id'])),'s_id') === "active"){
	$GLOBALS['slid'] = (int)test_input(ssl_decrypt_input(($_SESSION['seller_id'])));
}else{
	require_once(file_location('seller_inc_path','session_redirection.inc.php'));
	require_once(file_location('seller_inc_path','session_destroy.inc.php'));
}
?>