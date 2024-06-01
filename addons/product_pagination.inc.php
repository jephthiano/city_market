<?php
// creating connection
require_once(file_location('inc_path','connection.inc.php'));
@$conn = dbconnect('admin','PDO');
//PAGINATION CODE START HERE
$display = 12; // number of records to show per page
//calculate the number of pages
if(php_self('/account/viewed.enc.php','home')){ //for recent view
  $total_records = get_numrow('viewed_table','v_token',$view_token,"return",'no round');
}elseif(php_self('/category/product.enc.php','home')){ // for category product page
  $total_records = get_numrow('product_table,seller_table','p_category',$val,"return",'no round',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC");
}elseif(php_self('/brand/index.php','home')){ // for brand product page
  $total_records = get_numrow('product_table,seller_table','p_brand',$brand,"return",'no round',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC");
}elseif(php_self('/store/index.php','home')){ // for store product page
  $total_records = get_numrow('product_table,seller_table','product_table.s_id',$s_id,"return",'no round',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC");
}elseif(php_self('/account/wishlist.enc.php','home')){ //for wishlist
  $total_records = get_numrow('wishlist_table','u_id',$u_id,"return",'no round');
}elseif(php_self('/inbox/index.php','home') || php_self('/inbox/index.php','seller')){ //for inbox
  if($user === 'seller'){
    $total_records = distinct_numrow('seller_notification_table','sn_group','s_id',$slid,"return",'no round',"OR s_id IS NULL");   
  }elseif($user === 'user'){
    $total_records = distinct_numrow('user_notification_table','or_id','u_id',$u_id,"return",'no round'); 
  }  
}elseif(php_self('/review/product_review.enc.php','home')){ //for product_review
  if($level === 'all'){$add="";}else{$add="AND r_rating = {$level}";}
  $total_records = get_numrow('review_table','p_id',$id,"return",'no round',$add);
}elseif(php_self('/review/seller_review.enc.php','home')){ //for seller_review
  if($level === 'all'){$add="";}else{$add="AND r_rating = {$level}";}
  $total_records = get_numrow('review_table','s_id',$id,"return",'no round',$add);
}elseif(php_self('/review/index.php','home')){ //for pending review
  $add = "AND or_status = 'delivered' AND or_review = 'no' ORDER BY or_id DESC";
  $total_records = get_numrow('order_table','user_id',$u_id,"return",'no round',$add);
}elseif(php_self('/order/index.php','home') || php_self('/order/index.php','seller') || php_self('order/user_all_orders.enc.php','admin')){ //for order & admin order
  if($request_type === 'seller'){$query = 's_id';}else{$query = 'user_id';}
  if($type === 'order placed'){
    $total_records = get_numrow('order_table',$query,$u_id,"return",'no round',"AND or_status = 'order placed' ORDER BY or_id DESC");
  }elseif($type === 'in-transit'){
    $total_records = get_numrow('order_table',$query,$u_id,"return",'no round',"AND or_status IN ('confirmed','in-transit','packaging','ready-for-pickup') ORDER BY or_id DESC");
  }elseif($type === 'delivered'){
    $total_records = get_numrow('order_table',$query,$u_id,"return",'no round',"AND or_status = 'delivered' ORDER BY or_id DESC");
  }elseif($type === 'unsuccessful'){
    $total_records = get_numrow('order_table',$query,$u_id,"return",'no round',"AND or_status IN ('failed','cancelled','failed delivery','returned') ORDER BY or_id DESC");
  }
}elseif(php_self('/search.enc.php','home')){ //for search
  $searchtext2 = $searchtext."*";
  $sql = "SELECT p_id FROM product_table,seller_table
	WHERE p_status = 'available' AND MATCH(p_name,p_brand,p_content,p_details) AGAINST(:id IN BOOLEAN MODE) AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'
	ORDER BY MATCH(p_name,p_brand,p_content,p_details) AGAINST(:id IN BOOLEAN MODE)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':id',$searchtext2,PDO::PARAM_STR);
	$stmt->bindColumn('p_id',$id);
	$stmt->execute();
	$total_records = $stmt->rowCount(); 
}

if($total_records > $display){ // if the number of record is more than the displayed num(10)
  $total_pages = ceil($total_records / $display);
}else{ // if the number of record is not more than the displayed num(10)
  $total_pages = 1;
}
// getting the current page and where to start
if(isset($_GET['page']) and is_numeric($_GET['page'])){ // for other pages other than first page
  $cur_page = test_input($_GET['page']); // page value
  $current_page =  $cur_page; //  get the current page from the url if it is  not the first page
  $start = ($current_page * $display) - $display;
  // use the current page to determine the $start in the LIMIT
  if($cur_page > $total_pages){die(page_not_available(''));}// what to echo if the user enter more than maximum page
}else{ // if $_GET IS empty
  $current_page = 1;  $start = 0;// for the first page
}
//PAGINATION CODE PAUSE HERE


//SELECTING AND DISPLAYING CONTENT STARTS HERE
if(php_self('/account/viewed.enc.php','home')){ //for recent view
  $or = multiple_content_data('viewed_table','p_id',$view_token,'v_token',"ORDER BY v_id DESC LIMIT $start,$display");
  if($or !== false){
    ?><div class='j-row'><?php
    foreach($or AS $id){show_product($id,'viewed');}
    ?></div><?php
  }else{
    ?><center><div class='j-text-color7'>No recent viewed item is available at the moment, browse some items to have recent viewed</div></center><?php
  }
}elseif(php_self('/category/product.enc.php','home')){ // for category product page
  $or = multiple_content_data('product_table,seller_table','p_id',$val,'p_category',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC LIMIT $start,$display");
  if($or !== false){
    ?><div class='j-row'><?php
    foreach($or AS $id){show_product($id,'default');}
    ?></div><?php
  }else{
    ?><center><br><br><div class='j-text-color3'><b>No <?=$val == 0?'other':$val;?> product available</b></div></center><br><br><?php
  }
}elseif(php_self('/brand/index.php','home')){ // for brand product page
  $or = multiple_content_data('product_table,seller_table','p_id',$brand,'p_brand',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC LIMIT $start,$display");
  if($or !== false){
    ?><div class='j-row'><?php
    foreach($or AS $id){show_product($id,'default');}
    ?></div><?php
  }else{
    ?><center><br><br><div class='j-text-color3'><b>No <?=$val==='others'?'other ':$val;?> product available</b></div></center><br><br><?php
  }
}elseif(php_self('/store/index.php','home')){ // for store product page
  $or = multiple_content_data('product_table,seller_table','p_id',$s_id,'product_table.s_id',"AND p_status = 'available' AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active' ORDER BY p_id DESC LIMIT $start,$display");
  if($or !== false){
    ?><div class='j-row'><?php
    foreach($or AS $id){show_product($id,'default');}
    ?></div><?php
  }else{
    ?><center><br><br><div class='j-text-color3'><b>No product in <?=ucwords($store_name)?></b></div></center><br><br><?php
  }
}elseif(php_self('/account/wishlist.enc.php','home')){ //for wishlist
  $or = multiple_content_data('wishlist_table','p_id',$u_id,'u_id',"ORDER BY w_id DESC LIMIT $start,$display");
  if($or !== false){
    ?><div class='j-row'><?php
    foreach($or AS $id){show_product($id,'wishlist');}
    ?></div><?php
  }else{
    ?><center><div class='j-large j-text-color7 '>No saved item is available at the moment, browse some items and add to wishlist</div></center><?php
  }
}elseif(php_self('/inbox/index.php','home')){ //for inbox
  if($user === 'user'){
    $add = "ORDER BY n_id DESC LIMIT $start,$display";
    $dat = multiple_content_data('user_notification_table','or_id',$u_id,'u_id',$add,'unique');
    if($dat !== false){
      //change all notification status to seen
      $notification = new order('admin');
      $notification->change_user_noti_status('change_seen');
      foreach($dat AS $or_id){
        $id = content_data('order_table','p_id',$or_id,'or_id','','null');
        show_product($id,'inbox',$or_id);
      }
    }else{
      ?><center><span class='j-large j-text-color7'>You have no message at the moment</span><br></center><?php
    }
  }elseif($user === 'seller'){
    $add = "OR s_id IS NULL ORDER BY sn_id DESC LIMIT $start,$display";
    $dat = multiple_content_data('seller_notification_table','sn_group',$slid,'s_id',$add,'unique');
    if($dat !== false){
      //change all notification status to seen
      $notification = new order('admin');
      $notification->change_seller_noti_status('change_seen');
      foreach($dat AS $sn_group){
        notification_home($sn_group);
      }
    }else{
      ?><center><span class='j-large j-text-color7'>You have no message at the moment</span><br></center><?php
    }
  }
}elseif(php_self('/review/product_review.enc.php','home')){ //for product_review
  if($level === 'all'){$add="ORDER BY r_id DESC";}else{$add="AND r_rating = {$level} ORDER BY r_id DESC";}
  $or = multiple_content_data('review_table','r_id',$id,'p_id',$add." LIMIT $start,$display");
  if($or !== false){
    foreach($or AS $r_id){get_rating($r_id,'feedback');}
  }else{
    if($level === 'all'){
      ?><div class='j-text-color7'style='margin-top:8px;'>No rating is available at the moment</div><?php
    }else{
      ?><div class='j-text-color7'style='margin-top:8px;'>No rating is available for <?=$level?> star(s)</div><?php
    }
  }
}elseif(php_self('/review/seller_review.enc.php','home')){ //for seller_review
  if($level === 'all'){$add="ORDER BY r_id DESC";}else{$add="AND r_rating = {$level} ORDER BY r_id DESC";}
  $or = multiple_content_data('review_table','r_id',$id,'s_id',$add." LIMIT $start,$display");
  if($or !== false){
    foreach($or AS $r_id){get_rating($r_id,'feedback','seller');}
  }else{
    if($level === 'all'){
      ?><div class='j-text-color7'style='margin-top:8px;'>No rating is available at the moment</div><?php
    }else{
      ?><div class='j-text-color7'style='margin-top:8px;'>No rating is available for <?=$level?> star(s)</div><?php
    }
  }
}elseif(php_self('/review/index.php','home')){ //for pending review
  $add = "AND or_status = 'delivered' AND or_review = 'no' ORDER BY or_id DESC LIMIT $start,$display";
  $or = multiple_content_data('order_table','or_order_id',$u_id,'user_id',$add);
  if($or !== false){
    foreach($or AS $or_id){
      $id = content_data('order_table','p_id',$or_id,'or_order_id','','null');
      show_product($id,'pending review',$or_id);
    }
	}else{
    ?><center><br><span class='j-large'>You have no pending review at the moment</span><br><br><a href='<?=file_location('home_url','')?>'class='j-btn j-color1 j-round j-bolder'>Continue Shopping</a></center><?php
  }
}elseif(php_self('/order/index.php','home') || php_self('/order/index.php','seller') || php_self('/order/user_all_orders.enc.php','admin')){ //for order & admin & seller order
  if($type === 'order placed'){
    $or = multiple_content_data('order_table','or_id',$u_id,$query,"AND or_status = 'order placed' ORDER BY or_id DESC LIMIT $start,$display");
  }elseif($type === 'in-transit'){
    $or = multiple_content_data('order_table','or_id',$u_id,$query,"AND or_status IN ('confirmed','in-transit','packaging','ready-for-pickup') ORDER BY or_id DESC LIMIT $start,$display");
  }elseif($type === 'delivered'){
    $or = multiple_content_data('order_table','or_id',$u_id,$query,"AND or_status = 'delivered' ORDER BY or_id DESC LIMIT $start,$display");
  }elseif($type === 'unsuccessful'){
    $or = multiple_content_data('order_table','or_id',$u_id,$query,"AND or_status IN ('failed','cancelled','failed delivery','returned') ORDER BY or_id DESC LIMIT $start,$display");
  }
  if($or !== false){
    foreach($or AS $or_id){
      $id = content_data('order_table','p_id',$or_id,'or_id','','null');
      if($user === 'seller'){
        show_product($id,'order_details',$user,$or_id);
      }else{
        show_product($id,'order',$user,$or_id);
      }
    }
  }else{
    ?><center><div class='j-margin j-large j-text-color7'>No <?=$type?> <?= $type!== 'order placed'?'order':''?></div></center><?php
  }
}elseif(php_self('/search.enc.php','home')){ //for search
  $sql = "SELECT p_id FROM product_table,seller_table
	WHERE p_status = 'available' AND MATCH(p_name,p_brand,p_content,p_details) AGAINST(:id IN BOOLEAN MODE) AND product_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'
	ORDER BY MATCH(p_name,p_brand,p_content,p_details) AGAINST(:id IN BOOLEAN MODE) LIMIT :start,:display";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':id',$searchtext2,PDO::PARAM_STR);
  $stmt->bindParam(':start',$start,PDO::PARAM_INT);
  $stmt->bindParam(':display',$display,PDO::PARAM_INT);
	$stmt->bindColumn('p_id',$id);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
		?><div class='j-row'>
			<center><br><div class='j-text-color3'><b><?=$total_records?> result(s) found for the keyword '<?=$searchtext?>'</b></div></center>
			<?php
			while($stmt->fetch()){show_product($id,'default');}
			?>
		</div><br><?php
	}else{
		?><center><br><br><div class='j-text-color7'><b>0 result found for the keyword '<?=$searchtext?>', try searching for another keyword</b></div></center><br><br><?php 
	}
}
//SELECTING AND DISPLAYING CONTENT ENDS HERE



//MAKING THE NEXT, CURRENT AND PREVIOUS BUTTON LINKS STARTS
if($total_pages > 1){ //create next,previous and other links if pages are more than 1
  $location_type = 'home_url';
  //setting the url
  if(php_self('/account/viewed.enc.php','home')){ //for recent view
    $url = 'account/viewed/';
  }elseif(php_self('/category/product.enc.php','home')){ // for category product page
    $url = 'category/product/'.$val.'/';
  }elseif(php_self('/brand/index.php','home')){ // for brand product page
    $url = 'brand/'.$brand.'/';
  }elseif(php_self('/store/index.php','home')){ // for store product page
    $url = 'store/'.$store_name.'/';
  }elseif(php_self('/account/wishlist.enc.php','home')){ //for wishlist
    $url = 'account/wishlist/';
  }elseif(php_self('/inbox/index.php','home')){ //for inbox
    if($user === 'user'){
      $location_type = 'home_url';
    }elseif($user === 'seller'){
      $location_type = 'seller_url';
    }
    $url = 'inbox/';
  }elseif(php_self('/review/product_review.enc.php','home')){ //for product_review
    $url = 'review/product_review/'.addnum($id).'/'.$level.'/';
  }elseif(php_self('/review/seller_review.enc.php','home')){ //for seller_review
    $url = 'review/seller_review/'.addnum($id).'/'.$level.'/';
  }elseif(php_self('/review/index.php','home')){ //for pending review
    $url = 'review/';
  }elseif(php_self('/order/index.php','home') || php_self('/admin/order/user_all_orders.enc.php','home')){ //for order
    if($user === 'admin'){
      $location_type = 'admin_url';
      $url = 'order/user_all_orders'.addnum($u_id).'/'.$type.'/';
    }elseif($user === 'seller'){
      $location_type = 'seller_url';
      $url = 'order/'.$type.'/'; 
    }else{
      $location_type = 'home_url';
      $url = 'order/'.$type.'/'; 
    }
  }elseif(php_self('/search.enc.php','home')){ //for search
    $url = 'search/'.$searchtext.'/';
  }
  ?>
  <div class="j-center j-container">
    <br><br>
    <?php
    // previous button (if the page is not first page)
    if($current_page != 1){
      ?><a class='j-button j-color1 j-round-large j-left j-bolder'style='position:relative;top:-4px;'href="<?=file_location($location_type,$url.($current_page-1).'/')?>"><<</a> <?php
    }
    // other pages start
    //for start and end pagination link
    if($current_page <= 2){$start_link = 1;}else{$start_link = $current_page-2;}
    if(($current_page + 2) > $total_pages){$end_link = $total_pages;}else{$end_link = $current_page + 2;}
    //for first page
    if($current_page  > 3){?><a class='j-button j-color5 j-tiny j-bolder' href="<?=file_location($location_type,$url.'1'.'/')?>">1</a> <span style='margin:10px;position:relative;top:5px;'><b>...</b></span> <?php }
    for($i = $start_link; $i <= $end_link; $i++){
      if($i != $current_page){//  link the other pages except current page
        ?><a class='j-button j-color5 j-tiny j-bolder' href="<?=file_location($location_type,$url.$i.'/')?>"><?=$i;?></a> <?php
      }else{// do not link the current page
        ?><span class='j-btn j-color1 j-tiny j-bolder'><?=$i;?></span> <?php
      }
    }//end of for
    //for last page
    if($current_page+2  < $total_pages){?><span style='margin:10px;position:relative;top:5px;'><b>...</b></span><a class='j-button j-color5 j-tiny' href="<?=file_location($location_type,$url.$total_pages.'/')?>"><?=$total_pages;?></a> <?php }
    // next button (if the current page is not the last page)
    if($current_page != $total_pages){
      ?><a class='j-button j-color1 j-round-large j-right j-bolder'style='position:relative;top:-4px;'href="<?=file_location($location_type,$url.($current_page+1).'/')?>">>></a><?php
    }
    ?>
    </div>
  <br><br>
  <?php
}// end of if($total_pages > 1)
//MAKING THE NEXT, CURRENT AND PREVIOUS BUTTON LINKS ENDS
?>