<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','seller/register_seller/');
$page = "REGISTER NEW SELLER";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('admin_inc_path','session_check.inc.php'));
if($adlevel != 3){trigger_error_manual(404);}
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
			<h2 class='j-text-color1 j-padding j-color4'><b>REGISTER NEW SELLER</b></h2>
		</div>
		<div class='j-padding'>
			<a href="<?=file_location('admin_url','seller/all/')?>" class="j-btn j-color1 j-right j-bolder j-round j-card-4">Show All Sellers</a>
			<br class='j-clearfix'>
		</div>
		<div id=""class='j-color4'style='padding-top:9px;'>
			<form onsubmit="event.preventDefault();"class=''id='insnsl'>
				<div class='j-row'>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Email:</b> <span class='j-text-color1 mg'id='eme'>*</span></label>
						<input type="email"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Email"maxlength='50'
							name="em"id="em"value=""style="width:100%;"/>
					</div>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Fullname:</b> <span class='j-text-color1 mg'id="fne">*</span></label>
						<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Fullname"maxlength='50'
							   name="fn"id="fn"value=""style="width:100%;"/>
					</div>
				</div>
				<div class='j-row'>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Storename:</b> <span class='j-text-color1 mg'id='sne'>*</span></label>
						<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Storename"maxlength='50'
							name="sn"id="sn"value=""style="width:100%;"/>
					</div>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Phone Number: </b> <span class='j-text-color1 mg'id='phe'>*</span></label>
						<input type='tel'id='ph'name='ph'class="j-input j-color4 j-round j-border-2 j-border-color5"
							value=''placeholder='Phone Number'maxlength='50'style="width:100%;"/>
					</div>
				</div>
				<div class='j-row'>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Additional Phone Number: </b><span class='mg j-text-color1'id='ph2e'></span></label>
						<input type='tel'id='ph2'name='ph2'class="j-input j-color4 j-round j-border-2 j-border-color5"
							value=''placeholder='Additional Phone Number'maxlength='50'style="width:100%;"/>
					</div>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Address: </b><span class='mg j-text-color1'id='ade'></span></label><br>
						<textarea name='ad'class='j-input j-medium j-color4 j-round j-border-2 j-border-color5'placeholder='Address'maxlength='350'
							style="width:100%;"></textarea>
					</div>
				</div>
				<div class='j-row'>
					<div class='j-col m6 j-padding'>
						<label class="j-large j-text-color7"><b>Mark As Official Store: </b><span class='mg j-text-color1'id='tye'></span></label>
						<input type='checkbox'id='ty'name='ty'class='j-medium j-checkbox'value='yes'/>
					</div>
				</div>
				<div class='j-margin'>
					<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder">Register New Seller</button>
				</div>
			</form>
			<span id="st"></span>
			<br><br>
		</div>
	</div>
</div>
<!-- BODY ENDS -->
<?php require_once(file_location('admin_inc_path','js.inc.php'));?>
</body>
</html>