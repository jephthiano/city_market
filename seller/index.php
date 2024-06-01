<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page = "SELLER CONTROL PANEL";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('seller_inc_path','session_check.inc.php'));
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body class="j-color6"style="font-family:Roboto,sans-serif;width:100%;"onload="">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div><?php require(file_location('seller_inc_path','navigation.inc.php')); //navigation?></div>
	<?php require_once(file_location('seller_inc_path','no_bank_account_modal.inc.php')); //no bank account modal?>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>