<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('seller_url','inbox/message/'.@$_GET['val'].'/');
require_once(file_location('seller_inc_path','session_check.inc.php'));
if(isset($_GET['val'])){
	$raw_val = test_input(($_GET['val']));
	if(!empty($raw_val)){$group = content_data('seller_notification_table','sn_group',$raw_val,'sn_group');}else{trigger_error_manual(404);}
}else{
	trigger_error_manual(404);
}
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page = "MESSAGE";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
insert_page_visit('message');
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<div class='j-hide-small j-hide-medium'><?php require(file_location('seller_inc_path','navigation.inc.php')); //navigation?></div>
	<div class='j-row j-home-padding'style='padding-top:0px;'>
		<div class='j-col l4 xl3 '><?php require_once(file_location('seller_inc_path','account_first_column.inc.php')); //account first column?></div>
		<div class='j-col l8 xl9 j-padding-flexible'>
			<div class='j-color4 j-account-height'>
					<?php
					$pass = false;
					$seller_id = content_data('seller_notification_table','s_id',$group,'sn_group',"AND s_id = {$slid}");
					if($group === 'general'){ $pass = true; }elseif($slid == $seller_id){ $pass = true; } // get if it is general message elseif it is seller message
					if($group === false || $pass === false){
						trigger_error_manual(404);
					}else{
						//change all notification status to seen
						$notification = new order('admin');
						$notification->group = $group;
						$notification->change_seller_noti_status('change_read');
						$type = strtoupper($group);
						//update the last check of general message
						if($group === 'general'){
							$notification = new order('admin');
							$notification->update_last_check();
						}
						?>
						<?php get_header("{$type} MESSAGE",'inbox/','','seller_url')?>
						<div class='j-padding'>
							<?php
							if($group === 'general'){
								$dat = multiple_content_data('seller_notification_table','sn_id',$group,'sn_group',"ORDER BY sn_id DESC",);
							}else{
								$dat = multiple_content_data('seller_notification_table','sn_id',$slid,'s_id',"AND sn_group = '{$group}' ORDER BY sn_id DESC",);
							}
							if($dat !== false){
							foreach($dat AS $n_id){
								?>
								<div class='j-padding j-round j-color6'style='width:90%;max-width:400px;'>
									<div class='j-bolder'style='line-height: 30px;'>
										<span><?=ucwords(content_data('seller_notification_table','sn_title',$n_id,'sn_id','','null'))?></span>
									</div>
									<div><?=ucfirst(content_data('seller_notification_table','sn_message',$n_id,'sn_id','','null'))?></div>
									<div class='j-bolder j-text-color3 j-right j-small'>
										<?php $date = content_data('seller_notification_table','sn_regdatetime',$n_id,'sn_id','','null');?>
										<?=show_date($date)?>
										<span style='margin-left:4px;'><?=show_time($date)?></span>
									</div>
									<br class='j-clearfix'>
								</div>
								<br>
								<?php
							}
							}
							?>
							<br>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	<span id='st'></span>
	<?php require_once(file_location('seller_inc_path','js.inc.php')); //js?>
</body>
</html>