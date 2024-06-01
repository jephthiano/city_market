<div id="firstcol"style='line-height:27px;background-color:rgba(0,0,10,0.8);overflow-y:scroll;'>
    <a href="<?= file_location('admin_url','');?>"class="j-bar-item"style='padding:0px;'>
    <img src="<?=file_location('media_url','home/admin_logo.png')?>"class=''alt="<?=get_xml_data('company_name')?> LOGO IMAGE"style="width:100%;height:60px;">
    </a>
    <div class="j-text-color4"style='padding:20px 15px;background-image:url(<?=file_location('media_url','home/admin_image.png')?>)'>
        <div class='j-row'>
            <div class='j-col s4 xl3'>
                <img class='j-circle'src='<?=file_location('media_url',get_media('admin',$adid))?>'style="height:40px;width:40px">
            </div>
            <div class='j-col s8 xl9'style='position: relative;top:5px;left:5px;'>
                <span class='j-bolder'><?=ucwords(content_data('admin_table','ad_fullname',$adid,'ad_id'))?> </span>
            </div>
        </div>
        <center><div class=''><b>(<?=ucwords(check_level(content_data('admin_table','ad_level',$adid,'ad_id')))?>)</b></div></center>
    </div>
    <div class=''>
        <div class='j-xlarge j-text-color4 j-padding'><b>Dashboard</b></div>
        <div class="j-small"style=''>
            <?php if($adlevel == 3){?>
                <a href="<?= file_location('admin_url','misc/run_action/');?>"class="">
                <div class='<?=php_self('/misc/run_action.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class="<?=icon('hourglass-start')?>"></i> </span> <span class='j-col s9'>Run Action</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','misc/settings/');?>"class="">
                <div class='<?=php_self('/misc/settings.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class="<?=icon('cog')?>"></i> </span> <span class='j-col s9'>Site Settings</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','misc/site_data/');?>"class="">
                <div class='<?=php_self('/misc/site_data.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class="<?=icon('address-card')?>"></i> </span> <span class='j-col s9'>Site Data</span></b>
                </div>
                </a>
                
            <?php }?>
            <a href="<?= file_location('admin_url','refund/pending_refund/');?>"class="">
                <div class='<?=php_self('/refund/index.php','admin') && isset($status) && $status === 'pending refund'?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <?php
                    $add="AND or_refund = 'no' AND or_status IN ('failed','cancelled','returned','failed delivery')";
                    $numrow = get_numrow('order_table','or_payment_received','yes',"return",'round',$add);if($numrow === false){$numrow = 0;}
                    ?>
                    <b><span class="j-large j-col s3"><i class="<?=icon('hourglass-start')?>"></i> </span> <span class='j-col s9'>Pending Refund (<?=$numrow?>)</span></b>
                </div>
            </a>
            <a href="<?= file_location('admin_url','return/request opened/');?>"class="">
                <div class='<?=php_self('/return/index.php','admin') && isset($status) && $status === 'request opened'?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <?php $numrow = get_numrow('return_table','rh_status','request opened',"return",'round');if($numrow === false){$numrow = 0;}?>
                    <b><span class="j-large j-col s3"><i class="<?=icon('handshake')?>"></i> </span> <span class='j-col s9'>Return Request (<?=$numrow?>)</span></b>
                </div>
            </a>
            <a href="<?= file_location('admin_url','request/request/update account/pending/');?>"class="">
                <div class='<?=(php_self('/request/request.enc.php','admin') && $type === 'update account') || (php_self('/request/preview_request.enc.php','admin') && $type === 'update account')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <?php $numrow = get_numrow('seller_request_table','sr_type','update account',"return",'round',"AND sr_mode = 'pending'");if($numrow === false){$numrow = 0;}?>
                    <b><span class="j-large j-col s3"><i class="<?=icon('edit')?>"></i> </span> <span class='j-col s9'>Update Profile Request (<?=$numrow?>)</span></b>
                </div>
            </a>
            <a href="<?= file_location('admin_url','request/request/delete account/pending/');?>"class="">
                <div class='<?=(php_self('/request/request.enc.php','admin') && $type === 'delete account') || (php_self('/request/preview_request.enc.php','admin') && $type === 'delete account')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <?php $numrow = get_numrow('seller_request_table','sr_type','delete account',"return",'round',"AND sr_mode = 'pending'");if($numrow === false){$numrow = 0;}?>
                    <b><span class="j-large j-col s3"><i class="<?=icon('trash')?>"></i> </span> <span class='j-col s9'>Delete Account Request (<?=$numrow?>)</span></b>
                </div>
            </a>
            <a href="<?= file_location('admin_url','request/request/become seller/pending/');?>"class="">
                <div class='<?=(php_self('/request/request.enc.php','admin') && $type === 'become seller') || (php_self('/request/preview_request.enc.php','admin') && $type === 'become seller')?'j-color4 j-text-color3':'j-text-color4'?> j-row j-padding'>
                    <?php $numrow = get_numrow('seller_request_table','sr_type','become seller',"return",'round',"AND sr_mode = 'pending'");if($numrow === false){$numrow = 0;}?>
                    <b><span class="j-large j-col s3"><i class="<?=icon('trash')?>"></i> </span> <span class='j-col s9'>Become Seller Request (<?=$numrow?>)</span></b>
                </div>
            </a>
            <?php if($adlevel == 3){?>
                <a href="<?= file_location('admin_url','admin/all/');?>"class="">
                <div class='
                    <?=php_self('/admin/index.php','admin') || php_self('/admin/preview_admin.enc.php','admin') || php_self('/admin/insert_admin.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                  <b><span class="j-large j-col s3"><i class='<?=icon('users')?>'></i> </span> <span class='j-col s9'> Admins</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','seller/all/');?>"class="">
                <div class='
                    <?=php_self('/seller/index.php','admin') || php_self('/seller/preview_seller.enc.php','admin') || php_self('/seller/register_seller.enc.php','admin') || php_self('/seller/update_seller.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                  <b><span class="j-large j-col s3"><i class='<?=icon('users')?>'></i> </span> <span class='j-col s9'> Sellers</span></b>
                </div>
                </a>
            <?php } ?>
            <?php if($adlevel > 1){ ?>
                <a href="<?= file_location('admin_url','social_handle/');?>"class="">
                <div class='
                    <?=php_self('/social_handle/index.php','admin') || php_self('/social_handle/preview_social_handle.enc.php','admin') || php_self('/social_handle/insert_social_handle.enc.php','admin') || php_self('/social_handle/update_social_handle.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('scribd','fab')?>'></i> </span> <span class='j-col s9'>Soc-Handles</span></b>
                </div>
                </a>
            <?php } ?>
                <a href="<?= file_location('admin_url','message/all/');?>"class="">
                <div class='
                    <?=php_self('/message/index.php','admin') || php_self('/message/preview_message.enc.php','admin') || php_self('/message/send_email.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?>
                    j-row j-padding'>
                    <b>
                        <span class="j-large j-col s3"><i class='<?=icon('envelope')?>'></i> </span>
                        <?php $numrowms = get_numrow('message_table','m_status','new',"return",'round');?>
                        <span class='j-col s9'>Messages (<?=$numrowms?>)</span>
                    </b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','category/');?>"class="">
                <div class='
                    <?=php_self('/category/index.php','admin') || php_self('/category/preview_category.enc.php','admin') || php_self('/category/insert_category.enc.php','admin') || php_self('/category/update_category.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('list-ul')?>'></i> </span> <span class='j-col s9'>Category</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','product/available/');?>"class="">
                <div class='
                    <?=php_self('/product/index.php','admin') || php_self('/product/preview_product.enc.php','admin') || php_self('/product/insert_product.enc.php','admin') || php_self('/product/update_product.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('hamburger')?>'></i> </span> <span class='j-col s9'>Products</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','user/all/');?>"class="">
                <div class='
                    <?=php_self('/user/index.php','admin') || php_self('/user/preview_user.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('users')?>'></i> </span> <span class='j-col s9'>Users</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','order/all/');?>"class="">
                <div class='
                    <?=php_self('/order/index.php','admin') || php_self('/order/preview_orders.enc.php','admin') || php_self('/order/preview_order.enc.php','admin') || php_self('/order/user_all_orders.enc.php','admin') || php_self('/order/print_order.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?>
                    j-row j-padding'>
                    <b>
                        <span class="j-large j-col s3"><i class='<?=icon('shopping-cart')?>'></i> </span>
                        <?php $numrow = get_numrow('order_table','or_status','order placed',"return",'round');if($numrow === false){$numrow = 0;}?>
                        <span class='j-col s9'>Orders (<?=$numrow?>)</span>
                    </b>
                </div>
                </a>
                <?php if($adlevel == 3){?>
                <a href="<?= file_location('admin_url','transaction/');?>"class="">
                <div class='
                    <?=php_self('/transaction/index.php','admin') || php_self('/transaction/preview_transaction.enc.php','admin') || php_self('/transaction/all.enc.php','admin') || php_self('/transaction/annual.enc.php','admin') || php_self('/transaction/monthly.enc.php','admin') || php_self('/transaction/daily.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('credit-card')?>'></i> </span> <span class='j-col s9'>Transactions</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','refund/refund/');?>"class="">
                <div class='
                    <?=(php_self('/refund/index.php','admin') && isset($status) && $status !== 'pending refund') || php_self('/refund/preview_refund.enc.php','admin') ?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('credit-card')?>'></i> </span> <span class='j-col s9'>Refunds</span></b>
                </div>
                </a>
                <?php } ?>
                <a href="<?= file_location('admin_url','request/');?>"class="">
                <div class='
                    <?=(php_self('/request/index.php','admin')) ?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('handshake')?>'></i> </span> <span class='j-col s9'>Request</span></b>
                </div>
                </a>
                <a href="<?= file_location('admin_url','return/all/');?>"class="">
                <div class='
                    <?=(php_self('/return/index.php','admin') && isset($status) && $status !== 'request opened') || php_self('/return/preview_return.enc.php','admin') ?'j-color4 j-text-color3':'j-text-color4'?> 
                    j-row j-padding'>
                    <b><span class="j-large j-col s3"><i class='<?=icon('handshake')?>'></i> </span> <span class='j-col s9'>Returns</span></b>
                </div>
                </a>
                <?php if($adlevel == 3){?>
                <a href="<?= file_location('admin_url','log/');?>"class="">
                <div class='
                    <?=php_self('/log/index.php','admin') || php_self('/log/admin_log.enc.php','admin') || php_self('/log/seller_log.enc.php','admin') || php_self('/log/preview_admin_log.enc.php','admin') || php_self('/log/preview_seller_log.enc.php','admin')?'j-color4 j-text-color3':'j-text-color4'?>
                    j-row j-padding'>
                    <b>
                        <span class="j-large j-col s3"><i class='<?=icon('file-alt')?>'></i> </span>
                        <span class='j-col s9'>Logs</span>
                    </b>
                </div>
                </a>
                <?php } ?>
        </div>
    </div>
</div>