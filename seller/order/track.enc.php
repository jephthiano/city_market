<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('seller_url','order/track/'.@$_GET['val']);
require_once(file_location('seller_inc_path','session_check.inc.php'));
if(isset($_GET['val'])){
	$raw_val = test_input($_GET['val']);
	if(!empty($raw_val)){$order_id = content_data('order_table','or_order_id',$raw_val,'or_order_id');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page = "TRACKS";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
insert_page_visit('tracking');
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
				<?php
				$seller_id = content_data('order_table','s_id',$order_id,'or_order_id');
				if($order_id === false || ($slid != $seller_id)){
					trigger_error_manual(404);
				}else{
					?>
					<?php get_header('TRACK ITEM','order/order placed/','','seller_url')?>
					<div class='j-padding'>
						<div class='j-padding'><?php track_item($order_id,'admin');?></div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>