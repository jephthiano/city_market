<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','seller/update_seller/'.$_GET['page']);
$page = "UPDATE SELLER DATA";
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
		<div class='j-padding'>
			<h2 class='j-text-color1 j-padding j-color4'><b>UPDATE <?=strtoupper(content_data('seller_table','s_storename',$cid,'s_id'))?> DATA</b></h2>
		</div>
		<div class='j-padding'>
			<a href="<?=file_location('admin_url','seller/all/')?>" class="j-btn j-color1 j-right j-bolder j-round j-card-4">Show All Sellers</a>
			<br class='j-clearfix'>
		</div>
			<div id=""class='j-color4'style='padding-top:9px;'>
				<?php
				if($id === false){
					page_not_available('short');
				}else{
					?>
					<div class='j-row-padding'>
						<div class='j-col m6 j-padding'>
							<div class='j-color5'><div class='j-padding j-large'><b>SELLER'S DATA</b></div></div>
							<div class='j-padding j-border-2 j-round'>
								<form onsubmit="event.preventDefault();"class=''id='upsld'>
									<label class="j-large j-text-color7"><b>Email:</b> <span class='j-text-color1 mg'id='eme'>*</span></label>
									<input type="email"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Email"maxlength='50'
										   name="em"id="em"value="<?=content_data('seller_table','s_email',$id,'s_id')?>"style="width:100%;"/>
									<br>
									
									<label class="j-large j-text-color7"><b>Fullname:</b> <span class='j-text-color1 mg'id="fne">*</span></label>
									<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Fullname"maxlength='50'
										   name="fn"id="fn"value="<?=content_data('seller_table','s_fullname',$id,'s_id')?>"style="width:100%;"/>
									<br>
									
									<label class="j-large j-text-color7"><b>Storename:</b> <span class='j-text-color1 mg'id='sne'>*</span></label>
									<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Storename"maxlength='50'
										name="sn"id="sn"value="<?=content_data('seller_table','s_storename',$id,'s_id')?>"style="width:100%;"/>
									<br>
									
									<input type='hidden'name='tid'value='<?=addnum($id)?>'/>
									
									<button type='submit'id='sdbtn'class="j-btn j-medium j-color1 j-round j-bolder">Update Seller Data</button>
								</form>
							</div>
							<br>
							
							<div class='j-color2'><div class='j-padding j-large'><b>SELLER'S BANK ACCOUNT DATA</b></div></div>
							<div class='j-padding j-border-2 j-round'>
								<form onsubmit="event.preventDefault();"class=''id='upsbad'>
									<label><b>Account Name : </b><span class='mg j-text-color1'id='acne'></span></label><br>
									<input type='text'id='acn'name='acn'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
										value='<?=ucwords(content_data('seller_account_table','sa_name',$id,'s_id','','null'))?>'placeholder='Account Name'maxlength='100'style="width:100%;max-width:400px;"/>
									<br>
									
									<label><b>Account Number: </b><span class='mg j-text-color1'id='acnbe'></span></label><br>
									<input type='tel'id='acnb'name='acnb'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
										value='<?=(content_data('seller_account_table','sa_number',$id,'s_id','','null'))?>'placeholder='Account Number'maxlength='10'style="width:100%;max-width:400px;"/>
									<br>
										
									<label><b>Bank Name: </b><span class='mg j-text-color1'id='bne'></span></label><br>
									<input type='text'id='bn'name='bn'class="ip j-input j-color4 j-round j-border-2 j-border-color5"
										value='<?=ucwords(content_data('seller_account_table','sa_bank',$id,'s_id','','null'))?>'placeholder='Bank Name'maxlength='50'style="width:100%;max-width:400px;"/>
									<br>
									
									<input type='hidden'name='tid'value='<?=addnum($id)?>'/>
									
									<button type='submit'id='sbabtn'class="j-btn j-medium j-color1 j-round j-bolder">Update Seller Bank Account Data</button>
								</form>
							</div>
						</div>
						<div class='j-col m6 j-padding'>
							<div class='j-color7'><div class='j-padding j-large'><b>SELLER'S CONTACT DATA</b></div></div>
							<div class='j-padding j-border-2 j-round'>
								<form onsubmit="event.preventDefault();"class=''id='upslcd'>
									<label class="j-large j-text-color7"><b>Phone Number: </b> <span class='j-text-color1 mg'id='phe'>*</span></label>
									<input type='tel'id='ph'name='ph'class="j-input j-color4 j-round j-border-2 j-border-color5"
										value="<?=content_data('seller_contact_table','sc_phnumber1',$id,'s_id');?>"placeholder='Phone Number'maxlength='50'style="width:100%;"/>
									<br>
									
									<label class="j-large j-text-color7"><b>Add Phone Number: </b><span class='mg j-text-color1'id='ph2e'></span></label>
									<input type='tel'id='ph2'name='ph2'class="j-input j-color4 j-round j-border-2 j-border-color5"
										value='<?=content_data('seller_contact_table','sc_phnumber2',$id,'s_id');?>'placeholder='Additional Phone Number'maxlength='50'style="width:100%;"/>
									<br>
									
									<label class="j-large j-text-color7"><b>Address: </b><span class='mg j-text-color1'id='ade'></span></label><br>
									<textarea name='ad'class='j-input j-medium j-color4 j-round j-border-2 j-border-color5'placeholder='Address'maxlength='350'
										style="width:100%;"><?=content_data('seller_contact_table','sc_address',$id,'s_id');?></textarea>
									<br>
									
									<input type='hidden'name='tid'value='<?=addnum($id)?>'/>
									
									<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder">Update Seller Contact Data</button>
								</form>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<span id="st"></span>
			<br><br>
		</div>
	</div>
</div>
<!-- BODY ENDS -->
<?php require_once(file_location('admin_inc_path','js.inc.php'));?>
</body>
</html>