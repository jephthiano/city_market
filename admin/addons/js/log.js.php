<?php //LOG JS STARTS ?>
<?php if(php_self('/log/admin_log.enc.php','admin')){ ?>
<?php //get log result ?>
galr(<?=$page_num?>);function galr(pg){$.ajax({type:'POST',url:adar+'get/log/galr/',data:{"s":$('#sx').val(),'pg':pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/log/seller_log.enc.php','admin')){ ?>
<?php //get seller log result ?>
gslr(<?=$page_num?>);function gslr(pg){$.ajax({type:'POST',url:adar+'get/log/gslr/',data:{"s":$('#sx').val(),'pg':pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>