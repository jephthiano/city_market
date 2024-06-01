<?php
class wishlist{
    private $table = 'wishlist_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $p_id;
    
    private $current_user = 1;
    
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
    
    public function run_request(){
        if(check_wishlist_content($this->p_id) === false){
            $this->dbsql = "INSERT INTO {$this->table}(u_id,p_id)VALUES(:user_id,:p_id)";
        }else{
            $this->dbsql = "DELETE FROM {$this->table} WHERE u_id = :user_id AND p_id = :p_id LIMIT 1";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':p_id',$this->p_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':user_id',$this->current_user,PDO::PARAM_INT);
            $this->dbstmt->execute();
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
    }//end of run_request
}
?>