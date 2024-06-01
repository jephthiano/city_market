<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
$follow_type = 'no follow';
$image_link = file_location('media_url','home/logo.png'); $image_type = substr($image_link,-3);
$page_url = file_location('admin_url','category/update_category/'.$_GET['page']);
$page = "UPDATE CATEGORY";
$page_name = $page." | ".strtoupper(get_xml_data('company_name'));
require_once(file_location('admin_inc_path','session_check.inc.php'));
if($adlevel < 2){trigger_error_manual(404);}
if(isset($_GET['page']) AND is_numeric($_GET['page'])){ //getting the value of the get 
	$cid = test_input(removenum($_GET['page']));
	if(!empty($cid)){	
		$id = content_data('category_table','c_id',$cid,'c_id');
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
			<h2 class='j-text-color1 j-padding j-color4'><b>UPDATE CATEGORY</b></h2>
		</div>
		<div class='j-padding'>
			<a href="<?=file_location('admin_url','category/')?>"class='j-margin j-btn j-color1 j-left j-round j-card-4'><b>All Category</b></a>
			<a href="<?=file_location('admin_url','category/insert_category/')?>"class='j-btn j-color1 j-right j-round j-card-4 j-bolder'>Insert New Category</a>
			<br class='j-clearfix'>
		</div>
		<div id=""class='j-color4'style='padding-top: 9px;'>
			<?php
			if($id === false){
				page_not_available('short');
			}else{
				?>
				<div class='j-padding'>
					<div id='preview'class='j-border-color5 j-border j-circle j-color5 j-vertical-center-container j-clickable'style='width:100px;height:100px;'
						 onclick="$('#category<?=$id?>_pics_modal').fadeIn('slow');">
						<img src='<?=file_location('media_url',get_media('category',$id))?>'alt=''class='j-round j-card-4'style='width:100px;height:100px;border:solid 2px white'>
						<span class='j-text-color4 j-bold j-vertical-center-element'style='font-size:40px;'>+</span>
					</div>
					<?php image_modal('category',$id)?>
				</div>
				<form onsubmit="event.preventDefault();"class=''id='upscg'>
					<div class='j-row'>
						<div class='j-col m6 j-padding'>
							<label class="j-large j-text-color7"><b>Category:</b> <span class='j-text-color1 mg'id="cte">*</span></label>
							<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Category"maxlength='50'
								name="ct"id="ct"value="<?=(content_data('category_table','c_category',$id,'c_id'))?>"style="width:100%;"/>
							<label class="j-large j-text-color7"><b>Icon</b> <span class='j-text-color1 mg'id='ice'>*</span></label><br>
							<input type="text"class="j-input j-medium j-border-2 j-border-color5 j-round"placeholder="Icon"maxlength='50'
								name="ic"id="ic"value="<?=content_data('category_table','c_icon',$id,'c_id')?>"style="width:100%;"/><br>
						</div>
					</div>
					
					<input type='hidden'name='tid'value='<?=addnum($id)?>'/>
					
					<div class='j-margin'>
						<button type='submit'id='sbtn'class="j-btn j-medium j-color1 j-round j-bolder">Update Category</button>
					</div>
				</form>
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