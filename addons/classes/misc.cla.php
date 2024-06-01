<?php
class misc{
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
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
    
    public function run_action(){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            //DELETE CART MORE THAN 60 DAYS(TWO MONTHS)
            $this->dbsql = "DELETE FROM order_table WHERE or_status = 'cart' AND DATEDIFF(NOW(),or_regdatetime) > 60";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->execute();
            // DELETE RECENT VIEW MORE THAN 30 days
            $this->dbsql = "DELETE FROM viewed_table WHERE DATEDIFF(NOW(),v_regdatetime) > 30 ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->execute();
            //DELETE EXPIRED USER SESSION DATA //GREATER THAN A YEAR
            $this->dbsql = "DELETE FROM cookie_data_table WHERE DATEDIFF(NOW(),cd_login_time) > 365 ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->execute();
            //DELETE EXPIRED USER EMAIL CODE
            $this->dbsql = "DELETE FROM user_emailcode_table WHERE c_verify = 'yes' OR TIME_TO_SEC(TIMEDIFF(NOW(),c_regdatetime)) > 300 ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->execute();
            //DELETE EXPIRED SELLER EMAIL CODE
            $this->dbsql = "DELETE FROM seller_emailcode_table WHERE c_verify = 'yes' OR TIME_TO_SEC(TIMEDIFF(NOW(),c_regdatetime)) > 300 ";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->execute();
            // commit the transation
            if($this->dbconn->commit()){
                return true;
            }
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }//end insert category
}
?>