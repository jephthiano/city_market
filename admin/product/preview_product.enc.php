<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','product/preview_product/'.$_GET['page']);
$page = "PRODUCT DATA";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('admin_inc_path','session_check.inc.php'));
if(isset($_GET['page']) AND is_numeric($_GET['page'])){ //getting the value of the get 
	$cid = test_input(removenum($_GET['page']));
	if(!empty($cid)){	
		$id = content_data('product_table','p_id',$cid,'p_id');
	}else{
		trigger_error_manual(404);
	}
}else{
	trigger_error_manual(404);
}
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once(file_location('inc_path','meta.inc.php'));?>
<title><?=$page_name?></title>
</head>
<body class="j-color6"style="font-family:Roboto,sans-serif;width:100%;"onload="">
<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
<!-- BODY STARTS-->
<div class="j-row">
	<div class="j-col s12 l2 j-hide-small j-hide-medium">
		<?php require_once(file_location('admin_inc_path','first_column.inc.php'));?>
	</div>
	<div class="j-col s12 l10"id='mainbody'>
		<?php require(file_location('admin_inc_path','navigation.inc.php'));?>
		<div class='j-padding'>
			<h2 class='j-text-color1 j-padding j-color4'><b>PREVIEW PRODUCT DATA</b></h2>
		</div>
		<div class='j-row'>
			<div class='j-margin'>
				<div class=''>
					<a href="<?=file_location('admin_url','product/avaialble/')?>"class="j-btn j-color1 j-left j-round j-card-4 j-bolder"style='margin-right:30px;'>Available Products</a>
					<a href="<?=file_location('admin_url','product/unavailable/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder"style='margin-right:30px;'>Unavailable Products</a>
					<a href="<?=file_location('admin_url','product/pending/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder"style='margin-right:30px;'>Pending Products</a>
					<a href="<?=file_location('admin_url','product/deleted/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder">Deleted Products</a>
				</div>
			</div>
			<br class='j-clearfix'><br>
			<?php
			if($id === false){
				page_not_available('short');
			}else{
				$product_status = content_data('product_table','p_status',$id,'p_id');
				?>
				<div id=""class='j-col m7 j-padding'>
					<div class='j-color5'><div class='j-padding j-large'><b>Product Details</b></div></div>
					<div class="j-container j-color4 j-padding">
						<?php
						if($product_status !== 'deleted'){
							preview_modal('product',$id);
							if($adlevel > 1){
								preview_modal('product',$id);
								?>
								<div class='j-show-inline-block'>
									<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#product<?=$id?>status').fadeIn('slow');">
									<i class='<?=icon('ban');?>'style='padding-right:5px;'></i>
									Change Product Availability Status
									</span>
								</div>
								<div class='j-show-inline-block'>
									<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#delete_product<?=$id?>').fadeIn('slow');">
									<i class='<?=icon('trash');?>'style='padding-right:5px;'></i>Delete Product
									</span>
								</div>
							<span class='j-clearfix'></span>
							<?php
							}
						}
						?>
						<div style='line-height:30px;'>
							<div>
								<div class='j-text-color7 j-bolder j-large'>Images</div>
								<?php $product_image = 'back_preview'; require_once(file_location('inc_path','product_image.inc.php')); // product image?>
							</div><br>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Name:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_name',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Brand:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_brand',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Status:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_status',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Original Price:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_original_price',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Discounted:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_discounted_price',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Category:</span><br>
								<span class='j-text-color3'><?=ucwords(get_category_name(content_data('product_table','p_category',$id,'p_id','','null')));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Sub Category:</span><br>
								<span class='j-text-color3'><?=ucwords(get_subcategory_name(content_data('product_table','p_sub_category',$id,'p_id','','null')));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Maximum Order:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_max_order',$id,'p_id','','null'));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Weight:</span><br>
								<span class='j-text-color3'><?=ucwords(content_data('product_table','p_weight',$id,'p_id','','null'));?> grams</span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Colors and Quantity:</span><br>
								<span class='j-text-color3'><?=ucwords(remove_json_syntax(content_data('product_table','p_color',$id,'p_id','','null')));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Content in the Package:</span><br>
								<span class='j-text-color3'><?=ucwords(convert_2_br(content_data('product_table','p_content',$id,'p_id','','null')));?></span>
							</div>
							<div class='j-row'style='margin-bottom:15px;'>
								<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Details:</span><br>
								<span class='j-text-color3'><?=(content_data('product_table','p_details',$id,'p_id','','null'));?></span>
							</div>
							<br>
						</div>
					</div>
					<br>
				</div>
				
				<div class='j-col m5 j-padding''>
					<?php
					$seller_id = content_data('product_table','s_id',$id,'p_id','','null');
					$seller_email = content_data('seller_table','s_email',$seller_id,'s_id','','null')
					?>
					<div class='j-color2'><div class='j-padding j-large'><b>Seller Summary</b></div></div>
					<div class='j-padding j-color4'>
						<a href="<?=file_location('admin_url','seller/preview_seller/'.addnum($seller_id).'/')?>" class='j-bolder j-text-color4 j-btn j-color7 j-round j-small'>
							Click to see seller details
						</a>
						<a href="<?=file_location('admin_url',"message/send_seller_email/{$seller_email}/")?>" class=' j-right j-bolder j-text-color4 j-btn j-color1 j-round j-small'>
							Mail seller
						</a>
						<div class=''style='line-height: 40px;'>
							<div>
								<span class='j-bolder j-text-color7'>Name:</span>
								<span class='j-text-color7'><?=ucwords(content_data('seller_table','s_fullname',$seller_id,'s_id','','null'))?></span>
							</div>
							<div>
								<span class='j-bolder j-text-color7'>Storename:</span>
								<span class='j-text-color7'><?=content_data('seller_table','s_storename',$seller_id,'s_id','','null')?></span>
							</div>
							<div>
								<span class='j-bolder j-text-color7'>Status:</span>
								<span class='j-text-color7'><?=content_data('seller_table','s_status',$seller_id,'s_id','','null')?></span>
							</div>
						</div>
					</div>
					<br>
						
					<div class='j-color7'><div class='j-padding j-large'><b>Order Summary</b></div></div>
					<div class="j-container j-color4 j-padding"style='line-height:30px;>
						<span class='j-bolder j-text-color1 j-large'>Total Orders: </span>
						<span><?=get_numrow('order_table','p_id',$id,"return",'round',"AND or_status NOT IN ('cart')")?></span>
						<div class='j-bolder j-text-color1 j-large'>Product In: </div>
						<div class='j-medium'>
							<?php
							$order_statuses = ['failed','order placed','cancelled','confirmed','packaging','in-transit','ready-for-pickup','delivered','failed delivery','returned'];
							foreach($order_statuses AS $order_status){
								?>
								<div>
									<i class='<?=icon('thumb-up-right')?>'style='margin-right:5px'></i>
									<span class='j-bolder j-text-color5'><?=ucwords($order_status)?>: </span>
									<span><?=get_numrow('order_table','p_id',$id,"return",'round',"AND or_status = '{$order_status}'")?></span>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<br>
					
					<div class='j-color2'><div class='j-padding j-large'><b>Rating</b></div></div>
					<div class="j-container j-color4 j-padding">
						<div style='line-height:20px;'>
							<?php
							if(get_numrow('review_table','p_id',$id,"return") > 0){
								?>
								<div class='j-medium'><?php get_rating($id,'rating');?></div>
								<a href='<?=file_location('home_url','review/product_review/'.addnum($id).'/all/')?>'>
								<div class='j-text-color1 j-padding'>See all rating and reviews</div>
								</a>
								<?php
							}else{
								?>No rating at the moment<?php
							}
						?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
			<span id="st"></span>
		</div>
	</div>
</div>
<!-- BODY ENDS -->
<?php require_once(file_location('admin_inc_path','js.inc.php'));?>
</body>
</html>