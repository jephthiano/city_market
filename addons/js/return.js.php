<?php //RETURN JS STARTS ?>
<?php if(php_self('/return/index.php','home')){ ?>
<?php //request for return ?>
$(document).ready(function(){
$('#rfrfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Submiting Form');
$.ajax({type:'POST',url:dar+"act/rfr/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while submitting form, try again'));r_b('Submit Form');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{$('#st').html(r_m2(s.message));};;r_b('Submit Form');}})
})
})
<?php //enable submit button ?>
function esb(){
 let rr = $('#rr').val();let orr = $('#orr').val(); $('#rre').html('');
 if(rr===''){
  $('#dorr').fadeOut('slow');$('#rre').html('* select the reason you want to return the product');$('#sbtn').attr('disabled','disabled');
 }else if(rr==='other'){
 $('#dorr').fadeIn('slow');
  if($.trim(orr)===''){
   $('#rre').html('* input the reason for return in the textbox below');$('#sbtn').attr('disabled','disabled');
  }else{
   $('#sbtn').removeAttr('disabled');
  }
 }else{
  $('#dorr').fadeOut('slow');$('#sbtn').removeAttr('disabled');
 }
}
<?php } ?>