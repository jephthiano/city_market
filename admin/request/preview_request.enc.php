<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','request/preview_request/'.@$_GET['type'].'/'.@$_GET['page']);
require_once(file_location('admin_inc_path','session_check.inc.php'));
if(isset($_GET['type'])){
	$typ = ($_GET['type']);
	$request_type = ['update account','delete account','become seller'];
	foreach($request_type AS $rt_type){if($rt_type === $typ){$type = $typ;break;}else{$type = 'unknown';}}
}else{
	trigger_error_manual(404);
}
$page = strtoupper($type)." REQUEST DATA";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
if($type === 'unknown'){trigger_error_manual(404);};
if(isset($_GET['page']) AND is_numeric($_GET['page'])){ //getting the value of the get 
	$cid = test_input(removenum($_GET['page']));
	if(!empty($cid)){	
		$id = content_data('seller_request_table','sr_id',$cid,'sr_id',"AND sr_type = '{$type}'");
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
			<h2 class='j-text-color1 j-padding j-color4'><b>PREVIEW <?=strtoupper($type)?> REQUEST DATA</b></h2>
		</div>
		<center>
			<div class='j-padding'>
				<a href="<?=file_location('admin_url',"request/request/{$type}/pending/")?>"class='j-bolder j-btn j-color1 j-right j-round j-card-4'>All <?=ucwords($type)?> Pending Requests</a>
				<span class='j-clearfix'></span>
			</div>
		</center>
		<br class='j-clearfix'>
		<div class='j-row'>
			<?php
			if($id === false){
				page_not_available('short');
			}else{
				$seller_id = content_data('seller_request_table','s_id',$id,'sr_id');
				$sr_mode = content_data('seller_request_table','sr_mode',$id,'sr_id');
				if($type === 'become seller'){
					$seller_email = content_data('seller_request_table','sr_email',$id,'sr_id','','null');
				}else{
					$seller_email = content_data('seller_table','s_email',$seller_id,'s_id','','null');
				}
				?>
				<div id=""class='j-col m7 j-padding'>
					<div class='j-color7'><div class='j-padding j-large'><b>Request Details</b></div></div>
					<div class="j-container j-color4 j-padding">
						<?php
						if($sr_mode === 'pending' || $sr_mode === 'ongoing'){
							preview_modal('seller_request',$id);
							?>
							<div class='j-show-inline-block'>
								<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#seller_request<?=$id?>markas').fadeIn('slow');">
								<i class='<?=icon('mark');?>'style='padding-right:5px;'></i>Mark As
								</span>
							</div>
							<?php
							if($type === 'delete account'){
								?>
								<div class='j-show-inline-block j-right'>
									<span class='j-clickable j-color1 j-btn j-round j-bolder'style="margin:3px;"onclick="$('#delete_seller<?=$seller_id?>').fadeIn('slow');">
										<i class='<?=icon('trash');?>'style='padding-right:5px;'></i>Delete seller Account
									</span>
								</div>
								<?php
								preview_modal('seller',$seller_id);
							}elseif($type === 'become seller'){
								$seller_email = content_data('seller_request_table','sr_email',$id,'sr_id','','null');
								?>
								<a href="<?=file_location('admin_url',"message/send_seller_email/{$seller_email}/")?>" class=' j-right j-bolder j-text-color4 j-btn j-color1 j-round'>
								Mail seller
								</a>
								<?php
							}
						}
						?>
						<span class='j-clearfix'></span>
						<br>
						<div class=''style='line-height: 40px;'>
								<div>
									<span class='j-bolder j-text-color7'>Request Type:</span><br>
									<span class='j-text-color7'><?=ucwords(content_data('seller_request_table','sr_type',$id,'sr_id','','null'))?></span>
								</div>
								<div>
									<span class='j-bolder j-text-color7'>Status:</span><br>
									<span class='j-text-color7'><?=ucwords($sr_mode)?></span>
								</div>
								<?php
								$details = "Details";
								if($type === 'become seller'){
									?>
									<div>
										<span class='j-bolder j-text-color7'>Name:</span><br>
										<span class='j-text-color7'><?=ucwords(content_data('seller_request_table','sr_name',$id,'sr_id','','null'))?></span>
									</div>
									<div>
										<span class='j-bolder j-text-color7'>Email:</span><br>
										<span class='j-text-color7'><?=ucwords($seller_email)?></span>
									</div>
									<div>
										<span class='j-bolder j-text-color7'>Phonenumber:</span><br>
										<span class='j-text-color7'><?=ucwords(content_data('seller_request_table','sr_phnumber',$id,'sr_id','','null'))?></span>
									</div>
								<?php
								$details = "Address";
								}
								?>
								<div>
									<span class='j-bolder j-text-color7'><?=$details?>:</span><br>
									<span class='j-text-color7'><?=ucwords(content_data('seller_request_table','sr_details',$id,'sr_id','','null'))?></span>
								</div>
								<div>
									<span class='j-bolder j-text-color7'>Sent on:</span><br>
									<span class='j-text-color7'><?=ucwords(content_data('seller_request_table','sr_regdatetime',$id,'sr_id','','null'))?></span>
								</div>
							</div>
					</div>
					
				</div>
				
				
				<div id=""class='j-col m5 j-padding'>
					<?php
					if($type === 'update account' || $type === 'delete account'){
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
							</div>
						</div>
						<br>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
			<span id="st"></span>
		</div>
<br>
	</div>
</div>
<!-- BODY ENDS -->
<?php require_once(file_location('admin_inc_path','js.inc.php'));?>
</body>
</html>