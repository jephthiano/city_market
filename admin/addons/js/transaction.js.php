<?php //TRANSACTION JS STARTS ?>
<?php if(php_self('/transaction/all.enc.php','admin')){ ?>
<?php //get all transaction result ?>
gtr('<?=$status?>',<?=$page_num?>);function gtr(st,pg){$.ajax({type:'POST',url:adar+'get/transaction/gtr/',data:{"s":$('#sx').val(),"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/transaction/annual.enc.php','admin')){ ?>
<?php //get annual transaction result ?>
gatr('<?=$status?>',<?=$page_num?>);function gatr(st,pg){$.ajax({type:'POST',url:adar+'get/transaction/gatr/',data:{"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/transaction/monthly.enc.php','admin')){ ?>
<?php //get monthly transaction result ?>
gmtr('<?=$status?>',<?=$page_num?>);function gmtr(st,pg){$.ajax({type:'POST',url:adar+'get/transaction/gmtr/',data:{"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/transaction/daily.enc.php','admin')){ ?>
<?php //get daily transaction result ?>
gdtr('<?=$status?>',<?=$page_num?>);function gdtr(st,pg){$.ajax({type:'POST',url:adar+'get/transaction/gdtr/',data:{"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>