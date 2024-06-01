
<div class='j-color4 j-bolder j-hide-small j-hide-medium j-padding-flexible j-medium'style='margin-top:8px;'>
    <div style='line-height:40px;'>
        <a href="<?=file_location('seller_url','account/')?>"><div class='<?=php_self('/account/index.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>My Account</div></a>
        <a href="<?=file_location('seller_url','account/earning/')?>"><div class='<?=php_self('/account/earning.enc.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Earning</div></a>
        <a href="<?=file_location('seller_url','inbox/')?>"><div class='<?=php_self('/inbox/index.php','seller') || php_self('/inbox/message.enc.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Inbox</div></a>
        <a href="<?=file_location('seller_url','product/')?>"><div class='<?=php_self('/product/index.php','seller') || php_self('/product/insert_product.enc.php','seller') || php_self('/product/preview_product.enc.php','seller') || php_self('/product/update_product.enc.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Products</div></a>
        <a href="<?=file_location('seller_url','order/'.rawurlencode('order placed').'/')?>"><div class='<?=php_self('/order/index.php','seller') || php_self('/order/order_details.enc.php','seller') || php_self('/order/track.enc.php','seller') || php_self('/return/index.php','seller') || php_self('/return/track.enc.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Orders</div></a>
        <a href="<?=file_location('seller_url','account/change_password/')?>"><div class='<?=php_self('/account/change_password.enc.php','seller')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Change Password</div></a>
    </div>
    <hr>
    <center>
        <div class='j-btn j-color1 j-center j-margin j-round'style='display:block'onclick="$('#log_out_modal').fadeIn('slow');">Logout</div>
        <?php
        $delete_exists = content_data('seller_request_table','sr_id',$slid,'s_id',"AND sr_type = 'delete account' AND sr_mode IN ('pending','ongoing')");
        if(php_self('/account/index.php','seller')){
            if($delete_exists === false){
                ?>
                <div class='j-btn j-color1  j-center j-margin j-round'style='display:block'onclick="$('#delete_account_modal').fadeIn('slow');">
                    Delete Account
                </div>
                <?php
            }else{
                ?>
                <div class='j-btn j-color1  j-center j-margin j-round'style='display:block'onclick="$('#request_pending').fadeIn('slow');">
                    Account Removal Pending
                </div>
                <?php
            }
        }
        ?>
    </center>
    <br>
</div>