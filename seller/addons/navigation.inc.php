<div style='margin-bottom:50px;z-index:2;'>
	<?php //code for large screen ?>
	<div id="nav"class="j-bar j-color4 j-text-color1 j-fixed-top j-card j-home-padding"style="margin:0px;font-size:12px;z-index:1;height:50px;width:100%;overflow-y:hidden">
		<a href="<?= file_location('seller_url','');?>"class="j-bar-item"style='padding:0px;'>
			<img src="<?=file_location('media_url','home/logo.png')?>"class=''alt="<?=strtoupper(get_xml_data('company_name'))?> LOGO IMAGE"style="width:150px;height:50px;">
		</a>
		<div class="j-right j-text-color3 j-large j-hide-small j-hide-mdium"style='paddin:7px 5px 5px 0px;'>
			<a href="<?= file_location('seller_url','inbox/');?>"class="j-bar-item j-button j-padding-16 j-display-container">
				<i class="<?=icon('envelope');?>"style='margin-right:5px;'></i><b>Inbox</b>
				<span class='ntf j-circle j-color1 j-small'style='width:20px;height:20px;position:absolute;top:5px;right:0px;'>0</span>
			</a>
			<a href="<?= file_location('seller_url','product/');?>"class="j-bar-item j-button j-padding-16">
				<i class="<?=icon('list-ul');?>"style='margin-right:5px;'></i><b>Products</b>
			</a>
			<a href="<?= file_location('seller_url','order/order placed/');?>"class="j-bar-item j-button j-padding-16">
				<i class="<?=icon('list-ul');?>"style='margin-right:5px;'></i><b>Orders</b>
			</a>
			<span class="dropdown-btn j-bar-item j-button j-padding-16">
				<i class="<?=icon('user-check');?>"></i> <b>Account</b>
			</span>
		</div>
	</div>
	<?php // small screen ?>
	<div class="j-hide-large j-hide-xlarge j-hide-medium j-card-4 j-color4 j-fixed-nav" style="margin:0px; font-size:12px;z-index:1">
		<div class="j-row-padding j-center" style="padding: 10px 0px">
			<div class="j-col s2">
				<a id='home2'href="<?= file_location('seller_url','');?>" <?php if(php_self('/index.php','seller')){?>onclick="iauulr('home')";<?php }?>>
					<span class="j-small <?=php_self('/index.php','seller')?'j-text-color1':'j-text-color7';?>"><i class="j-large <?=icon('home');?>"style='display:block'></i>Home</span>
				</a>
			</div>
			<div class="j-col s2">
				<a id=''href="<?= file_location('seller_url','inbox/');?>"class='j-display-container'style='display:relative;'>
					<span class="j-small <?=php_self('/inbox/index.php','seller')?'j-text-color1':'j-text-color7';?>">
						<i class="j-large <?=icon('envelope');?>"style='display:block'></i>Inbox
						<span class='ntf j-circle <?=php_self('/inbox/index.php','seller')?'j-color3':'j-color1';?> j-small'style='width:20px;height:20px;position:absolute;top:-5px;right:-9px;'>0</span>
					</span>
				</a>
			</div>
			<div class="j-col s3">
				<a id=''href="<?= file_location('seller_url','product/available/');?>">
					<span class="j-small <?=php_self('/product/index.php','seller')?'j-text-color1':'j-text-color7';?>">
					<i class="j-large <?=icon('list-ul');?>"style='display:block'></i>Products</span>
				</a>
			</div>
			<div class="j-col s2">
				<a id=''href="<?= file_location('seller_url','order/order placed/');?>">
					<span class="j-small <?=php_self('/order/index.php','seller')?'j-text-color1':'j-text-color7';?>">
					<i class="j-large <?=icon('list-ul');?>"style='display:block'></i>Orders</span>
				</a>
			</div>
			<div class="j-col s3 dropdown-btn">
				<span class=''>
					<span class="j-small <?=php_self('/account/index.php','seller')?'j-text-color1':'j-text-color7';?>">
						<i class="j-large <?=icon('user-check');?>"style='display:block'></i>Account
					</span>
				</span>
			</div>
		</div>
		<?php seller_modal('account');?>
	</div>
	<?php
	seller_modal('log_out');
	?>
	<div class='j-hide-small'><?php seller_modal('account');?></div>
</div>