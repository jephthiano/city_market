<?php
trait notification{
    protected $noti_table = 'user_notification_table';
    protected $noti_table2 = 'seller_notification_table';
    protected $noti_table3 = 'seller_last_general_message_check_table';
    
    public $n_id;
    public $n_title;
    public $n_message;
    public $n_status;
    public $n_regdatetime;
    public $or_id;
    public $u_id;
    
    private $current_user;
    private $last_id;
    
    public function __construct($conn = ''){
        if(!empty($conn)){
            //CREATE CONNECTION
            require_once(file_location('inc_path','connection.inc.php'));
            $this->dbconn = dbconnect($conn,'PDO');
        }
        require_once(file_location('inc_path','class_all_session.inc.php'));
        $this->current_admin = all_session('admin');
        $this->current_seller = all_session('seller');
        $this->current_user = all_session('user');
    }
    
    public function __destruct(){
    	//CLOSES ALL CONNECTION
        if(is_resource($this->dbconn)){
            closeconnect('db', $this->dbconn);
        }
        if(is_resource($this->dbstmt)){
            closeconnect('stmt',$this->dbstmt);
        }
    }
    
    public function insert_user_notification($type='multi'){
        if(content_data($this->noti_table,'n_title',$this->u_id,'u_id',"AND or_id = {$this->or_id} AND n_title = '{$this->n_title}'") === false){
            $this->dbsql = "INSERT INTO {$this->noti_table}(n_title,n_message,or_id,u_id) VALUES(:title,:message,:or_id,:id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':title',$this->n_title,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':message',$this->n_message,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':id',$this->u_id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            if($type === 'single'){
                $this->dbnumRow = $this->dbstmt->rowCount();
                if($this->dbnumRow > 0){return true;}else{return false;} 
            }
        }
    }//end insert user
    
    public function change_user_noti_status($type = 'change_seen'){
        if($type === 'change_read'){
            $this->dbsql = "UPDATE {$this->noti_table} SET n_status = 'read' WHERE or_id = :or_id AND u_id = :id ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
        }else{
            $this->dbsql = "UPDATE {$this->noti_table} SET n_status = 'seen' WHERE u_id = :id AND n_status = 'sent'";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }
        $this->dbstmt->bindParam(':id',$this->current_user,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }
    
    public function change_seller_noti_status($type = 'change_seen'){
        if($type === 'change_read'){
            $this->dbsql = "UPDATE {$this->noti_table2} SET sn_status = 'read' WHERE sn_group = :group AND s_id = :id ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':group',$this->group,PDO::PARAM_STR);
        }else{
            $this->dbsql = "UPDATE {$this->noti_table2} SET sn_status = 'seen' WHERE s_id = :id AND sn_status = 'sent'";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }
        $this->dbstmt->bindParam(':id',$this->current_seller,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }
    
    public function update_last_check(){
        if(content_data($this->noti_table3,'sl_id',$this->current_seller,'s_id')){//if it seller is not in the db (update) else insert
            $sta = content_data($this->noti_table3,'sl_status',$this->current_seller,'s_id');
            if($sta === 'no'){$status = 'yes';}else{$status = 'no';}
            $this->dbsql = "UPDATE {$this->noti_table3} SET sl_status = '{$status}' WHERE s_id = :id LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }else{
            $this->dbsql = "INSERT INTO {$this->noti_table3}(s_id) VALUES(:id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        }
        $this->dbstmt->bindParam(':id',$this->current_seller,PDO::PARAM_INT);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }
}
?>