<?php
//COLOR FUNCTION STARTS
//function get color starts (color in product details)
function get_color($id,$type){
 $color = decode_data(strtolower(content_data('product_table','p_color',$id,'p_id')));
 $data = str_replace('=',':',$color);
 if(is_json($data)){
  $color_array = json_decode($data,true);
  $color_key = array_keys($color_array);
  foreach($color_array as $key=>$val){
   if(get_color_first_key($id) === $key){$border = 'red 2px solid';}else{$border = 'gray 2px dotted';} //for border color
   ?>
   <button type='button'id='clbtn<?=$key?>'class="clbtn j-small j-btn j-color4 j-round-large"onclick="sccd(<?=$id?>,'<?=$key?>',<?=$val?>,'<?=$type?>')"
   style='margin-right:5px;padding-top:0px;padding-bottom:0px;border:<?=$border?>'>
   <?=ucwords($key)?>
   </button>
   <?php
  }
 }else{
  return "N/A";
 }
}
//function get color ends

//function get color key starts (to get the color data of a product)
function get_color_keys($id){
 $color = strtolower(decode_data(content_data('product_table','p_color',$id,'p_id')));
 $data = str_replace('=',':',$color);
 if(is_json($data)){
  $color_array = json_decode($data,true);
  $keys = '';
  foreach($color_array as $key=>$array){$keys .= ucwords($key).', ';}
  return $keys;
 }else{
  return "N/A";
 }
}

//function get color first key starts (to get the first color key from coookie, then from cart and from first color)
function get_color_first_key($id){
 //for cookie
 $color_cookie = '';
 if(get_color_token('id') !== 'no_saved_color' || get_color_token('color') !== 'no_saved_color'){
  if(get_color_token('id') === $id){
   $cookie_id = get_color_token('id'); $cookie_color = strtolower(get_color_token('color')); $color_cookie = 'set';
  }
 }
 // for cart
 $token = get_order_token();
 $or_color = strtolower(decode_data(content_data('order_table','or_color',$token,'or_token',"AND p_id = $id AND or_status = 'cart'")));
 
 if($color_cookie === 'set'){ // for cookie
  return strtolower($cookie_color);
 }elseif($or_color != false){ //for cart
  return strtolower($or_color);
 }else{ // get the first color then
  $color = strtolower(decode_data(content_data('product_table','p_color',$id,'p_id')));
  $data = str_replace('=',':',$color);
  if(is_json($data)){
   $color_array = json_decode($data,true);
   $color_key = array_keys($color_array);
   $total = count($color_key);
   for($i=0;$i<$total;$i++){
    $val = 0;
    if(get_color_value($id,$color_key[$i]) < 1){continue;}
    if(get_color_value($id,$color_key[$i]) > 0){$val = $i;break;}
   }
   return strtolower($color_key[$val]);
  }else{
   return "N/A";
  }
 }
}
//function get color first key ends

//get color key and value starts (get the vlaue of the color key)
function get_color_value($id,$key){
 $color = strtolower(decode_data(content_data('product_table','p_color',$id,'p_id')));
 $data = str_replace('=',':',$color);
 if(is_json($data)){
  $color_array = json_decode($data,true);
  if(in_array($color_array[$key],$color_array)){
   return $color_array[$key];
  }else{
   return 0;
  }
 }else{
  return 0;
 }
}
//get color key and value ends

//function get total available starts
function get_total_available($id){
 $color = strtolower(decode_data(content_data('product_table','p_color',$id,'p_id')));
 $data = str_replace('=',':',$color);
 if(is_json($data)){
  $color_array = json_decode($data,true);
  $color_values = array_values($color_array);
  return array_sum($color_values);
 }else{
  return "N/A";
 }
}
//function get total available ends

//function color color starts starts
function confirm_color_data($id,$key,$value){
 $color = strtolower(decode_data(content_data('product_table','p_color',$id,'p_id')));
 $data = str_replace('=',':',$color);
 if(is_json($data)){
  $array = json_decode($data,true);
  if(key_exists($key,$array)){
   $array[$key] = $value;
   return json_encode($array);
  }else{
   return false;
  }
 }else{
  return "N/A";
 }
}
//function color color starts ends

//set color token starts
function set_color_token($id,$color){
 $c_id = ssl_encrypt_input(addnum($id));
 $c_color = ssl_encrypt_input($color);
 $data = $c_id.":".$c_color;
 $cookie_data = ssl_encrypt_input($data);
 setcookie("_hsaewt",$cookie_data,0,"/","",true,true);
}
//set color token ends

//get color token starts
function get_color_token($type='id'){
 if(isset($_COOKIE['_hsaewt'])){
  $cookie = ssl_decrypt_input($_COOKIE['_hsaewt']);
  if($cookie !== ""){
		list($c_id,$c_color) = explode(':',$cookie);
  if($type === 'id'){
   return removenum(ssl_decrypt_input($c_id));
  }elseif($type === 'color'){
   return ssl_decrypt_input($c_color);
  }else{
   return 'no_saved_color';
  }
  }
 }else{
  return 'no_saved_color';
 }
}
//get color token ends

//delete color token starts
function delete_color_token(){if(isset($_COOKIE['_hsaewt'])){setcookie("_hsaewt","",time()-3600,"/","",true,true);}}
//delete color token ends
//COLOR FUNCTION ENDS
?>