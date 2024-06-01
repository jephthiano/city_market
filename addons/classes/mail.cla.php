<?php
class mail{
    public $p_receiver;
    public $p_subject;
    public $p_message;
    public $p_header; 
    
    public function send_mail(){
        if(mail($this->p_receiver,$this->p_subject,$this->p_message,$this->p_header)){
            return true;
        }else{
            return false;
        }
    }//end of send mail
}
?>