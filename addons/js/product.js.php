<?php //PRODUCT JS STARTS ?>
<?php if(php_self('/product/index.php','home')){ ?>
<?php //set color cookie data?>
<?php //set color cookie data,get color data and reset,show the value in available,show selected color,get add to cart button?>
function sccd(i,k,v,p){
$.ajax({type:'GET',url:dar+'act/sccd/'+i+'/'+k,cache:false})
.done(function(s){var key=k.toUpperCase();$('#colorName'+i).html(key);gcd(i,p);$('#p_avail').html(v);gacb(i,p,key);})
}
<?php // get color data?>
function gcd(i,p){$.ajax({type:'GET',url:dar+'get/gcd/'+i+'/'+p,cache:false}).done(function(s){$("#colDiv"+i).html(s);})}
<?php } ?>