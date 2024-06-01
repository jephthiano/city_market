<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
if(isset($_POST['s']) && isset($_POST['st']) && isset($_POST['pg'])){
	$searchtext = test_input(($_POST['s']));
	$status2 = ($_POST['st']);
	if($status2 === 'all'){$add = "s_status != ''";}else{$add = "s_status = '{$status2}'" ;}
	$cur_page = test_input(($_POST['pg']));
	require_once(file_location('admin_inc_path','pagination_total.inc.php'));
	
	if(!empty($searchtext)){ // if the search text is not empty
		$searchtext2 = $searchtext."*";
		$sql = "SELECT s_id,s_fullname,s_storename,s_type,s_status,s_regdatetime FROM seller_table
		WHERE (MATCH(s_email,s_fullname,s_storename) AGAINST(:searchtext IN BOOLEAN MODE)) AND {$add}
		ORDER BY MATCH(s_email,s_fullname,s_storename) AGAINST(:searchtext IN BOOLEAN MODE)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':searchtext',$searchtext2,PDO::PARAM_STR);
	}else{ // if it the field is empty
		$sql = "SELECT s_id,s_fullname,s_storename,s_type,s_status,s_regdatetime FROM seller_table
		WHERE {$add} ORDER BY s_id DESC LIMIT $start,$display";
		$stmt = $conn->prepare($sql);
	}// end of if empty($searchtext)
	$stmt->bindColumn('s_id',$id);
	$stmt->bindColumn('s_fullname',$fullname);
	$stmt->bindColumn('s_storename',$storename);
	$stmt->bindColumn('s_type',$type);
	$stmt->bindColumn('s_status',$status);
	$stmt->bindColumn('s_regdatetime',$regdatetime);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){// if a record is found
		if(empty($searchtext)){$numRow = $total_records;}
		?>
		<center>
			<div class="j-responsive"style='line-height:27px;'>
				<p class="j-text-color5">
					<b><?=empty($searchtext)?$numRow.' Seller(s) found':$numRow." result(s) found for <span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in ".$status2." sellers";?></b>
				</p>
				<table class="j-table-all j-border-0">
					<tr class="j-border-0 j-text-color1">
						<td><b>S/N</b></td><td><b>Storename</b></td><td><b>Image</b></td><td><b>Fullname</b></td><td><b>Store Type</b></td>
						<?php if($status2 === 'all'){echo '<td><b>Status</b></td>';}?><td><b>Reg Date</b></td>
						<td><b>Preview</b></td>
					</tr>
					<?php
					while($stmt->fetch()){
						?>
						<tr class="j-border-0">
							<td><?php s_n();?></td><td><?=ucwords(($storename))?></td>
							<td><img class='j-round'src="<?=file_location('media_url',get_media('seller',$id,'human'))?>"style='width:50px;height:50px;'/></td>
							<td><?=ucwords(($fullname))?></td><td><?=ucwords(($type))?></td>
							</td><?php if($status2 === 'all'){echo '<td>'.ucwords(($status)).'</td>';}?><td><?=showdate($regdatetime,'')?></td>
							<td><a href='<?= file_location('admin_url','seller/preview_seller/'.addnum($id))?>'><i class="j-large <?= icon('eye');?>"></i></a></td>
						</tr>
						<?php
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
				<b><?=empty($searchtext)?"0 $status2 seller found":"0 result found for <b><span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in ".$status2." seller";?></b>
			</div>
		</center>
	<?php
	}// end of if $numRow
	
	require_once(file_location('admin_inc_path','pagination_button.inc.php'));
}
?>
<br><br><br><br>