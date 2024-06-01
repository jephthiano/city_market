<?php
if(isset($_GET['d']) && isset($_GET['i'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
	$data = test_input(($_GET['d']));
    $product_id = test_input(($_GET['i']));
    $p_category = content_data('product_table','p_category',$product_id,'p_id');
    if($p_category === $data){ //if the current product category is the same as the selected category
        $sub_category_id = content_data('product_table','p_sub_category',$product_id,'p_id');
    }else{
        $sub_category_id = '';
    }
    get_subcategory($data,$sub_category_id);
}
?>