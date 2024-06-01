<?php //PRODUCT JS STARTS ?>
<?php if(php_self('/product/index.php','admin')){ ?>
<?php //get product result ?>
gpr('<?=$status?>',<?=$page_num?>);function gpr(st,pg){$.ajax({type:'POST',url:adar+'get/gpr/',data:{"s":$('#sx').val(),"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>