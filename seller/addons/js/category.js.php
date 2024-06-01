<?php //CATEGORY JS STARTS ?>
<?php if(php_self('/product/insert_product.enc.php','seller') || php_self('/product/update_product.enc.php','seller')){ ?>
<?php //get sub category data?>
function gscd(d,i){$.ajax({type:'GET',url:sdar+'get/gscd/'+i+'/'+d}).done(function(s){$("#subct").html(s);})}
<?php } ?>