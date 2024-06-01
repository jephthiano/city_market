<div class='j-color4 j-bolder j-hide-small j-hide-medium j-padding-flexible j-medium'style='margin-top:8px;'>
    <div style='line-height:40px;'>
        <a href="<?=file_location('home_url','account/')?>"><div class='<?=php_self('/account/index.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>My Account</div></a>
        <a href="<?=file_location('home_url','account/edit_profile/')?>"><div class='<?=php_self('/account/edit_profile.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Edit Profile</div></a>
        <a href="<?=file_location('home_url','account/change_password/')?>"><div class='<?=php_self('/account/change_password.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Change Password</div></a>
        <a href="<?=file_location('home_url','order/'.rawurlencode('order placed').'/')?>"><div class='<?=php_self('/order/index.php','home') || php_self('/order/order_details.enc.php','home') || php_self('/order/track.enc.php','home') || php_self('/return/index.php','home') || php_self('/return/track.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Orders</div></a>
        <a href="<?=file_location('home_url','inbox/')?>"><div class='<?=php_self('/inbox/index.php','home') || php_self('/inbox/message.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Inbox</div></a>
        <a href="<?=file_location('home_url','account/wishlist/')?>"><div class='<?=php_self('/account/wishlist.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Wishlist</div></a>
        <a href="<?=file_location('home_url','account/contact/')?>"><div class='<?=php_self('/account/contact.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Contact Details</div></a>
        <a href="<?=file_location('home_url','account/viewed/')?>"><div class='<?=php_self('/account/viewed.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Viewed</div></a>
        <a href="<?=file_location('home_url','review/')?>"><div class='<?=php_self('/review/index.php','home') || php_self('/review/add_review.enc.php','home')?'j-color5':'j-color4'?> j-padding'style='width:100%;'>Pending Reviews</div></a>
    </div>
    <hr>
    <center>
        <div class='j-btn j-color1 j-center j-margin j-round'style='display:block'onclick="$('#log_out_modal').fadeIn('slow');">Logout</div>
        <div class='j-btn j-color1  j-center j-margin j-round'style='display:block'onclick="$('#delete_account_modal').fadeIn('slow');">Delete Account</div>
    </center>
    <br>
</div>
<?php  user_modal('user_delete_account');$log_delete = 'enabled'?>