<?php
include("dboperations.php");
class DBConnection extends dboperations
{	
    public function dbconnection()
    { 
        try {
            $conn = new PDO('mysql:host=localhost;dbname=scheduler', 'root', 'webonise6186');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function signin($dbHandle,$param) {
        $option = array('id','email');
		$condition = array('user_name'=>$param['username'],'password'=>md5($param['password']));		
		$result = dboperations::fetchOneRecord($dbHandle,'tbl_user',$option,$condition,'');
		    	
        $_SESSION['id']=$result['id'];
        $_SESSION['email_id']=$result['email'];
        return $result;
    }

	public function get_all($dbHandle) {
		$param = array('id','e_name','e_description','e_to','e_subject','e_date','e_sent');
		$condition = array('e_from'=>$_SESSION['email_id']);
		$orderby = 'ORDER BY e_date DESC';		
		$result = dboperations::fetchAllRecord($dbHandle,'tbl_email_schedule',$param,$condition,'',$orderby);
		
	    return $result;
	}
	
	public function save_schedule($dbHandle,$param) {
		if(array_key_exists('schedule',$param))
		{
			$scheduledate = ($param['e_date'] == '')?'NULL':$param['e_date'];
			$cols = array('e_name','e_description','e_from','e_to','e_subject','e_body','e_date');
			$values = array($param['e_name'],$param['e_description'],$_SESSION['email_id'],$param['e_to'],$param['e_subject'],$param['e_body'],$scheduledate);		
			$result = dboperations::insertRecord($dbHandle,'tbl_email_schedule',$cols,$values);
	   
		}
		elseif (array_key_exists('update-schedule',$param))
		{ 
			$dbparam = array("e_name='".$param['e_name']."'","e_description='".$param['e_description']."'","e_to='".$param['e_to']."'","e_subject='".$param['e_subject']."'","e_body='".$param['e_body']."'");			
			$condition = array("id"=>$param['e_id']);
			$result = dboperations::updateRecord($dbHandle,'tbl_email_schedule',$dbparam,$condition,'','');
		} 
	}    
	public function process_email($dbHandle) {
		//Get emails which are not set
		$option = array('*');
		$condition = array('is_active'=>1,'e_sent'=>0);
		$extrawhere = " AND e_date < now()";
		$result = dboperations::fetchAllRecord($dbHandle,'tbl_email_schedule',$option,$condition,$extrawhere,'');


		foreach($result as $emailcontent){
		// Send
		//mail($emailcontent['e_to'],$emailcontent['e_subject'], $emailcontent['e_body']);
		$param = array("e_sent='1'");			
		$condition = array('id'=>$emailcontent['id']);
		$result = dboperations::updateRecord($dbHandle,'tbl_email_schedule',$param,$condition);

		 /*if(mail($emailcontent['e_to'],$emailcontent['e_subject'], $emailcontent['e_body'])){
			$stmt = $dbHandle->prepare("UPDATE tbl_email_schedule SET e_sent = '1' WHERE id='".$emailcontent['id']."'");
			$scheduledate = ($emailcontent['e_date'] == '')?'NULL':$emailcontent['e_date'];
		    try {
		        $stmt->execute();
		    } catch(PDOExecption $e) {
		        print "Error!: " . $e->getMessage() . "</br>";
		    }
            }*/
		 }
		}
		public function updatestatus($dbHandle,$value)
		{
			try {
				$stmt = $dbHandle->prepare("UPDATE tbl_email_schedule SET e_sent = '2' WHERE id='".$value."'");		
	       		$stmt->execute();
	   		} catch(PDOExecption $e) {
	       		print "Error!: " . $e->getMessage() . "</br>";
	    	}
	    	return $stmt;
		}
		public function getscheduleemail($dbHandle,$id)
		{
			$option = array('id','e_name','e_description','e_to','e_subject','e_body','e_date','e_sent');
			$condition = array('id'=>$id);		
			$result = dboperations::fetchOneRecord($dbHandle,'tbl_email_schedule',$option,$condition,'');
		
       		return $result;
		}
}
?>
