<?php
//NOTIFICATION FUNCTION STARTS
//notification homme starts
function notification_home($group){
 global $slid;
 ?>
 <a href='<?=file_location('seller_url',"inbox/message/{$group}/")?>'>
 <div class='j-padding'>
  <div class='j-row j-border-color7 j-border-2 j-round-large'>
   <div class='j-padding'>
   <div>
    <span class='j-bolder'>New <?=ucwords($group)?> Message</span>
    <?php
    if($group === 'general'){
     $add = "AND s_id IS NULL ORDER BY sn_id DESC";
    }else{
     $add = "AND s_id = $slid ORDER BY sn_id DESC";
    }
    ?>
    <span class='j-bolder j-right j-text-color5'><?=show_date(content_data('seller_notification_table','sn_regdatetime',$group,'sn_group',$add))?></span>
   </div>
   <div>
    <span><?=text_length(ucfirst(content_data('seller_notification_table','sn_message',$group,'sn_group',$add,'null')),70)?></span>
    <?php
    if($group === 'general'){ //get unread based on last message check of seller
     $unread = get_numrow('seller_notification_table,seller_last_general_message_check_table','sn_group','general',"return",'round',"AND TIME_TO_SEC(TIMEDIFF(sl_regdatetime,sn_regdatetime)) < 0");
    }else{
     $unread = get_numrow('seller_notification_table','s_id',$slid,"return",'round',"AND sn_group = '{$group}' AND sn_status != 'read'");
    }    
    if($unread > 0){?><span class='j-circle j-color1 j-right' style='padding:6px 12px;'><?=$unread?></span><?php }
    ?>
    <span class='j-clearfix'></span>
    </div>
  </div>
 </div>
 </div>
 </a>
 <?php
}
//notification home ends


//NOTIFICATION FUNCTION ENDS
?>