<?php
if(isset($_GET['t'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    require_once(file_location('inc_path','session_check_nologout.inc.php'));
    $token = get_order_token();
    $ty = test_input($_GET['t']);
    $total_amount = item_sum($token);
    $total_delivery_fee = item_sum($token,'delivery');
    //CHANGE THE DELIVERY FEE
    ?>
    <div class=''style='width:100%'>
        <span class='j-text-color7'style='margin-right:50px;'>Items total:</span>
        <span class='j-bolder j-text-color5 j-right'>
            <?=get_json_data('currency_symbol','about_us').' '.money($total_amount);?>
        </span>
    </div>
    <div class=''style='width:100%'>
        <span class='j-text-color7'style='margin-right:50px;'><?=$ty==='pickup'?'Pickup':'Delivery';?> fee:</span>
        <span class='j-bolder j-text-color7 j-right'>
            <?=get_json_data('currency_symbol','about_us').' '.money($total_delivery_fee)?>
        </span>
    </div>
    <div class=''style='width:100%;margin:15px 0px;'>
        <span class=''style='margin-right:50px;'>Total:</span>
        <span id=''class='j-bolder j-text-color1 j-right'>
            <?=get_json_data('currency_symbol','about_us').' '.money(add_total($total_amount,$total_delivery_fee))?>
        </span>
    </div>
    <?php
}
?>