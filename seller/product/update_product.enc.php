<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('seller_url','product/update_product/'.$_GET['page']);
$page = "UPDATE PRODUCT";
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
					<h2 class='j-text-color1 j-padding j-color6'><b>UPDATE PRODUCT</b></h2>
				</div>
				<div class='j-padding'>
					<a href="<?=file_location('seller_url','product/available/')?>" class="j-btn j-color1 j-left j-round j-card-4 j-bolder">Show Available Product</a>
					<a href="<?=file_location('seller_url','product/insert_product/')?>"class='j-btn j-color1 j-right j-round j-card-4 j-bolder'>Insert New Product</a>
					<br class='j-clearfix'>
				</div>
				<?php
				$seller_id = content_data('product_table','s_id',$cid,'p_id');
				$p_status = content_data('product_table','p_status',$cid,'p_id');
				if($id === false || ($slid != $seller_id) || ($p_status === 'deleted')){
					page_not_available('short');
				}else{
					$product_image = 'seller_update'; require_once(file_location('inc_path','product_image.inc.php')); // product image
					?>
					<form onsubmit="event.preventDefault();"class=''id='upsfd'>
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Name:</b> <span class='j-text-color1 mg'id="nme">*</span></label>
								<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Name"maxlength='255'
									name="nm"id="nm"value="<?=(content_data('product_table','p_name',$id,'p_id'))?>"style="width:100%;"/>
							</div>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Brand:</b> <span class='j-text-color1 mg'id="bde">*</span></label>
								<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Brand"maxlength='255'
									name="bd"id="bd"value="<?=(content_data('product_table','p_brand',$id,'p_id'))?>"style="width:100%;"/>
							</div>
						</div>
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Category:</b> <span class='j-text-color1 mg'id="cte">*</span></label>
								<select name='ct'class='j-select j-color4 j-round j-border-2 j-border-color5'style="width:100%;"onchange="gscd(this.value,<?=$id?>);">
									<option value=''>Select category</option>
									<?php
									$p_category = content_data('product_table','p_category',$id,'p_id');
									$p_sub_category = content_data('product_table','p_sub_category',$id,'p_id');
									get_category($p_category);
									?>
									<option value='0' <?php if($p_category == 0){echo 'selected';}?>>Others</option>
								</select>
							</div>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Sub Category:</b> <span class='j-text-color1 mg'id="scte">*</span></label>
									<select id='subct' name='sct'class='j-select j-color4 j-round j-border-2 j-border-color5'style="width:100%;">
										<?php get_subcategory($p_category,$p_sub_category);?>
									</select>
								</span>
							</div>	
						</div>
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Max Order:</b> <span class='j-text-color1 mg'id="moe">*</span></label>
								<input type="number"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Max Order"maxlength='5'
									name="mo"id="mo"value="<?=(content_data('product_table','p_max_order',$id,'p_id'))?>"style="width:100%;"/>
								<span class='j-small j-text-color5'>(Maximum quantity that can be order at a time)</span>
							</div>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Weight:</b> <span class='j-text-color1 mg'id="wte">*</span></label>
								<input type="number"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Weight"maxlength='10'
									name="wt"id="wt"value="<?=(content_data('product_table','p_weight',$id,'p_id'))?>"style="width:100%;"/>
							   <span class='j-small j-text-color5'>(Weight in gram)</span>
							</div>
						</div>
						
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Original Price:</b> <span class='j-text-color1 mg'id="ope">*</span></label>
								<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Original Price"maxlength='55'
									name="op"id="op"value="<?=(content_data('product_table','p_original_price',$id,'p_id'))?>"style="width:100%;"/>
								<span class='j-small j-text-color5'>(Price without discount)</span>
							</div>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Discounted Price:</b> <span class='j-text-color1 mg'id="dpe">*</span></label>
								<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Original Price"maxlength='55'
									name="dp"id="dp"value="<?=(content_data('product_table','p_discounted_price',$id,'p_id'))?>"style="width:100%;"/>
								<span class='j-small j-text-color5'>(Price after discount has been removed)</span>
							</div>
						</div>
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Color & Quantity: </b> <span class='j-text-color1 mg'id='cle'>*</span></label>
								<textarea placeholder="Color and Quantity"id='cl'name="cl"style="width:100%;"rows="4"class="j-input j-medium j-border-2 j-border-color5 j-color4 j-round-large"maxlength='255'
								><?=remove_json_syntax((content_data('product_table','p_color',$id,'p_id')))?></textarea>
							</div>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Content in the Package: </b> <span class='j-text-color1 mg'id='cpe'>*</span></label>
								<textarea placeholder="Cotent in the Package"id='cp'name="cp"style="width:100%;"rows="4"class="j-input j-medium j-border-2 j-border-color5 j-color4 j-round-large"maxlength='255'
								><?=((content_data('product_table','p_content',$id,'p_id')))?></textarea>
							</div>
						</div>
						<div class='j-row'>
							<div class='j-col m6 j-padding'>
								<label class="j-large j-text-color7"><b>Full Detail: </b> <span class='j-text-color1 mg'id='dte'>*</span></label>
								<textarea placeholder="Full Detail"id='dt'name="dt"style="width:100%;"rows="4"class="j-input j-medium j-border-2 j-border-color5 j-color4 j-round-large"
								><?=(content_data('product_table','p_details',$id,'p_id'))?></textarea>
							</div>
						</div>
							
						<input type='hidden'name='tid'value='<?=addnum($id)?>'/>
							
						<div class='j-margin'>
							<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder">Update Product</button>
						</div>
					</form>
					<?php
				}
				?>
			</div>
			<br><br>
		</div>
	</div>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>