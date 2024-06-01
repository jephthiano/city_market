<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_GET['val'])){
	$raw_val = ($_GET['val']);
	if(empty($raw_val)){$val = 'all';}else{$val = urldecode($raw_val);}
}else{
	$val = 'all';
}
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url','home/logo.png');
$image_type = substr($image_link,-3);
$page = strtoupper($val)." PRODUCTS | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','category/product/'.$val);//url redirection current page
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
insert_page_visit('category');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div><?php require(file_location('inc_path','navigation.inc.php')); //navigation?></div>
	<div title='<?=ucfirst(get_xml_data('company_name'))?> Products'class=''>
		<div class='j-color6 j-home-padding'title='<?=ucfirst(get_xml_data('company_name')).ucwords($val)?>'>
			<div class='j-xlarge j-padding'><b><?=ucwords($val)?></b><hr></div>
			<?php require_once(file_location('inc_path','product_pagination.inc.php')); //pagination?>
		</div>
		<br>
		<div><?php require_once(file_location('inc_path','recommended.inc.php')); //recommended?></div>	
	</div>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>