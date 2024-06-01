<?php
//REVIEW FUNCTION STARTS
// avg_rating starts (it return the avg rating of all product rating)
function avg_rating($id,$type='product'){
 if($type === 'seller'){
  $type_id = 's_id';
 }else{
  $type_id = 'p_id';
 }
 $total_rating = get_numrow('review_table',$type_id,$id,"return",'round');
 $total_sum = get_sum('review_table','r_rating',$id,$type_id);
 if($total_sum < 1){
  return 0;
 }else{
  return ($total_sum/$total_rating);
 }
}
// avg_rating ends

//start level starts (to get stars design)
function star_level($avg_rating){ 
 $floor = floor($avg_rating);
 for($i=0;$i<$floor;$i++){?><i class='j-text-color1 <?=icon('star')?>'></i><?php }
 if($avg_rating > $floor){?><i class='j-text-color1 <?=icon('star-half')?>'></i><?php }
}
//start level ends

//function get rating starts
function get_rating($id,$type='product',$mode='product'){
 if($mode === 'seller'){
  $total_rating = get_numrow('review_table','s_id',$id,"return",'round');
  $total_sum = get_sum('review_table','r_rating',$id,'s_id');
 }else{
  $total_rating = get_numrow('review_table','p_id',$id,"return",'round');
  $total_sum = get_sum('review_table','r_rating',$id,'p_id');
 }
 if($type === 'product'){
  $avg_rating = ($total_sum/$total_rating);
  star_level($avg_rating);
  ?>
  <span style='margin-left:5px;'><?=round($avg_rating,1)?></span>
  <span style='margin-left:5px;'>Review<?=$total_rating > 1 ?'s':''?> <b>(<?=$total_rating?>)</b></span>
  <?php
 }elseif($type === 'rating'){
  $avg_rating = ($total_sum/$total_rating);
  ?>
  <div class='j-row'>
   <div class='j-col s6 l12 j-padding'>
    <div class='j-color5 j-round j-center'style='padding:32px;'>
     <div class='j-xlarge j-text-color3'><span class='j-bolder j-xxlarge'><?=round($avg_rating,1)?></span>/5</div>
     <div class=''>
      <?php star_level($avg_rating);?>
					</div>
					<div class=' j-text-color3'><b><?=$total_rating?></b> Ratings</div>
				</div>
   </div>
   <div class='j-col s6 l12 j-padding'>
    <?php for($i=5;$i>0;$i--){
     $total_level_rating = get_numrow('review_table','p_id',$id,"return",'round',"AND r_rating = {$i}");
     ?>
     <div class='j-row'>
      <div class='j-col s5'>
       <span style='margin-right:5px;'><b><?=$i?></b></span><i style='margin-right:5px;' class='j-text-color1 <?=icon('star')?>'></i>
       <span>(<?=$total_level_rating?>)</span>
      </div>
      <div class='j-col s7'>
       <div class='j-color5 j-round'style='width:100%;height:10px;position:relative;top:8px;'>
        <div class='j-round j-color1'style='width:<?=(($total_level_rating/$total_rating)*100)?>%;height:10px;'></div>
       </div>
      </div>
     </div>
     <?php }?>
   </div>
  </div>
  <?php
 }elseif($type === 'feedback' || $type === 'second_column_feedback'){
  // creating connection
  require_once(file_location('inc_path','connection.inc.php'));
  @$conn = dbconnect('admin','PDO');
  $sql = "SELECT r_id,r_name,r_rating,r_title,r_feedback,r_regdatetime FROM review_table WHERE r_id = :id ORDER BY p_id DESC LIMIT 1";
		$stmt = $conn->prepare($sql);
  $stmt->bindParam(':id',$id,PDO::PARAM_INT);
		$stmt->bindColumn('r_id',$id);
  $stmt->bindColumn('r_name',$name);
		$stmt->bindColumn('r_rating',$rating);
		$stmt->bindColumn('r_title',$title);
		$stmt->bindColumn('r_feedback',$feedback);
  $stmt->bindColumn('r_regdatetime',$regdatetime);
		$stmt->execute();
		$numRow = $stmt->rowCount();
  if($numRow > 0){		// if a record is found
   while($stmt->fetch()){
    ?>
    <div style='line-height:29px;'>
     <div><b><?=ucfirst(decode_data($name))?></b></div>
     <div class=''>
      <?php
      for($i=0;$i<5;$i++){?><i class='<?=$i<$rating?'j-text-color1':'j-text-color5'?> <?=icon('star')?>'></i><?php }
      ?>
      </div>
     <div class='j-bolder'><?=ucfirst(decode_data($title))?></div>
     <div><?=convert_2_br(ucfirst(decode_data($feedback)))?></div>
     <div class='j-text-color7 j-bolder'><?=showdate($regdatetime,'short')?></div>
    </div>
    <hr>
    <?php
   }
  }
 }
}
//function get rating ends

//fucntion star scroll button starts (for scrolling horizonatlly of stars and it numrow)
function star_scroll_btn($id,$level,$type='product'){
 if($type === 'seller'){
  $cri_id = 's_id';
 }else{
  $cri_id = 'p_id';
 }
 ?>
 <div class='j-large j-vertical-scroll j-padding'style='overflow-y:hidden;'>
  <div class=""style="padding:10px 0px;display:inline">
   <a href='<?=file_location('home_url',"review/{$type}_review/".addnum($id).'/all/')?>'>
   <span class="j-padding j-clickable j-btn j-round-large j-small <?=$level == 'all'?'j-color1':'j-color5';?>">All (<?=get_numrow('review_table',$cri_id,$id,"return",'round')?>)</span>
   </a>
  </div>
  <?php
  for($i=1;$i<=5;$i++){
   ?>
   <div class=""style="padding:10px 0px;display:inline">
    <a href='<?=file_location('home_url',"review/{$type}_review/".addnum($id)."/{$i}/")?>'>
    <span class="j-padding j-clickable j-btn j-round-large j-small <?=$level == $i?'j-color1':'j-color5';?>">
    <?php for($x=0;$x<$i;$x++){?><i class='<?=icon('star','far')?>'></i><?php }?> (<?=get_numrow('review_table',$cri_id,$id,"return",'round',"AND r_rating = {$i}")?>)
    </span>
    </a>
   </div>
   <?php
  }
  ?>
 </div>
 <?php
}
//fucntion star scroll button ends
//REVIEW FUNCTION ENDS
?>