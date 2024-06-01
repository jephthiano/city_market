<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','return/'.$_GET['val']);
require_once(file_location('inc_path','session_check.inc.php'));
if(isset($_GET['val'])){
	$raw_val = test_input(removenum($_GET['val']));
	if(!empty($raw_val)){$id = content_data('order_table','or_id',$raw_val,'or_id');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png');
$image_type = substr($image_link,-3);
$page = "REQUEST FOR RETURN | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
insert_page_visit('request for return');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div class='j-hide-small j-hide-medium'><?php require(file_location('inc_path','navigation.inc.php')); //navigation?></div>
	<div class='j-row j-home-padding'style='padding-top:0px;'>
		<div class='j-col l4 xl3 '><?php require_once(file_location('inc_path','account_first_column.inc.php')); //account first column?></div>
		<div class='j-col l8 xl9 j-padding-flexible'>
			<div class='j-color4 j-account-height'>
				<?php
				$order_token = content_data('order_table','or_token',$id,'or_id');
				//if id is false || orderer is not user || return has been requested
				if($id === false || content_data('order_table','user_id',$order_token,'or_token') !== $u_id || content_data('return_table','rh_id',$id,'or_id') !== false){  
					trigger_error_manual(404);
				}else{
					$p_id = content_data('order_table','p_id',$id,'or_id');
					$order_id = content_data('order_table','or_order_id',$id,'or_id');
					$pm_id = content_data('product_media_table','pm_id',$p_id,'p_id');
					?>
					<?php get_header('REQUEST FOR RETURN FORM','order/order_details/'.$order_token.'/')?>
						<div class='j-padding'>
							<form class=''id='rfrfrm'>
								<div class='j-row'>
									<div class='j-col s3 m2'style='padding: 6px 9px 6px 0px;'>
										<img class='j-round-large'src="<?=file_location('media_url',get_media('product',$pm_id))?>"style='width:100%;height:70px;'/>
									</div>
									<div class='j-col s9 m10 j-large j-text-color7'>
										<div style='margin-bottom:9px;'><?=ucwords(content_data('product_table','p_name',$p_id,'p_id','','null'));?></div>
									</div>
								</div>
								
								<label><b>Tell us why you want to return this order?</b>
								<br>
								<span class='mg j-text-color1'id='rre'></span></label>
								<br>
								<select name='rr'id='rr'class='j-select j-color4 j-round j-border-2 j-border-color5'onchange='esb()'style="width:100%;max-width:400px;">
									<option value="">Select reason</option>
									<option value="i got the wrong product">I got the wrong product</option>
									<option value="i got the wrong color">I got the wrong color</option>
									<option value="i don't like this product">I don't like this product</option>
									<option value="i want to order another product">I want to order another product</option>
									<option value="i'm not interested in the product anymore">I'm not interested in the product anymore</option>
									<option value="other">Other reason</option>
								</select><br><br>
								
								<div id='dorr'style='display:none;'>
								<textarea name='orr'id='orr'class='j-input j-medium j-color4 j-round j-border-2 j-border-color5'maxlength='255'placeholder='Reason for Return'
									style="width:100%;max-width:400px;"rows='3'oninput='esb()'></textarea>
								<br>
								</div>
								<input type='hidden'name='cid'value='<?=addnum($id)?>'/>
								
								<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder" disabled style="width:100%;max-width:400px;">Submit Form</button>
							</form>
						</div>
						<br>
					<?php
				}
				?>				
			</div>
		</div>
	</div>
	<div><?php require_once(file_location('inc_path','recommended.inc.php')); //recommended?></div>
	<div><?php require_once(file_location('inc_path','wishlist.inc.php')); //wishlist?></div>
	<div><?php require_once(file_location('inc_path','recently_viewed.inc.php')); //recently viewed?></div>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>