<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','review/seller_review/'.$_GET['val']);
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_GET['val'])){
	$raw_val = test_input(removenum($_GET['val']));
	if(!empty($raw_val)){$id = content_data('seller_table','s_id',$raw_val,'s_id');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
if(isset($_GET['level'])){
	$sta = ($_GET['level']);
	if($sta == 'all' || $sta == 1 || $sta == 2 || $sta == 3|| $sta == 4 || $sta == 5 ){$level = $sta;}else{$level = 'all';}
}else{
$level = 'all';	
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png');
$image_type = substr($image_link,-3);
$page = "SELLER REVIEW & RATING | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
insert_page_visit('seller review');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<?php
	if($id === false){ 
		trigger_error_manual(404);
	}else{
		?>
		<div class='j-row j-home-padding j-color4'>
			<?php //store profile head
			show_store($id,'rating_page');
			?>
			<div class=''style='position:relative;top:-50px'>
				<?php $total = get_numrow('review_table','s_id',$id,"return",'round');?>
				<div class='j-large j-bolder j-padding'><span>CUSTOMER REVIEWS (<?=$total?>)</span></div><hr>
				<?php
				if(content_data('review_table','s_id',$id,'s_id') === false){ //if seller has no review
				?>
				<br>
				<div class='j-center j-padding'>No rating available yet for this seller</div>
				<br>
				<?php	
				}else{
					?>
					<div class='j-col l4 xl3 j-padding-flexible'>
						<?php get_rating($id,'rating','seller');?>
					</div>
					<div class='j-col l8 xl9 j-padding-flexible'>
						<?php // star buttons
						star_scroll_btn($id,$level,'seller');
						?>
						<?php //customer rating?>
						<div class='j-color4 j-padding'>
							<?php require_once(file_location('inc_path','product_pagination.inc.php')); //product review pagination?>
						</div>
						<br>
					</div>
					<br><br><br>
				<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>