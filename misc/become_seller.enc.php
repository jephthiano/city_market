<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php'); // all functions
require_once(file_location('inc_path','session_check_nologout.inc.php'));
$data = "become seller";
$follow_type = 'follow';
$image_link = file_location('media_url','home/logo.png');
$image_type = substr($image_link,-3);
$page = strtoupper($data)." | ".strtoupper(get_xml_data('company_name'));
$page_name = $page." | ".get_xml_data('seo_tag');
$page_url = file_location('home_url','misc/become_seller/');
$keywords = get_json_data('keywords','about_us')."|".$page_name;
$description = $page_name;
insert_page_visit($data);
?>
<!DOCTYPE html>
<html>
<head><?php require_once(file_location('inc_path','meta.inc.php'));?><title><?=$page_name?></title></head>
<body id="body"class="j-color6"style="font-family:Roboto,sans-serif;">
	<?php require_once(file_location('inc_path','page_load.inc.php')); //page load?>
	<?php misc_header($data) //misc header?>
	<div class='j-misc-padding'>
			<div class='j-color j-padding'>
				<div class='j-text-color3 j-large'><b><?=ucwords(get_xml_data('company_name').' '.$data)?> Form</b></div><br>
				<div class='j-padding-contact j-row'>
					<div class='j-col m6'>
						<form id='insbcselfrm'>
							<label><b>Fullname: </b><span class='mg j-text-color1'id='fne'></span></label><br>
							<input type='text'id='fn'name='fn'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
							value=''placeholder='Fullname'maxlength='50'style="width:100%;max-width:400px;"/><br>
							
							<label><b>Email: </b><span class='mg j-text-color1'id='eme'></span></label><br>
							<input type='email'id='em'name='em'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
							value=''placeholder='Email'maxlength='70'style="width:100%;max-width:400px;"/><br>
							  
							<label><b>Phone Number: </b><span class='mg j-text-color1'id='phe'></span></label><br>
							<input type='tel'id='ph'name='ph'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
							 value=''placeholder='Phone Number'maxlength='50'style="width:100%;max-width:400px;"/><br>
							
							<label><b>Address: </b><span class='mg j-text-color1'id='ade'></span></label><br>
							<textarea name='ad'class='ip j-input j-medium j-color4 j-round j-border-2 j-border-color5'placeholder='Address'maxlength='350'
							 style="width:100%;max-width:400px;"></textarea><br>
							
							<button type='submit'id='acbtn'class="j-btn j-medium j-color1 j-round j-bolder"style="width:100%;max-width:400px;">Submit Form</button>
						   </form>
					</div>
				</div>
			</div>
	</div>
	<br>
	<div><?php require_once(file_location('inc_path','footer.inc.php')); //footer?></div>
	<span id='st'></span>
	<?php require_once(file_location('inc_path','js.inc.php')); //js?>
</body>
</html>