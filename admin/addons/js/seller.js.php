<?php //SELLER JS STARTS ?>
<?php if(php_self('/seller/index.php','admin')){ ?>
<?php //get social handle result ?>
gslr('<?=$status?>',<?=$page_num?>);function gslr(st,pg){$.ajax({type:'POST',url:adar+'get/gslr/',data:{"s":$('#sx').val(),"st":st,'pg':pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/seller/register_seller.enc.php','admin')){ ?>
<?php //reg seller ?>
$(document).ready(function(){
$('#insnsl').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Registering');
$.ajax({type:'POST',url:adar+"act/rsl/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while registering seller,try again'));r_b('Register New Seller');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Register New Seller');}})
})
})
<?php } ?>
<?php if(php_self('/seller/update_seller.enc.php','admin')){ ?>
<?php //update seller data ?>
$(document).ready(function(){
$('#upsld').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating','id','sdbtn');
$.ajax({type:'POST',url:adar+"act/usld/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating seller data,try again'));r_b('Update Seller Data','id','sdbtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Update Seller Data','id','sdbtn');}})
})
})
<?php //update seller contact data ?>
$(document).ready(function(){
$('#upslcd').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating');
$.ajax({type:'POST',url:adar+"act/uslcd/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating seller contact data,try again'));r_b('Update Seller Contact Data');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Update Seller Contact Data');}})
})
})
<?php //update seller account data ?>
$(document).ready(function(){
$('#upsbad').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating','id','sbabtn');
$.ajax({type:'POST',url:adar+"act/usbad/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating seller account data,try again'));r_b('Update Seller Bank Account Data','id','sbabtn');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));};r_b('Update Seller Bank Account Data','id','sbabtn');}})
})
})
<?php } ?>
<?php if(php_self('/request/request.enc.php','admin')){ ?>
<?php //get update seller result ?>
gslrqr('<?=$type?>','<?=$status?>',<?=$page_num?>);function gslrqr(ty,st,pg){$.ajax({type:'POST',url:adar+'get/gslrqr/',data:{"s":$('#sx').val(),"ty":ty,"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>