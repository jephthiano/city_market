<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
$page_url = file_location('home_url','account/change_password/');
require_once(file_location('inc_path','session_check.inc.php'));
//for meta
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png');
$image_type = substr($image_link,-3);
$page = "CHANGE PASSWORD | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
insert_page_visit('change password');
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
				<?php get_header('CHANGE PASSWORD','account/')?>
				<div class='j-padding'>
					<form onsubmit="event.preventDefault();"class=''id='chpsfrm'>
						<span class='j-text-color1 mg'id='alle'></span>
						<label class=""><b>Old Password</b> <span class='j-text-color1 mg'id='pse'></span></label><br>		
						<input type="password"class="pss  j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Old password"
						  name="ps"id="ps"value=""style="width:100%;max-width:400px"/><br>
						  
						<label class=""><b>New Password</b> <span class='j-text-color1 mg'id='pse2'></span></label><br>		
						<input type="password"class="pss  j-input j-medium j-border-2 j-border-color5 j-round"placeholder="New Password"
						  name="ps2"id="ps2"value=""style="width:100%;max-width:400px"/><br>
						  
						<label class=""><b>Retype New Password</b> <span class='j-text-color1 mg'id='pse3'></span></label><br>		
						<input type="password"class="pss  j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Retype-password"
						  name="ps3"id="ps3"value=""style="width:100%;max-width:400px"/><br>
						  
						<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder"style="width:100%;max-width:400px;">Change Password</button>
					</form>
				</div>
				<br>
			</div>
		</div>
	</div>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>