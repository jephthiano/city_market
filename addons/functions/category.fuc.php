<?php
//PRODUCT FUNCTION STARTS
//function get category starts
function get_category($product_category='',$status='options'){
 // creating connection
  require_once(file_location('inc_path','connection.inc.php'));
  @$conn = dbconnect('admin','PDO');
  if($status === 'home_data'){
   $sql = "SELECT c_id,c_category,c_icon FROM category_table WHERE c_id = '{$product_category}' ORDER BY c_id";
  }else{
   $sql = "SELECT c_id,c_category,c_icon FROM category_table";
  }
	$stmt = $conn->prepare($sql);
	$stmt->bindColumn('c_id',$id);
	$stmt->bindColumn('c_category',$category);
  $stmt->bindColumn('c_icon',$icon);
	$stmt->execute();
	$numRow = $stmt->rowCount();
  if($numRow > 0){		// if a record is found
   while($stmt->fetch()){
    if($status === 'options'){
     ?>
    <option value='<?=$id?>'<?php if($product_category === $id){echo 'selected';}?>>
      <?=ucwords($category)?>
    </option>
     <?php
    }elseif($status === 'slideshow'){
     ?>
     <a href='<?=file_location('home_url','category/category/'.strtolower(urlencode($category).'/'))?>'>
     <div class='j-row'>
      <div class='j-col s2'><i class="<?=icon($icon)?>"style='padding-right:8px;'></i></div>
      <div class='j-col s10'><b><?=ucwords($category)?></b></div>
			</div>
     </a>
     <?php
    }elseif($status === 'category_page' || $status === 'home_data'){
      ?>
      <a href='<?=file_location('home_url','category/category/'.$category.'/')?>'>
       <div class='j-col <?=$status === 'home_data'?'s6 m4 l2':'s6 m4 l3'?> j-section j-display-container j-clickable j-round'style='padding:3px 3px 3px 3px'>
        <div class='j-color4 j-card-4 j-display-container j-text-color4 j-round'style="height:150px;background-image:url('<?=file_location('media_url',get_media('category',$id))?>');background-size:cover;">
         <div class='j-display-bottommiddle j-round'style='width:100%;background-color:rgba(0,0,0,0.7);min-height:30px;'>
          <center><div class='j-medium'><b><?=ucwords($category)?></b></div></center>
         </div>
        </div>
       </div>
      </a>
      <?php
    }
   }
  }
}
//function get category ends

//function get category name starts
function get_category_name($id){
  $category = content_data('category_table','c_category',$id,'c_id');
  if($category === false){
    return 'others';
  }else{
   return $category; 
  }    
}
//function get category name ends

//function get subcategory name starts
function get_subcategory_name($id){
  $subcategory = content_data('sub_category_table','sc_sub_category',$id,'sc_id');
  if($subcategory === false){
    return 'others';
  }else{
   return $subcategory; 
  }    
}
//function get subcategory name ends

//function sub category select starts
function get_subcategory($c_id='',$sc_id='',$status='options'){
  if($c_id == 0 || is_numeric($c_id) || is_null($c_id)){
    ?><option value=''>Select sub category</option><?php
    // creating connection
    require_once(file_location('inc_path','connection.inc.php'));
    @$conn = dbconnect('admin','PDO');
    if($c_id == 0 || is_null($c_id)){
      $sql = "SELECT sc_id,sc_sub_category,sc_icon,c_id FROM sub_category_table WHERE c_id = 0 OR c_id IS NULL";
      $stmt = $conn->prepare($sql);
    }else{
      
      $sql = "SELECT sc_id,sc_sub_category,sc_icon,c_id FROM sub_category_table WHERE c_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':id',$c_id,PDO::PARAM_INT);
    }
    $stmt->bindColumn('sc_id',$id);
    $stmt->bindColumn('sc_sub_category',$subcategory);
    $stmt->bindColumn('sc_icon',$icon);
    $stmt->execute();
    $numRow = $stmt->rowCount();
    if($numRow > 0){		// if a record is found
      while($stmt->fetch()){
        if($status === 'options'){
          ?>
          <option value='<?=$id?>'<?php if($sc_id===$id){echo 'selected';}?>><?=ucwords($subcategory)?></option>
          <?php
        }
      }
    }
    ?><option value='others'<?php if($sc_id==0){echo 'selected';}?>>Others</option><?php
  }elseif(empty($c_id)){
    ?><option value=''>Select category first</option><?php
  }
}
//function sub category select ends
//PRODUCT FUNCTION ENDS
?>