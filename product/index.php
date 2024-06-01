<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','product/'.$_GET['val']);;//url redirection current page
require_once(file_location('inc_path','session_check_nologout.inc.php'));
if(isset($_GET['val'])){
	$raw_val = test_input(removenum($_GET['val']));
	if(!empty($raw_val)){$id = content_data('product_table','p_id',$raw_val,'p_id');$pm_id = content_data('product_media_table','pm_id',$id,'p_id');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
//for meta
$follow_type = 'follow';
$image_link = file_location('media_url',get_media('product',$pm_id));
$image_type = substr($image_link,-3);
$page = ucwords(content_data('product_table','p_name',$id,'p_id','','null'))." | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
insert_page_visit('product details');
if(isset($_SESSION['user_id'])){insert_viewed($id);}
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$id===false?"404 Error Not Found":$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div><?php require(file_location('inc_path','navigation.inc.php')); //navigation?></div>
	<?php
	if($id === false){
		trigger_error_manual(404);
	}else{
		?>
		<div title='<?=ucwords(content_data('product_table','p_name',$id,'p_id','','null'))?>'class='j-home-padding'>
				<div class='j-row'>
					<div class='j-col l9 j-padding-flexible'>
						<?php show_product($id,'product_details')?>
					</div>
					<div class='j-col l3 j-padding-flexible'>
						<?php // delivery info?>
						<div class='j-color4'style='line-heiht:30px;margin-bottom:9px;'>
							<div class='j-padding-small'><b>Delivery Info</b></div>
							<div class='j-small'>
								<div class='j-row j-padding'>
									<span class='j-col s2 m1 l3'>
										<i class="<?=icon('truck')?> j-xxlarge"></i>
									</span>
									<span class='j-col s10 m11 l8'>
										Delivery can either be home delivery or pickup<br>
										Delivery is only in <?=ucwords(get_json_data('locality','about_us'))?>.
									</span>
								</div><hr>
								<div class='j-row j-padding'>
									<span class='j-col s2 m1 l3'>
										<i class="<?=icon('handshake')?> j-xxlarge"></i>
									</span>
									<span class='j-col s10 m11 l8'>
										Return is available within <?=get_json_data('return_days','about_us')?> days after delivery.
									</span>
								</div><hr>
								<div class='j-row j-padding'>
									<span class='j-col s2 m1 l3'>
										<i class="<?=icon('credit-card')?> j-xxlarge"></i>
									</span>
									<span class='j-col s10 m11 l8'>
										Pay online with secure payment checkout or pay on delivery/pickup.
									</span>
								</div><hr>
							</div>
						</div>
						<?php // customer review?>
						<div class='j-color4 j-padding-small'style='margin-bottom:9px;'>
							<div class=''><b>Customers Review</b></div>
							<div class='j-color4'>
								<?php
								$add="ORDER BY r_id DESC LIMIT 3";
								$or = multiple_content_data('review_table','r_id',$id,'p_id',$add);
								if($or !== false){
									foreach($or AS $r_id){get_rating($r_id,'second_column_feedback');}
								}else{
									?><div class='j-text-color7 j-small'style='margin-top:8px;'>No rating is available at the moment</div><?php
								}
								?>
							</div>
							<?php if(get_numrow('review_table','p_id',$id,"return",'round') > 0){?>
							<a class='j-text-color1 j-bolder'href='<?=file_location('home_url','review/product_review/'.addnum($id).'/all/')?>'><div style='margin-top:16px;'>See All Reviews</a></div>
							<?php }?>
						</div>
						<?php // seller info and other product?>
						<div class='j-color4 j-padding-small'style='margin-bottom:9px;'>
							<?php $s_id = content_data('product_table','s_id',$id,'p_id');$store_name = content_data('seller_table','s_storename',$s_id,'s_id');?>
							<a href="<?=file_location('home_url',"store/{$store_name}/")?>">
							<?php show_store($s_id,'product_page')?>
							</a>
							<div class='j-hide-large j-hide-xlarge'>
								<?php
								$or = multiple_content_data('product_table','p_id','available','p_status',"AND p_id != {$id} AND s_id = {$s_id} ORDER BY RAND() LIMIT 0,6");
								if($or !== false){
									?>
									<?php foreach($or AS $p_id){show_product($p_id,'horizontal');}?>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<?php // more from this seller for large screen ?>
				<div class='j-padding j-hide-small j-hide-medium'>
					<div class='j-padding j-color4'>
						<?php
						$or = multiple_content_data('product_table','p_id','available','p_status',"AND p_id != {$id} AND s_id = {$s_id} ORDER BY RAND() LIMIT 0,6");
						if($or !== false){
							?>
							<div class='j-large j-color4 j-text-color7'>More items from this store</div>
							<div class='j-row'>
								<?php foreach($or AS $p_id){show_product($p_id,'default');}?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
		</div>
		<div><?php require_once(file_location('inc_path','recommended.inc.php')); //recommended?></div>
		<?php
	}
	?>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>