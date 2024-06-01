<?php //CATEGORY JS STARTS ?>
<?php if(php_self('/category/index.php','admin')){ ?>
<?php //get category result ?>
gcr(<?=$page_num?>);function gcr(pg){$.ajax({type:'POST',url:adar+'get/gcr/',data:{"s":$('#sx').val(),"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/category/subcategory.enc.php','admin')){ ?>
<?php //get category result ?>
gscr(<?=$page_num?>);function gscr(pg){$.ajax({type:'POST',url:adar+'get/gscr/',data:{"s":$('#sx').val(),"pg":pg}}).fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while fetching data...'));}).done(function(s){$('#shr').html(s);});alertoff();}
<?php } ?>
<?php if(php_self('/category/insert_category.enc.php','admin')){ ?>
<?php //insert category (IMAGE)?>

<?php } ?>
<?php if(php_self('/category/insert_subcategory.enc.php','admin')){ ?>
<?php //insert sub category (IMAGE)?>
$(document).ready(function(){
$('#insscg').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Adding Sub Category');
$.ajax({type:'POST',url:adar+"act/isc/",data:new FormData(this),cache:false,contentType:false,processData:false,dataType:'JSON'})
.fail(function(e,f,g){$('#st').html(r_m2('Sorry!!!<br>Error occurred while adding category'));r_b('Insert Sub Category');})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{r_b('Insert Sub Category');if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else{$('#st').html(r_m2(s.message));}}})
})
})
<?php } ?>
<?php if(php_self('/category/update_category.enc.php','admin')){ ?>
<?php //update category?>
$(document).ready(function(){
$('#upscg').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating Category');
$.ajax({type:'POST',url:adar+"act/uc/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){r_b('Update Category');$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating category,try again'));})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{r_b('Update Category');if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));}}})
})
})
<?php } ?>
<?php if(php_self('/category/update_subcategory.enc.php','admin')){ ?>
<?php //update category?>
$(document).ready(function(){
$('#upsscg').on('submit',function(event){event.preventDefault();$('.mg').html('*');loading('Updating Sub Category');
$.ajax({type:'POST',url:adar+"act/usc/",data:$(this).serialize(),cache:false,dataType:'JSON'})
.fail(function(e,f,g){r_b('Update Sub Category');$('#st').html(r_m2('Sorry!!!<br>Error occurred while updating sub category,try again'));})
.done(function(s){if(s.status === 'success'){window.location=s.message;}else{r_b('Update Sub Category');if(s.status === 'error'){for(let x in s.errors){$('#'+x).html(s.errors[x]);}}else if(s.status === 'fail'){$('#st').html(r_m2(s.message));}}})
})
})
<?php } ?>