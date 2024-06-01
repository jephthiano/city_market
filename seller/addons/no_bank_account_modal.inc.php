<?php
if(content_data('seller_account_table','sa_id',$slid,'s_id') === false){
    if(php_self('/account/index.php','seller')){
        $home_page = 'account';
        $color = 'j-color6';
    }elseif(php_self('/index.php','seller')){
        $home_page = 'home';
        $color = 'j-color4';
    }
    ?>
    <div class='j-padding' id='no_account_modal'>
        <div class='<?=$color?> j-padding-large j-round j-display-container j-large'>
            <span class="j-button j-display-topright j-large j-text-color1 <?=icon('times')?>"onclick="$('#no_account_modal').fadeOut('slow');"></span>
            You haven't upload your bank account details, please
            <?php
            if($home_page === 'account'){
                ?><span class='j-bolder j-clickable j-text-color1'onclick="$('#bank_account_modal').fadeIn('slow');">click here</span><?php
            }elseif($home_page === 'home'){
                ?><a href="<?=file_location('seller_url','account/')?>" class='j-bolder j-clickable j-text-color1'>click here</a><?php
            }
            ?>
            to do so.
        </div>
    </div>
<?php
}
?>