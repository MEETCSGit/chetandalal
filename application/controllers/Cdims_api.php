<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Register
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Cdims_api extends CI_Controller {
	
	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','form_validation','encryption','authorize'));
		$this->load->model("registerm");	
		if($this->input->server('HTTP_ORIGIN')!="https://test.payu.in"){	//https://secure.payu.in for live URL		
			redirect('pagenotfound','refresh');
		}	
	}
	private $payuURL="https://test.payu.in";

	public function index() {		
		$data=keyword_desc();		
		$this->load->view('web/header',$data);
		$this->load->view('web/register');
		$this->load->view('web/footer');
	}
	
	public function enrolUserRest($roleid, $userid, $courseid){
		$this->load->library('curl');
		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'enrol_manual_enrol_users';
		$restformat = 'json';
		$user = new stdClass();
		$user->roleid = $roleid;
		$user->userid = $userid;
		$user->courseid = $courseid;
		$user->timestart = time();
		$user->timeend = time() + (180 * 24 * 60 * 60);
		$enrol = array($user);
		$params = array('enrolments' => $enrol);
		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
		$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_BUFFERSIZE => 0));
		if(isset($restres->exception)){
			/*$response['res_code']=0;
			$response['method']='loginErrorMsg';
			$response['message']='Oops! Something went wrong,Please try again...';*/
			return 1;
			//exit;
		}else{
			/*$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['message']='Enrolled successfully to the online course.';*/
			return 0;
			//exit;
		}
	}
	private function get_useragent(){
		$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
		        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		        $agent = $this->agent->mobile();
		}
		else
		{
		        $agent = 'Unidentified User Agent';
		}
		$platform= $this->agent->platform();
		$agent_string=$this->agent->agent_string();	
		
		$data['user_agent']="Platform : ".$platform." | UserAgent : ".$agent." | UserAgent Details : ".$agent_string;
		$data['ip_address']=getIpAddress();
		return $data;
	}	
	private function get_amount($tid){
		$o_id=explode('_', $tid);
		$o_id=$o_id[0];
		$amt=$this->registerm->get_transaction_amount_test($o_id);
		return $amt[0]['order_amt'];
	}
	private function get_oid($tid){
		$t_id=explode('_', $tid);
		return $t_id[0];
	}	
	public function success(){
		if($this->input->server('HTTP_ORIGIN')!=$this->payuURL){	//https://secure.payu.in for live URL		
			redirect('pagenotfound','refresh');
		}
		//check userid exist in the database.

		//echo '<pre>';
		//print_r($this->input->server());
		//exit;
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			//'amount'=>"6500.00", //Please use the amount value from database
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->input->post('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"DPDBHpbu",//live
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',
			'bank_ref_num'=>@$_POST['bank_ref_num']
		);
	
		if (isset($_POST["additionalCharges"])) {	      	
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	        
	    }else {
	      	
	      	$retHashSeq = $data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];	      	
	    }
	    
	  	$hash = hash("sha512", $retHashSeq);
	  	//$data['hash']=$retHashSeq;
	  	if($data['udf3']==='olc'){
	  		$data['udf1']="";
	  	}
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order_test($data);
	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Successful';
	  		$update_status=$this->registerm->update_order_test($data);	  		
	  		$data['subject']="Successful Enrollment - Chetandalal Classroom Course Enrollment "; 
	  		if($data['udf3']==='olc'){	  			
	  			$this->enrolUserRest(5,$data['user_id'],2);
	  			$audit_log=array('page'=>"Register",'action'=>'1','description'=>'Enrolled for online course using API.');
				$this->authorize->audit_log($audit_log);
	  			$data['subject']=@$data['firstname'].", Successful Enrollment - Chetandalal Online Course";
	  		}
	  		$this->mail_for_course_registration($data);
	  		//$this->mail_for_downtime($data);
	        $data['message']="<h3>Thank You, " . @$data['firstname'] .".</h3>
	        <h4>Order status  : ". $data['status'].".</h4>
	        <h4>Transaction ID : ".@$data['txnid'].".</h4>
	        <h4>Bank Reference No : ". $_POST['bank_ref_num'].".</h4>	        
	        "; 
	        echo $data['message'];
	    }
	}
	public function cancel(){
		
		if($this->input->server('HTTP_ORIGIN')!=$this->payuURL){	//https://secure.payu.in for live URL		
			redirect('pagenotfound','refresh');
		}
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Transction cancelled API.');
		$this->authorize->audit_log($audit_log);
		
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			//'amount'=>"6500.00", //Please use the amount value from database
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->input->post('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"DPDBHpbu",//live
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',
			'bank_ref_num'=>@$_POST['bank_ref_num']
		);
	
		if (isset($_POST["additionalCharges"])) {
	      	if($data['udf3']==='olc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}elseif($data['udf3']==='crc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}
	        
	    }else {
	      	
	      	$retHashSeq = $data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];	      	
	    }
	    $hash = hash("sha512", $retHashSeq);
	  	if($data['udf3']==='olc'){
	  		$data['udf1']="";
	  	}
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order_test($data);

	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Canceled';
	  		$update_status=$this->registerm->update_order_test($data);	  		
	  		$data['subject']="Transaction Canceled! Failed to Enroll - Chetandalal Classroom Course Enrollment "; 
	  		if($data['udf3']==='olc'){
	  			
	  			$data['subject']="Transaction Canceled! Failed to Enroll - Chetandalal Online Course";
	  		}else if($data['udf3']==='git'){	  			
	  			$data['subject']="Transaction Canceled - Gita for Professionals  ";

	  		}	
	  		$this->mail_for_course_registration($data);
	        $data['message']="<h3>Thank You, " . @$data['firstname'] .".</h3>
	        <h4>Order status  : ". $data['status'].".</h4>
	        <h4>Transaction ID : ".@$data['txnid'].".</h4>
	        <h4>Error Message : ".@$_POST['error_Message'].".</h4>	        	        
	        "; 
	         echo $data['message'];     
	    }		
	}
	public function failure(){
		if($this->input->server('HTTP_ORIGIN')!=$this->payuURL){	//https://secure.payu.in for live URL		
			redirect('pagenotfound','refresh');
		}
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Transction failed.');
		$this->authorize->audit_log($audit_log);
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			//'amount'=>"6500.00", //Please use the amount value from database
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->input->post('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"DPDBHpbu",//test
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',
			'bank_ref_num'=>@$_POST['bank_ref_num']
		);
	
		if (isset($_POST["additionalCharges"])) {
	      	if($data['udf3']==='olc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}elseif($data['udf3']==='crc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}
	        
	    }else {
	      	
	      	$retHashSeq = $data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];	      	
	    }
	    $hash = hash("sha512", $retHashSeq);
	  	if($data['udf3']==='olc'){
	  		$data['udf1']="";
	  	}
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order_test($data);

	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Failed';
	  		$update_status=$this->registerm->update_order_test($data);	  		
	  		$data['subject']="Transaction failure! Failed to Enroll - Chetandalal Classroom Course Enrollment "; 
	  		if($data['udf3']==='olc'){
	  			//$this->enrolUserRest(5,$this->session->userdata('user_id'),2);
	  			$data['subject']="Transaction failure! Failed to Enroll - Chetandalal Online Course";
	  		}else if($data['udf3']==='git'){	  			
	  			$data['subject']="Transaction failure - Gita for Professionals  ";

	  		}	
	  		$this->mail_for_course_registration($data);
	        $data['message']="<h3>Thank You, " . @$data['firstname'] .".</h3>
	        <h4>Order status  : ". $data['status'].".</h4>
	        <h4>Transaction ID : ".@$data['txnid'].".</h4>
	        <h4>Error Message : ".@$_POST['error_Message'].".</h4>	        	        
	        "; 
	         echo $data['message'];     
	    }		
	}

	
	
	private function mail_for_course_registration($data){
		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('training@cdimsacademy.com', 'CDIMS Academy');
		$this->email->to($data['email']);
		if($data['udf3']=='olc'){
			//$this->email->cc('elearning_enrol@cdimsacademy.com');
			$this->email->bcc('atul.adhikari@camplus.co.in');
		}	
		$this->email->subject($data['subject']);
		$template_email=$this->load->view('web/transaction_success_mail_template',$data,true);
		//print_r($template_email);
		$this->email->message($template_email);		
		return $this->email->send();		
		//echo $this->email->print_debugger();
	}
	//to used for testing
	private function mail_for_downtime(){
		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('training@cdimsacademy.com', 'CDIMS Academy');
		$this->email->to('atul.adhikari@camplus.co.in');		
	
		$this->email->subject('Downtime user payment ');
		$template_email="
				<p>Name :".$this->session->userdata('firstname')." </p>
				<p>User Id : ".$this->session->userdata('user_id')." </p>
				<p>email : ".$this->session->userdata('email')." </p>
		";
		$this->email->message($template_email);		
		$this->email->send();		
		//echo $this->email->print_debugger(); 
	}	
	/*public function mail_for_user_registration_test(){
		$data=array(
					'link'=>base_url('register/verifyemail/'.@$data['lms_id'].'/'.@$data['hash']),
					'email'=>'atul.adhikari@camplus.co.in',
					'firstname'=>'rajesh'					
				);
		$config['protocol']         = 'sendmail'; 

		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('support@chetandalal.com', 'chetandalal.com');
		$this->email->to('rajeshsnadar1989@gmail.com');		
		//$this->email->cc('registration@chetandalal.com');
		$this->email->subject('Successful Registration ');
		$template_email=$this->load->view('web/registration_success_mail_template',$data,true);
		$this->email->message($template_email);		
		echo $this->email->send();		
		echo $this->email->print_debugger();
	}*/	
}
?>