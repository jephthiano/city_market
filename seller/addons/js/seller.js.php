<?php //SELLER JS STARTS ?>
<?php //logout?>
function lg(){loading('Loggin out','id','lobtn');
$.ajax({type:'POST',url:sdar+'act/lg/',cache:false,dataType:'JSON'}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while logging out'));r_b('Log Out','id','lobtn');})
.done(function(s){if(!s.status){$('#st').html(r_m(s.message));r_b('Log Out','id','lobtn');}else{window.location=s.message;}})
alertoff();
}
<?php if(php_self('/login.enc.php','seller')){ ?>
<?php //login ?>
$(document).ready(function(){
$('#lgform').on('submit',function(event){event.preventDefault();$('#error').html('');loading('Logging In');
$.ajax({type:'POST',url:sdar+"act/l/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while logging in,try again'));r_b('Log In As Admin');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{$('#st').html(r_m2(s.errors));r_b('Log In As Admin')}});alertoff();
})
})
<?php } ?>
<?php if(php_self('/forgot_password.enc.php','seller')){ ?>
<?php if($type === 'enter_email'){ ?>
<?php //process email?>
$(document).ready(function(){
$('#eemfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('PROCESSING EMAIL','id','eembtn');
$.ajax({type:'POST',url:sdar+"act/pfpe/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while processing email, try again'));r_b('CONTINUE','id','eembtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('CONTINUE','id','eembtn');}});alertoff();
})
})
<?php } ?>
<?php if($type === 'enter_code'){ ?>
<?php //process code?>
$(document).ready(function(){
$('#ecdfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('PROCESSING CODE','id','ecdbtn');
$.ajax({type:'POST',url:sdar+"act/pfpc/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while processing code, try again'));r_b('CONTINUE','id','ecdbtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('CONTINUE','id','ecdbtn');}});alertoff();
})
})
<?php } ?>
<?php if($type === 'enter_password'){ ?>
<?php //process password?>
$(document).ready(function(){
$('#epsfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('RESETING PASSWORD','id','epsbtn');
$.ajax({type:'POST',url:sdar+"act/pfpp/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while resseting, try again'));r_b('SUBMIT','id','epsbtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));$('#psw').val('');};r_b('SUBMIT','id','epsbtn');}});alertoff();
})
})
<?php } ?>
<?php } ?>
<?php if(php_self('/account/change_password.enc.php','seller')){ ?>
<?php //change_password ?>
$(document).ready(function(){
$('#chspsfrm').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating Password');
$.ajax({type:'POST',url:sdar+"act/cp/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2(''));r_b('Change Password');})
.done(function(s){if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{$('#st').html(r_m2(s.message))};r_b('Change Password');});alertoff();
$('.pss').val('');
})
})
<?php } ?>
<?php if(php_self('/account/index.php','seller')){ ?>
<?php //Upload bank account detail?>
$(document).ready(function(){
$('#upbkdfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Uploading Data','id','bkatbtn');
$.ajax({type:'POST',url:sdar+"act/pfpp/",data:$(this).serialize(),cache:false,dataType:'JSON'})
$.ajax({type:'POST',url:sdar+"act/ibd/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while uploading data,try again'));r_b('Register Data','id','bkatbtn');
$.ajax({type:'POST',url:sdar+"act/pfpp/",data:$(this).serialize(),cache:false,dataType:'JSON'})})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Register Data','id','bkatbtn');
$.ajax({type:'POST',url:sdar+"act/pfpp/",data:$(this).serialize(),cache:false,dataType:'JSON'})}})
})
})
<?php //request for account update?>
$(document).ready(function(){
$('#upprofrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Submitting Details','id','upprobtn');
$.ajax({type:'POST',url:sdar+"act/islrq/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while sending request,try again'));r_b('Submit Details','id','upprobtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Submit Details','id','upprobtn');}})
})
})
<?php //request for account delete?>
$(document).ready(function(){
$('#dlacctfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Submitting Request','id','dlacctbtn');
$.ajax({type:'POST',url:sdar+"act/islrq/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while sending request,try again'));r_b('Submit Request','id','dlacctbtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Submit Request','id','dlacctbtn');}})
})
})
<?php } ?>