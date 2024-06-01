<?php
if(isset($_GET['t'])){
    require_once($_SERVER['DOCUMENT_ROOT'].'/addons/function.inc.php');// all functions
    require_once(file_location('seller_inc_path','session_check_nologout.inc.php'));
    $ty = test_input($_GET['t']);
    if($ty === 'noti'){
        $numrow = distinct_numrow('seller_notification_table','sn_group','s_id',$slid,"return",'no round',"AND sn_group != 'general' AND sn_status = 'sent'");
        if(content_data('seller_notification_table,seller_last_general_message_check_table','sn_id','general','sn_group',"AND TIME_TO_SEC(TIMEDIFF(sl_regdatetime,sn_regdatetime)) < 0")){ //if there is unread general message base on last check and date of message add 1 to counter 
            $numrow = ($numrow + 1);
        }
        echo $numrow > 9? "9+" : $numrow;
    }
}
?>