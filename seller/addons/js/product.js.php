<?php //PRODUCT JS STARTS ?>
<?php if(php_self('/product/index.php','seller')){ ?>
<?php //get product result ?>
gpr('<?=$status?>',<?=$page_num?>);function gpr(st,pg){$.ajax({type:'POST',url:sdar+'get/gpr/',data:{"s":$('#sx').val(),"st":st,"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/product/insert_product.enc.php','seller')){ ?>
<?php //insert product (IMAGE)?>
$(document).ready(function(){
$('#insfd').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Uploading Product');
$.ajax({type:'POST',url:sdar+"act/ip/",data:new FormData(this),cache:false,contentType:false,processData:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while adding product'));r_b('Upload Product');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{r_b('Upload Product');if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{$('#st').html(r_m2(s.message));}}})
})
})
<?php } ?>
<?php if(php_self('/product/update_product.enc.php','seller')){ ?>
<?php //update product?>
$(document).ready(function(){
$('#upsfd').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating Product');
$.ajax({type:'POST',url:sdar+"act/up/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){r_b('Update Product');$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating product,try again'));})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{r_b('Update Product');if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));}}})
})
})
<?php } ?>