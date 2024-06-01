<?php
//GET DATABASE FUNCTION STARTS
//get numrow starts
function get_numrow($tablename,$column='',$param='',$returntype = "return",$round='round',$add_cond='',$equal=''){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('admin','PDO');
 if(empty($column)){$where = '';}elseif($equal === 'not'){$where = "WHERE $column != :param";}else{$where = "WHERE $column = :param";}
	$sql = "SELECT * FROM $tablename {$where} {$add_cond}";
	$stmt = $conn->prepare($sql);
 if(!empty($column)){
  $stmt->bindParam(':param',$param,PDO::PARAM_STR);
 }
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 999 && $numRow < 999999){
		$rounded_numRow = round($numRow/1000,1);
		$rounded_numRow = $rounded_numRow."K";
	}elseif($numRow > 999999 && $numRow < 999999999){
		$rounded_numRow = round($numRow/1000000,1);
		$rounded_numRow = $rounded_numRow."M";
	}elseif($numRow > 999999999){
		$rounded_numRow = round($numRow/1000000000,1);
		$rounded_numRow = $rounded_numRow."B";
	}else{
  $rounded_numRow = $numRow;
 }
	if($returntype === "echo"){
		if($round === 'round'){echo $rounded_numRow;}else{echo $numRow;}
	}else{
  if($round === 'round'){return $rounded_numRow;}else{return $numRow;}
 }
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
//get numrow ends

//distinct numrow starts
function distinct_numrow($tablename,$id,$column='',$param='',$returntype = 'return',$round='round',$add_cond=''){
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('admin','PDO');
 if(empty($column)){$where = '';}else{$where = "WHERE $column = :param";}
	$sql = "SELECT DISTINCT $id FROM $tablename {$where} {$add_cond}";
	$stmt = $conn->prepare($sql);
 if(!empty($column)){
  $stmt->bindParam(':param',$param,PDO::PARAM_STR);
 }
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 999 && $numRow < 999999){
		$rounded_numRow = round($numRow/1000,1);
		$rounded_numRow = $rounded_numRow."K";
	}elseif($numRow > 999999 && $numRow < 999999999){
		$rounded_numRow = round($numRow/1000000,1);
		$rounded_numRow = $rounded_numRow."M";
	}elseif($numRow > 999999999){
		$rounded_numRow = round($numRow/1000000000,1);
		$rounded_numRow = $rounded_numRow."B";
	}else{
  $rounded_numRow = $numRow;
 }
	if($returntype === "echo"){
		if($round === 'round'){echo $rounded_numRow;}else{echo $numRow;}
	}else{
  if($round === 'round'){return $rounded_numRow;}else{return $numRow;}
 }
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
// distinct numrow ends

//order numrow starts
function get_order_numrow($param,$id,$returntype = "return",$round='round',$add_cond='',$type='user'){
 // creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('admin','PDO');
	if($type === 'user'){
		$sql = "SELECT or_id FROM order_table,orderer_table
		WHERE order_table.or_token = orderer_table.or_token AND u_id = :id AND or_status IN ($param)";
	}elseif($type === 'seller'){
		$sql = "SELECT or_id FROM order_table,orderer_table
		WHERE order_table.or_token = orderer_table.or_token AND s_id = :id AND or_status IN ($param)";
	}
 $stmt = $conn->prepare($sql);
 $stmt->bindParam(':id',$id,PDO::PARAM_INT);
 $stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 999 && $numRow < 999999){
		$rounded_numRow = round($numRow/1000,1);
		$rounded_numRow = $rounded_numRow."K";
	}elseif($numRow > 999999 && $numRow < 999999999){
		$rounded_numRow = round($numRow/1000000,1);
		$rounded_numRow = $rounded_numRow."M";
	}elseif($numRow > 999999999){
		$rounded_numRow = round($numRow/1000000000,1);
		$rounded_numRow = $rounded_numRow."B";
	}else{
  $rounded_numRow = $numRow;
 }
	if($returntype === "echo"){
		if($round === 'round'){echo $rounded_numRow;}else{echo $numRow;}
	}else{
  if($round === 'round'){return $rounded_numRow;}else{return $numRow;}
 }
	closeconnect("stmt",$stmt);
	closeconnect("db",$conn);
}
//order numrow ends

//content data starts
function content_data($table,$column,$param = '',$crit = '',$add = '',$null=''){
		// creating connection
		require_once(file_location('inc_path','connection.inc.php'));
		@$conn = dbconnect('admin','PDO');
		if(empty($crit)){
			$where = '';
		}else{
			$where = "WHERE $crit = :id {$add}";
		}
  $sql = "SELECT $column FROM $table $where LIMIT 1";
		$stmt = $conn->prepare($sql);
		if(empty($crit)){}else{$stmt->bindParam(':id',$param,PDO::PARAM_STR);}
		$stmt->bindColumn($column,$result);
		$stmt->execute();
		$numRow = $stmt->rowCount();
		if($numRow > 0){
			while($stmt->fetch()){
    if(is_null($result) && !empty($null)){return 'not available';}else{return decode_data($result);}
   }// end of while
  }else{
   if(!empty($null)){return 'not available';}else{return false;}
  }
  closeconnect("stmt",$stmt);
  closeconnect("db",$conn);
}
//content data ends

//multiple content data starts
function multiple_content_data($table,$column,$param='',$crit='',$add = '',$type='non unique'){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
	@$conn = dbconnect('admin','PDO');
 if(empty($crit)){
  $where = "{$add}";
 }else{
  $where = "WHERE $crit = :id {$add}";
 }
 if($type === 'unique'){
  $sql = "SELECT DISTINCT $column FROM $table $where";
 }else{
  $sql = "SELECT $column FROM $table $where";
 }
	$stmt = $conn->prepare($sql);
 if(!empty($param) && !empty($crit)){ $stmt->bindParam(':id',$param,PDO::PARAM_STR); }
	$stmt->bindColumn($column,$result);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow > 0){
		while($stmt->fetch()){$data[] = decode_data($result);}// end of while
		if($type === 'unique'){return array_unique($data);}else{return $data;}
  }else{
   return false;
  }
  closeconnect('stmt',$stmt);
  closeconnect('db', $dbconn);
}
//multiple content data ends

//multiple cart data starts
function available_cart_data($token){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
 @$conn = dbconnect('admin','PDO');
 $sql = "SELECT or_id FROM order_table,seller_table WHERE or_token = :token AND or_status = 'cart' AND order_table.s_id = seller_table.s_id AND seller_table.s_status = 'active'";
	$stmt = $conn->prepare($sql);
 $stmt->bindParam(':token',$token,PDO::PARAM_STR);
	$stmt->bindColumn('or_id',$result);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow < 1){
  return false;
 }else{  
		while($stmt->fetch()){$data[] = decode_data($result);}// end of while
  $or_id_array = [];
  foreach($data AS $key=>$or_id){ // remove the unavailable product price
   $p_id = content_data('order_table','p_id',$or_id,'or_id');
   $status = content_data('product_table','p_status',$p_id,'p_id');
   $or_color = content_data('order_table','or_color',$or_id,'or_id');
   if(is_avail($p_id)){$or_id_array[] = $or_id;}
  }
  //calculate the total price  of the available product
  $total = count($or_id_array);
  if($total > 0){return $or_id_array;}else{return false;}
 }
  closeconnect('stmt',$stmt);
  closeconnect('db', $dbconn);
}
//multiple cart data ends

//unavailable cart data starts (to get the number of unavailable product in the cart)
function unavailable_cart_data($token){
	// creating connection
	require_once(file_location('inc_path','connection.inc.php'));
 @$conn = dbconnect('admin','PDO');
 $sql = "SELECT or_id FROM order_table WHERE or_token = :token AND or_status = 'cart'";
	$stmt = $conn->prepare($sql);
 $stmt->bindParam(':token',$token,PDO::PARAM_STR);
	$stmt->bindColumn('or_id',$result);
	$stmt->execute();
	$numRow = $stmt->rowCount();
	if($numRow < 1){
  return false;
 }else{  
		while($stmt->fetch()){$data[] = decode_data($result);}// end of while
  $or_id_array = [];
  foreach($data AS $key=>$or_id){ // remove the available product price
   $p_id = content_data('order_table','p_id',$or_id,'or_id');
   $status = content_data('product_table','p_status',$p_id,'p_id');
   $or_color = content_data('order_table','or_color',$or_id,'or_id');
   if(is_avail($p_id) === false){$or_id_array[] = $or_id;}
  }
  //calculate the total number of the unavailable product
  $total = count($or_id_array);
  if($total > 0){return $or_id_array;}else{return false;}
 }
  closeconnect('stmt',$stmt);
  closeconnect('db', $dbconn);
}
//unavailable cart data ends
//GET DATABASE FUNCTION ENDS
?>