<?php
//FOGROT PASSWORD FUNCTION STARTS

//generate code starts
function generate_code(){return rand(100000,999999);}
//generate code ends

//set user token starts
function set_user_forgot_password_token($email,$code=''){
 $en_email = ssl_encrypt_input($email);
 $en_code = ssl_encrypt_input($code);
 $cookie_data = $en_email.":".$en_code;
 $expiretime = time()+(300);
 setcookie("_ftpsw",$cookie_data,$expiretime,"/","",true,true);
}
//set user token ends

//get user token starts
function get_user_forgot_password_token($type='email'){
 if(isset($_COOKIE['_ftpsw'])){
  $cookie = $_COOKIE['_ftpsw'];
  if(!empty($cookie)){
   list($de_email,$de_code) = explode(':',$cookie);
   if($type === 'email'){
    return test_input(ssl_decrypt_input($de_email));
   }elseif($type === 'code'){
    return test_input(ssl_decrypt_input($de_code));
   }else{
    return false;
   }
  }else{
   return false;
  }
 }else{
  return false;
  }
 }
//get user token ends

//delete user token starts
function delete_user_forgot_password_token(){if(isset($_COOKIE['_ftpsw'])){setcookie("_ftpsw","",time()-3600,"/","",true,true);}}
//delete token ends

//insert and delete user code starts
function insert_delete_user_code($type,$email,$code = ''){
 $emailcode = new emailcode('admin');
 $emailcode->type = $type;
 $emailcode->email = $email;
 $emailcode->code = $code;
 return $emailcode->run_user_request();
}
//insert and delete user code ends


//set seller token starts
function set_seller_forgot_password_token($email,$code=''){
 $en_email = ssl_encrypt_input($email);
 $en_code = ssl_encrypt_input($code);
 $cookie_data = $en_email.":".$en_code;
 $expiretime = time()+(300);
 setcookie("_sltwtfd",$cookie_data,$expiretime,"/","",true,true);
}
//set seller token ends

//get seller token starts
function get_seller_forgot_password_token($type='email'){
 if(isset($_COOKIE['_sltwtfd'])){
  $cookie = $_COOKIE['_sltwtfd'];
  if(!empty($cookie)){
   list($de_email,$de_code) = explode(':',$cookie);
   if($type === 'email'){
    return test_input(ssl_decrypt_input($de_email));
   }elseif($type === 'code'){
    return test_input(ssl_decrypt_input($de_code));
   }else{
    return false;
   }
  }else{
   return false;
  }
 }else{
  return false;
  }
 }
//get seller token ends

//delete seller token starts
function delete_seller_forgot_password_token(){if(isset($_COOKIE['_sltwtfd'])){setcookie("_sltwtfd","",time()-3600,"/","",true,true);}}
//delete token ends

//insert and delete seller code starts
function insert_delete_seller_code($type,$email,$code = ''){
 $emailcode = new emailcode('admin');
 $emailcode->type = $type;
 $emailcode->email = $email;
 $emailcode->code = $code;
 return $emailcode->run_seller_request();
}
//insert and delete seller code ends

//FORGOT PASSWORD FUNCTION ENDS
?>