<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('seller_url','account/');
require_once(file_location('seller_inc_path','session_check.inc.php'));
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page = strtoupper(content_data('seller_table','s_storename',$slid,'s_id'))." ACCOUNT";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
insert_page_visit('account');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div><?php require(file_location('seller_inc_path','navigation.inc.php')); //navigation?></div>
	<div class='j-row j-home-padding'style='padding-top:0px;'>
		<div class='j-col l4 xl3'><?php require_once(file_location('seller_inc_path','account_first_column.inc.php')); //account first column?></div>
		<div class='j-col l8 xl9 j-padding-flexible'>
			<div class='j-color4 j-account-height'>
				<?php $addttion = "<a href='".file_location('seller_url','')."'><span class='j-right j-hide-small j-hide-large j-hide-xlarge j-xlarge'><i class='".icon('home')."'></i></span></a>"?>
				<?php get_header('ACCOUNT INFORMATION'.$addttion,'settings',-20)?>
				<?php require_once(file_location('seller_inc_path','no_bank_account_modal.inc.php')); //no bank account modal?>
				<div class='j-margin'>
					<a href="<?=file_location('seller_url','account/change_password/')?>"class='j-bolder j-btn j-color1 j-round'style='margin:5px;'>
						Change Password
					</a>
					<?php
					if(content_data('seller_account_table','sa_id',$slid,'s_id') === false){
						?>
						<span class='j-bolder j-btn j-color1 j-round'style='margin:5px;'onclick="$('#bank_account_modal').fadeIn('slow');">
							Update Bank Details
						</span>
						<?php
						seller_modal('add_bank_account');
					}
					$update_exists = content_data('seller_request_table','sr_id',$slid,'s_id',"AND sr_type = 'update account' AND sr_mode IN ('pending','ongoing')");
					if($update_exists === false){
						?>
						<span class='j-bolder j-btn j-color1 j-round'style='margin:5px;'onclick="$('#update_account_modal').fadeIn('slow');">
							Request For  Profile Info Update
						</span>
						<?php seller_modal('request_update_account');
					}else{
						?>
						<span class='j-bolder j-btn j-color1 j-round'style='margin:5px;'onclick="$('#request_pending').fadeIn('slow');">
							Profile Info Update Pending
						</span>
						<?php
					}
					?>
				</div>
				<!--seller image-->
				<div class=''>
					<div class='j-padding'>
						<div id='preview'class='j-border-color5 j-border j-circle j-color5 j-vertical-center-container j-clickable'style='width:100px;height:100px;'
							 onclick="$('#seller<?=$slid?>_pics_modal').fadeIn('slow');">
							 <img src='<?=file_location('media_url',get_media('seller',$slid,'human'))?>'alt=''class='j-round j-card-4'style='width:100px;height:100px;border:solid 2px white'>
							 <span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>
						</div>
						<?php image_modal('seller',$slid)?>
					</div>
				</div>
				<!--seller detaials-->
				<div class='j-row-padding'>
					<div class='j-col m6 j-padding'>
						<div class='j-color6'>
							<div class='j-color5'><div class='j-padding'><b>PROFILE DATA</b></div></div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>NAME:</b></div>
								<div class='j-col s8'><b><?=ucwords(content_data('seller_table','s_fullname',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>STORENAME:</b></div>
								<div class='j-col s8'><b><?=ucwords(content_data('seller_table','s_storename',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>EMAIL:</b></div>
								<div class='j-col s8'><b><?=(content_data('seller_table','s_email',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>ACCOUNT TYPE:</b></div>
								<div class='j-col s8'><b><?=(content_data('seller_table','s_type',$slid,'s_id','','null'))?> store</b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>STATUS:</b></div>
								<div class='j-col s8'><b><?=(content_data('seller_table','s_status',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>JOINED ON:</b></div>
								<div class='j-col s8'><b><?=showdate(content_data('seller_table','s_regdatetime',$slid,'s_id','','null'));?></b></div>
							</div>
						</div>
					</div>
					
					<div class='j-col m6 j-padding'>
						<div class='j-color6'>
							<div class='j-color5'><div class='j-padding'><b>CONTACT DATA</b></div></div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>PHONE NUMBER:</b></div>
								<div class='j-col s8'><b><?=ucwords(content_data('seller_contact_table','sc_phnumber1',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>2ND PHONE NUMBER:</b></div>
								<div class='j-col s8'><b><?=(content_data('seller_contact_table','sc_phnumber2',$slid,'s_id','','null'))?></b></div>
							</div>
							<div class="j-row-padding j-padding">
								<div class='j-col s4 j-text-color1'><b>ADDRESS:</b></div>
								<div class='j-col s8'><b><?=(content_data('seller_contact_table','sc_address',$slid,'s_id','','null'))?></b></div>
							</div>
						</div>
					</div>
				</div>
				<div class='j-row-padding'>
					<div class='j-col m6 j-padding'>
						<div class='j-color6'>
							<div class='j-color7'><div class='j-padding'><b>ACCOUNT DETAILS</b></div></div>
							<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ACCOUNT NAME:</b></div>
										<div class='j-col s8'><b><?=ucwords(content_data('seller_account_table','sa_name',$slid,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>ACCOUNT NUMBER:</b></div>
										<div class='j-col s8'><b><?=(content_data('seller_account_table','sa_number',$slid,'s_id','','null'))?></b></div>
									</div>
									<div class="j-row-padding j-padding">
										<div class='j-col s4 j-text-color1'><b>BANK NAME:</b></div>
										<div class='j-col s8'><b><?=ucwords(content_data('seller_account_table','sa_bank',$slid,'s_id','','null'))?></b></div>
									</div>
						</div>
					</div>
					<div class='j-col m6 j-padding'>
						<div class='j-color2'><div class='j-padding j-large'><b>Rating</b></div></div>
						<div class="j-container j-color4 j-padding">
							<div style='line-height:20px;'>
								<?php
								if(get_numrow('review_table','s_id',$slid,"return") > 0){
									?>
									<div class='j-medium'><?php get_rating($slid,'rating','seller');?></div>
									<a href='<?=file_location('home_url','review/seller_review/'.addnum($slid).'/all/')?>'>
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
				</div>
				<br>
			</div>
		</div>
	</div>
	<?php
	seller_modal('settings');
	if(isset($delete_exists) && $delete_exists=== false){
		seller_modal('request_delete_account');
	}
	seller_modal('request_pending');
	?>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>