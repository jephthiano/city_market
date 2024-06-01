<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
if(isset($_POST['s']) && isset($_POST['pg'])){
	$searchtext = test_input(($_POST['s']));
	$cur_page = test_input(($_POST['pg']));
	require_once(file_location('admin_inc_path','pagination_total.inc.php'));
	
	if(!empty($searchtext)){ // if the search text is not empty
		$searchtext = $searchtext."*";
		$sql = "SELECT sc_id,sc_icon,sc_sub_category,c_id FROM sub_category_table
		WHERE (MATCH(sc_sub_category) AGAINST(:searchtext IN BOOLEAN MODE))
		ORDER BY MATCH(sc_sub_category) AGAINST(:searchtext IN BOOLEAN MODE)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':searchtext',$searchtext,PDO::PARAM_STR);
	}else{ // if it the field is empty
		$sql = "SELECT sc_id,sc_icon,sc_sub_category,c_id FROM sub_category_table
		ORDER BY sc_id DESC LIMIT $start,$display";
		$stmt = $conn->prepare($sql);
	}// end of if empty($searchtext)
	$stmt->bindColumn('sc_id',$id);
	$stmt->bindColumn('sc_icon',$icon);
	$stmt->bindColumn('sc_sub_category',$sc_sub_category);
	$stmt->bindColumn('c_id',$c_id);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){// if a record is found
		if(empty($searchtext)){$numRow = $total_records;}
		?>
		<center>
			<div class="j-responsive"style='line-height:27px;'>
				<p class="j-text-color5">
					<b><?=empty($searchtext)?$numRow.' Sub category found':$numRow." result(s) found for <span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in sub category";?></b>
				</p>
				<table class="j-table-all j-border-0">
					<tr class="j-border-0 j-text-color1">
						<td><b>S/N</b></td><td><b>Sub category</b></td><td><b>Image</b></td><td><b>Icon</b></td><td><b>Category</b></td><td><b>Preview</b></td>
						<?php if($adlevel > 1){ ?>
						<td><b>Edit</b></td><td><b>Delete</b></td>
						<?php } ?>
					</tr>
					<?php
					while($stmt->fetch()){
						?>
						<tr class="j-border-0">
							<td><?php s_n();?></td><td><?=ucwords(($sc_sub_category));?></td>
							<td><img class='j-round'src="<?=file_location('media_url',get_media('subcategory',$id))?>"style='width:50px;height:50px;'/></td>
							<td><i class="<?=icon($icon);?>"></i></td><td><?=get_category_name($c_id)?></td>
							<td><a href='<?= file_location('admin_url','category/preview_subcategory/'.addnum($id))?>'><i class="j-large <?= icon('eye');?>"></i></a></td>
							<?php if($adlevel > 1){ ?>
							<td><a href='<?= file_location('admin_url','category/update_subcategory/'.addnum($id))?>'><i class="j-large <?= icon('edit');?>"></i></a></td>
							<td><i class="j-large <?= icon('trash');?> j-clickable"onclick="$('#delete_subcategory<?=$id?>').fadeIn('slow');"></i></td>
							<?php } ?>
						</tr>
						<?php
						preview_modal('subcategory',$id);
					}// end of while
					?>
				</table>
			</div>
		</center>
		<?php
	}else{
		?>
		<br>
		<center>
			<div class='j-text-color5'>
				<b><?=empty($searchtext)?"0 sub category found":"0 result found for <b><span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in sub category";?></b>
			</div>
		</center>
			<?php
		}// end of if $numRow
		
		require_once(file_location('admin_inc_path','pagination_button.inc.php'));
}// end of if isset
?>
<br><br><br><br>