<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('seller_url','product/preview_product/'.@$_GET['page']);
$page = "PRODUCT DATA";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('seller_inc_path','session_check.inc.php'));
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
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div><?php require(file_location('seller_inc_path','navigation.inc.php')); //navigation?></div>
	<div class='j-home-padding'>
		<div class='j-col l4 xl3 '><?php require_once(file_location('seller_inc_path','account_first_column.inc.php')); //account first column?></div>
		<div class='j-col l8 xl9 j-padding-flexible'>
			<div class='j-color4 j-account-height'>
				<div class='j-padding'>
					<h2 class='j-text-color1 j-padding j-color6'><b>PREVIEW PRODUCT DATA</b></h2>
				</div>
				<div class='j-row'>
					<div class='j-margin'>
						<div style='margin-bottom:10px;'>
						<a href="<?=file_location('seller_url','product/insert_product/')?>"class='j-btn j-color1 j-right j-round j-card-4 j-bolder'>Insert New Product</a>
						<span class='j-clearfix'></span>
						</div>
						<div class=''>
							<a href="<?=file_location('seller_url','product/avaialble/')?>"class="j-btn j-color1 j-left j-round j-card-4 j-bolder"style='margin-right:30px;'>Available Products</a>
							<a href="<?=file_location('seller_url','product/unavailable/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder"style='margin-right:30px;'>Unavailable Products</a>
							<a href="<?=file_location('seller_url','product/deleted/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder"style='margin-right:30px;'>Deleted Products</a>
							<a href="<?=file_location('seller_url','product/pending/')?>"class="j-btn j-color1 j-round j-card-4 j-bolder"style='margin-right:30px;'>Pending Products</a>
						</div>
					</div>
					<br class='j-clearfix'><br>
					<?php
					$seller_id = content_data('product_table','s_id',$cid,'p_id');
					if($id === false || ($slid != $seller_id)){
						page_not_available('short');
					}else{
						$product_status = content_data('product_table','p_status',$id,'p_id');
						?>
						<div id=""class='j-col m7 j-padding'>
							<div class='j-color5'><div class='j-padding j-large'><b>Product Details</b></div></div>
							<div class="j-container j-color6 j-padding">
								<?php
								if($product_status !== 'deleted' && $product_status !== 'pending'){
									preview_modal('product',$id,'seller');
									?>
									<div class='j-show-inline-block'>
										<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#product<?=$id?>status').fadeIn('slow');">
											<i class='<?=icon('ban');?>'style='padding-right:5px;'></i>
											Change Product Availability Status
										</span>
									</div>
									<a href='<?= file_location("seller_url","product/update_product/".addnum($id)."/");?>'style="margin:3px;"class='j-clickable j-color1 j-btn j-round j-bolder'">
										<i class='<?=icon('edit');?>'style='padding-right:5px;'></i>
										Update Product
									</a>
									<div class='j-show-inline-block'>
										<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#delete_product<?=$id?>').fadeIn('slow');">
										<i class='<?=icon('trash');?>'style='padding-right:5px;'></i>Delete Product</span>
									</div>
									<span class='j-clearfix'></span>
									<?php
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
										<span class='j-text-color3'><?=ucwords(content_data('product_table','p_category',$id,'p_id','','null'));?></span>
									</div>
									<div class='j-row'style='margin-bottom:15px;'>
										<span class='j-text-color7 j-bolder' style='margin-right:9px;'>Product Sub Category:</span><br>
										<span class='j-text-color3'><?=ucwords(content_data('product_table','p_sub_category',$id,'p_id','','null'));?></span>
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
							<div class='j-color7'><div class='j-padding j-large'><b>Order Summary</b></div></div>
							<div class="j-container j-color6 j-padding"style='line-height:30px;>
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
							<div class="j-container j-color6 j-padding">
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
				</div>
			</div>
			<br><br>
		</div>
	</div>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>