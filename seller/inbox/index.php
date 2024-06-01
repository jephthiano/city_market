<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('seller_url','inbox/');
require_once(file_location('seller_inc_path','session_check.inc.php'));
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page = "INBOX";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
insert_page_visit('inbox');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div class='j-hide-small j-hide-medium'><?php require(file_location('seller_inc_path','navigation.inc.php')); //navigation?></div>
	<div class='j-row j-home-padding'style='padding-top:0px;'>
		<div class='j-col l4 xl3 '><?php require_once(file_location('seller_inc_path','account_first_column.inc.php')); //account first column?></div>
		<div class='j-col l8 xl9 j-padding-flexible'>
			<div class='j-color4 j-account-height'>
				<?php get_header('INBOX','back','','seller_url')?>
				<?php
				$user = 'seller';require_once(file_location('inc_path','product_pagination.inc.php')); //product review pagination
				?>
				<br>
			</div>
		</div>
	</div>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>