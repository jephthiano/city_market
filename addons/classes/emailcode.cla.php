<?php
class emailcode{
    private $table = 'user_emailcode_table';
    private $table2 = 'seller_emailcode_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $code;
    public $email;
    public $regdatetime;
    public $type;
    
    public function __construct($conn = ''){
        if(!empty($conn)){
            //CREATE CONNECTION
            require_once(file_location('inc_path','connection.inc.php'));
            $this->dbconn = dbconnect($conn,'PDO');
        }
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
    
    
    public function run_user_request(){
        if($this->type === 'insert' && content_data($this->table,'c_email',$this->email,'c_email') === false){
            $this->dbsql = "INSERT INTO {$this->table}(c_code,c_email) VALUES(:code,:email)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'update'){
            $this->dbsql = "UPDATE {$this->table} SET c_verify = 'yes' WHERE c_code = :code AND c_email = :email";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'delete'){
            delete_user_forgot_password_token();
            $this->dbsql = "DELETE FROM {$this->table} WHERE c_email = :email LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }
    }//end of run request
    
    public function run_seller_request(){
        if($this->type === 'insert' && content_data($this->table2,'c_email',$this->email,'c_email') === false){
            $this->dbsql = "INSERT INTO {$this->table2}(c_code,c_email) VALUES(:code,:email)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'update'){
            $this->dbsql = "UPDATE {$this->table2} SET c_verify = 'yes' WHERE c_code = :code AND c_email = :email";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':code',$this->code,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }elseif($this->type === 'delete'){
            delete_user_forgot_password_token();
            $this->dbsql = "DELETE FROM {$this->table2} WHERE c_email = :email LIMIT 1";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':email',$this->email,PDO::PARAM_STR);
            if($this->dbstmt->execute()){return true;}else{return false;}
        }
    }//end of run request
}
?>