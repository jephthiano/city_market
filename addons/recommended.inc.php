<div id='recommended'class='j-home-padding'style='margin:0px;margin-bottom:9px;'></div>
<?php
$total = get_numrow('product_table','p_status','available',"return",'no round');
if(php_self('/category/product.enc.php','home')){
    $reco_type = 'products'; $reco_id = $val;
}elseif(php_self('/product/index.php','home')){
    $reco_type = 'product_details'; $reco_id = $id;
}elseif(php_self('/store/index.php','home')){
    $reco_type = 'store'; $reco_id = $s_id;
}elseif(php_self('/brand/index.php','home')){
    $reco_type = 'brand'; $reco_id = $brand;
}else{
    $reco_type = 'others'; $reco_id = 'others';
}
$reco_data = 'run_request';
?>