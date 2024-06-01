<?php
class return_product{
    use notification;
    private $table = 'return_table';
    private $table2 = 'return_history_table';
    private $dbconn;
	private $dbstmt;
	private $dbsql;
    private $dbnumRow;
    
    public $id;
    public $status;
    public $return_reason;
    public $request_reject_reason;
    public $return_reject_reason;
    public $regdatetime;
    public $or_id;
    public $or_order_id;
    public $p_id;
    public $u_id;
    
    public $new_status;
    
    private $last_id;
    
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
    
    public function request_opened($type='multi'){
        if(content_data($this->table,'rh_id',$this->or_id,'or_id') === false){
            $this->dbsql = "INSERT INTO {$this->table}(rh_return_reason,or_id,or_order_id,p_id,u_id) VALUES(:return_reason,:or_id,:or_order_id,:p_id,:u_id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':return_reason',$this->return_reason,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':or_order_id',$this->or_order_id,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':p_id',$this->p_id,PDO::PARAM_INT);
            $this->dbstmt->bindParam(':u_id',$this->u_id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($type === 'single'){
                $this->dbnumRow = $this->dbstmt->rowCount();
                if($this->dbnumRow > 0){return true;}else{return false;}
            }
        }
    }//end request opened
    
    public function approved($type='multi'){
        $this->dbsql = "UPDATE {$this->table} SET rh_status = :new_status WHERE or_id = :or_id AND or_order_id = :or_order_id LIMIT 1";
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':or_order_id',$this->or_order_id,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':new_status',$this->new_status,PDO::PARAM_STR);
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($type === 'single'){
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
        }
    }//end request opened
    
    public function rejected($type='multi'){
        if($this->new_status === 'request rejected'){
            $this->dbsql = "UPDATE {$this->table} SET rh_status = :new_status,rh_request_reject_reason = :request_reject_reason
            WHERE or_id = :or_id AND or_order_id = :or_order_id LIMIT 1";
        }elseif($this->new_status === 'return rejected'){
            $this->dbsql = "UPDATE {$this->table} SET rh_status = :new_status,rh_return_reject_reason = :return_reject_reason
            WHERE or_id = :or_id AND or_order_id = :or_order_id LIMIT 1";
        }
        $this->dbstmt = $this->dbconn->prepare($this->dbsql);
        $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
        $this->dbstmt->bindParam(':or_order_id',$this->or_order_id,PDO::PARAM_STR);
        $this->dbstmt->bindParam(':new_status',$this->new_status,PDO::PARAM_STR);
        if($this->new_status === 'request rejected'){
            $this->dbstmt->bindParam(':request_reject_reason',$this->request_reject_reason,PDO::PARAM_STR);
        }elseif($this->new_status === 'return rejected'){
            $this->dbstmt->bindParam(':return_reject_reason',$this->return_reject_reason,PDO::PARAM_STR);
        }
        $this->dbstmt->execute();
        $this->dbnumRow = $this->dbstmt->rowCount();
        if($type === 'single'){
            $this->dbnumRow = $this->dbstmt->rowCount();
            if($this->dbnumRow > 0){return true;}else{return false;}
        }
    }//end request opened
    
    public function insert_return_history($type='multi'){
        if(content_data($this->table2,'rhs_id',$this->or_id,'or_id',"AND rhs_status = '{$this->new_status}'") === false){
            $this->dbsql = "INSERT INTO {$this->table2}(rhs_status,or_id) VALUES(:new_status,:or_id)";
            $this->dbstmt = $this->dbconn->prepare($this->dbsql);
            $this->dbstmt->bindParam(':new_status',$this->new_status,PDO::PARAM_STR);
            $this->dbstmt->bindParam(':or_id',$this->or_id,PDO::PARAM_INT);
            $this->dbstmt->execute();
            if($type === 'single'){
                $this->dbnumRow = $this->dbstmt->rowCount();
                if($this->dbnumRow > 0){return true;}else{return false;}
            }
        }
    }
    
    function run_return_data($type=''){
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        try{
            //begin transaction
            $this->dbconn->beginTransaction();
            if($type === 'request opened'){
                $this->request_opened();// insert into return table
            }elseif($type === 'request approved' || $type === 'return approved'){
                $this->approved();// update table to approved
            }elseif($type === 'request rejected' || $type === 'return rejected'){
                $this->rejected();// update table to rejected
            }
			$this->insert_return_history();//insert into the return history
            $this->insert_user_notification();//insert notification
            // commit the transation
            if($this->dbconn->commit()){
                //SEND EMAIL
                $company_email = get_json_data('support_email','about_us');
                $company_name = ucwords(get_xml_data('company_name'));
                $customer_email = content_data('user_table','u_email',$this->u_id,'u_id');
                $customer_name = content_data('user_table','u_fullname',$this->u_id,'u_id');
                $this->order_id = content_data('order_table','or_order_id',$this->or_id,'or_id');
                $mail = new mail();
                $mail->p_receiver = $customer_email;
                $mail->p_subject = return_email_subject($this->new_status,$this->order_id);
                $mail->p_message = return_email_message($this->new_status,$customer_name,$this->order_id);
                $mail->p_header = implode("\r\n",[
                        "From:".$company_name." <".$company_email.">",
                        "MIME-Version: 1.0",
                        "Content-Type: text/html; charset=UTF-8"
                        ]);
                $mailsent = $mail->send_mail();
                return true;
            }//if commit
        }catch(PDOException $e){
            //rollback
            if($this->dbconn->rollback()){return false;}//if rollback
        }// end of try and catch
    }
}
?>