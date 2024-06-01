<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');
require_once(file_location('admin_inc_path','session_check_nologout.inc.php'));
if(isset($_POST['s']) && isset($_POST['ty']) && isset($_POST['st']) && isset($_POST['pg'])){
	$searchtext = test_input(($_POST['s']));
	$status2 = test_input($_POST['st']);
	$type = test_input($_POST['ty']);
	$add = "AND sr_mode = '{$status2}'";
	$cur_page = test_input(($_POST['pg']));
	require_once(file_location('admin_inc_path','pagination_total.inc.php'));
	
	if(!empty($searchtext)){ // if the search text is not empty
		$searchtext = $searchtext."*";
		$sql = "SELECT sr_id,sr_name,sr_details,s_id,sr_regdatetime FROM seller_request_table
		WHERE (MATCH(sr_details) AGAINST(:searchtext IN BOOLEAN MODE)) AND sr_type = '{$type}' {$add}
		ORDER BY MATCH(sr_details) AGAINST(:searchtext IN BOOLEAN MODE)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':searchtext',$searchtext,PDO::PARAM_STR);
	}else{ // if it the field is empty
		$sql = "SELECT sr_id,sr_name,sr_details,s_id,sr_regdatetime FROM seller_request_table
		WHERE sr_type = '{$type}' {$add} ORDER BY sr_id DESC LIMIT $start,$display";
		$stmt = $conn->prepare($sql);
	}// end of if empty($searchtext)
	$stmt->bindColumn('sr_id',$id);
	$stmt->bindColumn('sr_name',$seller);
	$stmt->bindColumn('sr_details',$details);
	$stmt->bindColumn('s_id',$seller_id);
	$stmt->bindColumn('sr_regdatetime',$regdatetime);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){// if a record is found
		if(empty($searchtext)){$numRow = $total_records;}
		?>
		<center>
			<div class="j-responsive"style='line-height:27px;'>
				<p class="j-text-color5">
					<b><?=empty($searchtext)?$numRow.' Request(s) found':$numRow." result(s) found for <span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in ".$status2." requests";?></b>
				</p>
				<table class="j-table-all j-border-0">
					<tr class="j-border-0 j-text-color1">
						<td><b>S/N</b></td>
						<?php
						if($type === 'become seller'){
							?><td><b>Name</b></td><td><b>Address</b></td><?php
						}else{
							?><td><b>Seller</b></td><td><b>Details</b></td><?php
						}
						?>						
						<td><b>Date</b></td><td><b>Preview</b></td>
					</tr>
					<?php
					while($stmt->fetch()){
						if($type === 'update account' || $type === 'delete account'){
							$seller = content_data('seller_table','s_storename',$seller_id,'s_id','','null');
						}
						?>
						<tr class="j-border-0">
							<td><?php s_n();?></td>
							<td><?=ucwords($seller)?></td>
							<td><?=ucwords(text_length($details,20,'dots'))?></td>
							<td><?=showdate($regdatetime,'')?></td>
							<td><a href='<?= file_location('admin_url',"request/preview_request/{$type}/".addnum($id)."/")?>'><i class="<?= icon('eye');?>"></i></a></td>
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
				<b><?=empty($searchtext)?"0 $status2 request found":"0 result found for <b><span class='j-text-color1'> '".remove_last_value($searchtext)."' </span> in ".$status2." request";?></b>
			</div>
		</center>
			<?php
		}// end of if $numRow
		
		require_once(file_location('admin_inc_path','pagination_button.inc.php'));
}// end of if isset
?>
<br><br><br><br>