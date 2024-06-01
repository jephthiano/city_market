<?php //MESSAGE JS STARTS ?>
<?php if(php_self('/misc/contact_us.enc.php','home')){ ?>
<?php //insert message ?>
$(document).ready(function(){
$('#inmsfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Sending Message');
$.ajax({type:'POST',url:dar+"act/im/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while sending message,try again'));r_b('Send Message');})
.done(function(s){if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{if(s.status === 'success'){$('.ip').val('');}$('#st').html(r_m2(s.message));};r_b('Send Message');});alertoff();
})
})
<?php } ?>
<?php if(php_self('/misc/become_seller.enc.php','home')){ ?>
<?php //insert become seller data ?>
$(document).ready(function(){
$('#insbcselfrm').on('submit',function(event){event.preventDefault();$('.mg').html('');loading('Sending Message');
$.ajax({type:'POST',url:dar+"act/ibsd/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while sending message,try again'));r_b('Send Message');})
.done(function(s){if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{if(s.status === 'success'){$('.ip').val('');}$('#st').html(r_m2(s.message));};r_b('Send Message');});alertoff();
})
})
<?php } ?>