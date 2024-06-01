<?php
class log{
    private $table = 'admin_log_table';
    private $table2 = 'seller_log_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $brief;
    public $details;
    
    private $current_admin;
    private $current_username;
    
    private $current_seller;
    private $current_storename;
    
    private $current_user;
    private $current_email;
    
    private $current_ip;
    
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
        
        if(strstr($_SERVER['SERVER_NAME'],'admin.')){
            //username
            $this->current_username = content_data('admin_table','ad_username',$this->current_admin,'ad_id');
        }elseif(strstr($_SERVER['SERVER_NAME'],'seller.')){
            $this->current_storename = content_data('seller_table','s_storename',$this->current_seller,'s_id');//storename
        }else{
            
        }
        //ip address
        $this->current_ip = get_ip_address();
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
    
    
    public function insert_log($type='all'){
        if($type === 'logout'){
            $this->dbsql = "INSERT INTO {$this->table}(l_brief,l_details,l_ip_address,ad_id,ad_username)VALUES(:brief,:details,:current_ip,:current_admin,:current_username)";
        }else{
            $this->dbsql = "INSERT INTO {$this->table}(l_brief,l_details,l_ip_address,ad_id,ad_username)VALUES(:brief,:details,:current_ip,:current_admin,:current_username)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':brief',$this->brief,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':current_ip',$this->current_ip,PDO::PARAM_STR);
        if($type === 'logout'){
            $this->dbstmt->bindParam(':current_admin',$this->admin_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':current_username',$this->admin_username,PDO::PARAM_STR);
        }else{
            $this->dbstmt->bindParam(':current_admin',$this->current_admin,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':current_username',$this->current_username,PDO::PARAM_STR);
        }
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }//end insert category
    
    public function insert_seller_log($type='all'){
        if($type === 'logout'){
            $this->dbsql = "INSERT INTO {$this->table2}(sl_brief,sl_details,sl_ip_address,s_id,s_storename)VALUES(:brief,:details,:current_ip,:current_seller,:current_storename)";
        }else{
            $this->dbsql = "INSERT INTO {$this->table2}(sl_brief,sl_details,sl_ip_address,s_id,s_storename)VALUES(:brief,:details,:current_ip,:current_seller,:current_storename)";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':brief',$this->brief,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':details',$this->details,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':current_ip',$this->current_ip,PDO::PARAM_STR);
        if($type === 'logout'){
            $this->dbstmt->bindParam(':current_seller',$this->seller_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':current_storename',$this->seller_storename,PDO::PARAM_STR);
        }else{
            $this->dbstmt->bindParam(':current_seller',$this->current_seller,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':current_storename',$this->current_storename,PDO::PARAM_STR);
        }
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($this->dbnumRow > 0){return true;}else{return false;}
    }//end insert seller log
}
?>