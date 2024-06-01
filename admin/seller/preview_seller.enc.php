<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','seller/preview_seller/'.@$_GET['page']);
$page = "PREVIEW SELLER";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('admin_inc_path','session_check.inc.php'));
if($adlevel != 3){trigger_error_manual(404);}
if(isset($_GET['page']) AND is_numeric($_GET['page'])){ //getting the value of the get 
	$cid = test_input(removenum($_GET['page']));
	if(!empty($cid)){	
		$id = content_data('seller_table','s_id',$cid,'s_id');
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
		<div id="maincol"class=''>
			<div class=''style='margin-bottom:;'>
				<h2 class='j-text-color1 j-padding j-color4'><b>SELLER DATA</b></h2>
			</div>
			<center>
				<div class='j-padding'>
					<a href="<?=file_location('admin_url','seller/all/')?>" class="j-btn j-color1 j-left j-round j-card-4 j-bolder">Show All Sellers</a>
					<a href="<?=file_location('admin_url','seller/register_seller/')?>"class='j-btn j-color1 j-right j-round j-card-4 j-bolder'>Register New Seller</a>
				</div>
				</center>
				<br class='j-clearfix'><br>
				<div class='j-row'>
					<?php
					if($id === false){
						page_not_available('short');
					}else{
						$storename = content_data('seller_table','s_storename',$id,'s_id','','null');
						$status = content_data('seller_table','s_status',$id,'s_id','','null');
						$type = content_data('seller_table','s_type',$id,'s_id','','null');
						if($status === 'active' || $status === 'suspended'){
							if($adid === 1){
								preview_modal('seller',$id);
								preview_modal('seller_type',$id);
								?>
								<div class='j-right'>
									<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#seller_type<?=$id?>type').fadeIn('slow');">
										<?php if($type === 'official'){$icon = 'ban';}else{$icon = 'ban';}?>
										<i class='<?=icon($icon);?>'style='padding-right:5px;'></i>
										<?= $type === 'official'?'Remove Official Status':'Set As Official'?>
									</span>
									<a href='<?= file_location("admin_url","seller/update_seller/".addnum($id)."/");?>'style="margin:3px;"class='j-clickable j-color1 j-btn j-round j-bolder'">
										<i class='<?=icon('edit');?>'style='padding-right:5px;'></i>
										Update Seller Details
									</a>
									<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#seller<?=$id?>status').fadeIn('slow');">
										<i class='<?=icon('ban');?>'style='padding-right:5px;'></i>
										<?= $status === 'active'?'Suspend':'Re-activate';?> <?=ucwords($storename)?>
									</span>
									<div class='j-show-inline-block j-right'>
										<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#delete_seller<?=$id?>').fadeIn('slow');">
											<i class='<?=icon('trash');?>'style='padding-right:5px;'></i>Delete Seller Account
										</span>
									</div>
								</div>
								<span class='j-clearfix'></span>
								<?php
							}
						}
						?>
						<div id=""class='j-col m7 j-padding'>
							<div class='j-color5'><div class='j-padding j-large'><b><?=strtoupper($storename)?> DATA</b></div></div>
							<div class="j-color4 j-padding j-round">
								<div>
									<img src='<?=file_location('media_url',get_media('seller',$id,'human'))?>'alt=''class='j-round j-card-4'style='width:100px;height:100px;border:solid 2px white'>
									<br><br>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>NAME:</b></div>
										<div class='j-col s8'><b><?=ucwords(content_data('seller_table','s_fullname',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>STORENAME:</b></div>
										<div class='j-col s8'><b><?=($storename)?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>EMAIL:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_table','s_email',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>STORE TYPE:</b></div>
										<div class='j-col s8'><b><?=($type)?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>STATUS:</b></div>
										<div class='j-col s8'><b><?=($status)?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>REGISTERED ON:</b></div>
										<div class='j-col s8'><b><?=showdate(content_data('seller_table','s_regdatetime',$id,'s_id','','null'));?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>REGISTERED BY:</b></div>
										<div class='j-col s8'><b><?=content_data('admin_table','ad_username',content_data('seller_table','ad_registered_by',$id,'s_id','','null'),'ad_id','','null');?>
										</b></div>
									</div>
								</div>
							</div>
							<br>
							
							<div class='j-color2'><div class='j-padding j-large'><b><?=strtoupper($storename)?> CONTACT DATA</b></div></div>
							<div class="j-color4 j-round">
								<div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>PHONE NUMBER:</b></div>
										<div class='j-col s8'><b><?=ucwords(content_data('seller_contact_table','sc_phnumber1',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ADD PHONE NUMBER:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_contact_table','sc_phnumber2',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ADDRESS:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_contact_table','sc_address',$id,'s_id','','null'))?></b></div>
									</div>
								</div>
							</div>
							<br>
						</div>
						
						
						<div id=""class='j-col m5 j-padding'>
							<div class='j-color2'><div class='j-padding j-large'><b><?=strtoupper($storename)?> ACCOUNT DATA</b></div></div>
							<div class="j-color4 j-round">
								<div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ACCOUNT NAME:</b></div>
										<div class='j-col s8'><b><?=ucwords(content_data('seller_account_table','sa_name',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ACCOUNT NUMBER:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_account_table','sa_number',$id,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>BANK NAME:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_account_table','sa_bank',$id,'s_id','','null'))?></b></div>
									</div>
								</div>
							</div>
							<br>
							
							<div class='j-color7'><div class='j-padding j-large'><b><?=strtoupper($storename)?> PRODUCT DATA</b></div></div>
							<div class="j-color4">
								<div class="j-container j-color4 j-padding j-round">
									<a href="<?=file_location('admin_url','product/'.addnum($id).'/')?>"style='margin-right:9px;'class="j-btn j-color1 j-round j-card-4 j-bolder j-small">
									Click to see all <?=$storename?> products
									</a>
								</div>
								<br>
								<div class="">
									<span class='j-text-color1'><b>TOTAL PRODUCT :</b></span>
									<?php $numrow = get_numrow('product_table','s_id',$id,"return",'round');if($numrow === false){$numrow = 0;}?>
									<span class=''><b>(<?=$numrow?></b>)</span>
								</div>
							</div>
							<br>
							
							<div class='j-color2'><div class='j-padding j-large'><b>Rating</b></div></div>
								<div class="j-container j-color4 j-padding">
									<div style='line-height:20px;'>
										<?php
										if(get_numrow('review_table','s_id',$id,"return") > 0){
											?>
											<div class='j-medium'><?php get_rating($id,'rating','seller');?></div>
											<a href='<?=file_location('home_url','review/seller_review/'.addnum($id).'/all/')?>'>
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
				<br><br>
				<span id="st"></span>
		</div>
	</div>
</div>
<!-- BODY ENDS -->
<?php require_once(file_location('admin_inc_path','js.inc.php'));?>
</body>
</html>