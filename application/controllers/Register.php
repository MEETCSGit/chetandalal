<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Register
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Register extends CI_Controller {
	private $olc_amt=15000;
	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','form_validation','encryption','authorize'));
		$this->load->model("registerm");		
	}

	public function index() {
		if($this->authorize->checkAliveSession()){
			redirect('home','refresh');
		}
		$data=keyword_desc();
		$audit_log=array('page'=>"Register",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$this->load->view('web/header',$data);
		$this->load->view('web/register');
		$this->load->view('web/footer');
	}
	public function validChr($str) {
	    if(!preg_match('/^[A-Za-z0-9\-\'.]+$/',$str)){
	    	//print_r($str);
	    	$this->form_validation->set_message('validChr', '{field} : Invalid character provided.');
	    	return false;
	    }
	    return true;
	}
	public function registerUser(){

		$this->form_validation->set_rules('firstname', 'Name ', 'trim|required|callback_validChr|min_length[2]');
		$this->form_validation->set_rules('lastname', 'Name ', 'trim|required|callback_validChr|min_length[2]');
		$this->form_validation->set_rules('email', 'Email ID ', 'trim|required|valid_email|min_length[2]');
		$this->form_validation->set_rules('mobile', 'Mobile No. ', 'trim|required|min_length[10]|numeric|max_length[10]');
		$this->form_validation->set_rules('password', 'Password ', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('cpass', 'Confirm Password ', 'trim|required|matches[password]|min_length[8]');
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=1;
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";         	       	
        	print_r(json_encode($response));
	        exit;        	
		}
		$fname = $this->input->post('firstname');
		$lname = $this->input->post('lastname');
		$mobile = $this->input->post('mobile');
		$email = $this->input->post('email');
		$pwd = $this->input->post('password');

		/*validation logic here */
		
		$this->createUserRest($fname,$lname,$mobile,$email,$pwd);		
	}
	public function createUserRest($fname, $lname, $mobile, $email, $pwd){
		
		$this->load->library('curl');

		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'core_user_create_users';
		$restformat = 'json';
		$user = new stdClass();
		$user->username = $email;
		$user->password = $pwd;
		$user->firstname = $fname;
		$user->lastname = $lname;
		$user->email = $email;
		$user->auth = 'manual';

		$users = array($user);
		$params = array('users' => $users);
		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
		$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_BUFFERSIZE => 0));
		$restres=json_decode($restres,true);
		//print_r($restres);
		if(isset($restres['exception'])){
			$response['res_code']=1;
			$response['method']='loginErrorMsg';
			$response['message']='Email address already exists.';
			print_r(json_encode($response));
			exit;
		}else{
			$response['res_code']=1;
			$response['method']='recRegisterSuccMsg';
			$response['title']='<h4><b>Thank you for registering with us.</b></h4><hr>';
			/*$response['message']='<div class="row"><center><div class="col-md-12"><h4><u><a target="_blank" href="'.base_url('courses/course_details/1').'">Classroom Course<br/><small><font color="red" style="font-size: 13px">(Special 10% discount for limited period)</font></small></h4></div><div class="col-md-12"><h4>Forensic Accounting Certification 19 - 21 Jan, Mumbai</a></u></h4></div></center></div>';*/
			$response['message']='<div class="row">Please check your mail and verify your account.</div>';
			$response['redirect_to']=base_url('login');
			$userid = $restres[0];
			$roleid = 5;  // roleid : 5 student
			$courseid = 2; // Audit, Investigation course id

			/*CI Registration -Rajesh */
			$data=$this->get_useragent();
			$data['first_name']=$fname;
			$data['last_name']= $lname;
			$data['mobile_no']= $mobile;
			$data['email']= $email;	
			$data['lms_id']= @$userid['id'];
			$data['hash']=md5(json_encode($data));			
			$this->registerm->save_member($data);
			
			$mdata=array(
					'link'=>base_url('register/verifyemail/'.@$data['lms_id'].'/'.@$data['hash']),
					'email'=>$email,
					'firstname'=>$fname					
				);
			$this->mail_for_user_registration($mdata);
			$audit_log=array('page'=>"Register",'action'=>'1','description'=>'User is registred and verification mail has been sent.');
			$this->authorize->audit_log($audit_log);
			/*End CI Registration*/
			//$this->enrolUserRest($roleid, $userid['id'], $courseid);			
			print_r(json_encode($response));
			exit;			
		}
	}
	public function verifyemail($id,$hash){
		if(empty(@$id) || empty(@$hash)){
			redirect('register','refresh');			
		}
		$count=$this->registerm->check_verify_email($id,$hash);
		if($count==1){
			$this->registerm->update_verify_email($id);
			$audit_log=array('page'=>"Register",'action'=>'3','description'=>'Registred user is verified.');
			$this->authorize->audit_log($audit_log);
			redirect('home/?message=Email verified.&status=1&event=verifyemail','refresh');
		}
		$audit_log=array('page'=>"Register",'action'=>'3','description'=>'Verification failed.');
			$this->authorize->audit_log($audit_log);
		redirect('home/?message="Email verification failed!&status=0&event=verifyemail"','refresh');
	}
	public function enrolUserRest($roleid, $userid, $courseid,$days){
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
		$user->timeend = time() + ($days * 24 * 60 * 60);
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
		$amt=$this->registerm->get_transaction_amount($o_id);
		return $amt[0]['order_amt'];
	}
	private function get_oid($tid){
		$t_id=explode('_', $tid);
		return $t_id[0];
	}	
	private function get_user_id($tid){
		$t_id=explode('_', $tid);
		return $t_id[1];
	}
	public function transactionSuccess(){
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->session->userdata('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"SMBJdLFO",//live
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>$this->get_user_id($_POST["txnid"]),
			'bank_ref_num'=>@$_POST['bank_ref_num']
		);
	
		if (isset($_POST["additionalCharges"])) {
	      	if($data['udf3']==='olc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}elseif($data['udf3']==='crc'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}elseif($data['udf3']==='git'){
	      		$retHashSeq = $data['additionalCharges'].'|'.$data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];
	      	}
	        
	    }else {
	      	
	      	$retHashSeq = $data['salt'].'|'.$data['status'].'||||||||'.$data['udf3'].'|'.$data['udf2'].'|'.$data['udf1'].'|'.$data['email'].'|'.$data['firstname'].'|'.$data['productinfo'].'|'.$data['amount'].'|'.$data['txnid'].'|'.$data['key'];	      	
	    }
	    
	  	$hash = hash("sha512", $retHashSeq);
	  	
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order($data);
	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Successful';
	  		$update_status=$this->registerm->update_order($data);	  		
	  		$data['subject']="Successful Enrollment - Chetandalal Classroom Course Enrollment "; 
	  		if($data['udf3']==='olc'){
	  			$coupon_code_data=$this->registerm->get_transaction_coupon_code($data['oid']);
	  			$this->enrolUserRest(5,$data['user_id'],10,60);	  				  			
	  			if(!empty(@$coupon_code_data[0]['coupon_code'])){
	  				$this->registerm->update_coupon_code_used($coupon_code_data[0]['coupon_code']);
	  			}	  				
	  			$audit_log=array('page'=>"Register",'action'=>'1','description'=>'Enrolled for online course.');
				$this->authorize->audit_log($audit_log);
	  			$data['subject']=@$data['firstname'].", Successful Enrollment - Chetandalal Online Course";
	  		}else if($data['udf3']==='oec'){
	  			$coupon_code_data=$this->registerm->get_transaction_coupon_code($data['oid']);
	  			$this->enrolUserRest(5,$data['user_id'],8,30);	  				  			
	  			if(!empty(@$coupon_code_data[0]['coupon_code'])){
	  				$this->registerm->update_coupon_code_used($coupon_code_data[0]['coupon_code']);
	  			}	  				
	  			$audit_log=array('page'=>"Register",'action'=>'1','description'=>'Enrolled for excel course.');
				$this->authorize->audit_log($audit_log);
	  			$data['subject']=@$data['firstname'].", Successful Enrollment - Chetandalal Online Course";
	  		}else if($data['udf3']==='occ'){
	  			$coupon_code_data=$this->registerm->get_transaction_coupon_code($data['oid']);
	  			$this->enrolUserRest(5,$data['user_id'],10,90);
	  			$this->enrolUserRest(5,$data['user_id'],8,90);	  				  			
	  			if(!empty(@$coupon_code_data[0]['coupon_code'])){
	  				$this->registerm->update_coupon_code_used($coupon_code_data[0]['coupon_code']);
	  			}	  				
	  			$audit_log=array('page'=>"Register",'action'=>'1','description'=>'Enrolled for both course.');
				$this->authorize->audit_log($audit_log);
	  			$data['subject']=@$data['firstname'].", Successful Enrollment - Chetandalal Online Course";
	  		}else if($data['udf3']==='git'){	
		  		$audit_log=array('page'=>"Register",'action'=>'1','description'=>'Purchased Gita for Professionals');
				$this->authorize->audit_log($audit_log);  			
	  			$data['subject']=@$data['firstname'].", Purchased Gita for Professionals  ";
	  		}else if($data['udf3']==='crc'){
	  			$audit_log=array('page'=>"Register",'action'=>'3','description'=>'Enrolled for classroom course.');
				$this->authorize->audit_log($audit_log);
	  		}
	  		$this->mail_for_course_registration($data);
	  		//$this->mail_for_downtime($data);
	        $data['message']="<h3>Thank You, " . @$data['firstname'] .".</h3>
	        <h4>Order status  : ". $data['status'].".</h4>
	        <h4>Transaction ID : ".@$data['txnid'].".</h4>
	        <h4>Bank Reference No : ". $_POST['bank_ref_num'].".</h4>	        
	        ";      
	    }
	    foreach ($data as $key => $value) {
	    	if($key!=='message'){
	    		unset($data[$key]);
	    	}
	    }

		$this->load->view('web/header');
		$this->load->view('web/transaction_success',$data);
		$this->load->view('web/footer');
	}
	public function transactionCancel(){
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Transction cancelled.');
		$this->authorize->audit_log($audit_log);
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->session->userdata('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"SMBJdLFO",//live
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>$this->session->userdata('user_id'),
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
	  	
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order($data);

	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Canceled';
	  		$update_status=$this->registerm->update_order($data);	  		
	  		$data['subject']="Transaction Canceled! Failed to Enroll - Chetandalal Classroom Course Enrollment "; 
	  		if($data['udf3']==='olc'){
	  			//$this->enrolUserRest(5,$this->session->userdata('user_id'),2);
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
	    }
	    /*echo "<pre>";
	    print_r($_POST);
	    exit;*/

	    foreach ($data as $key => $value) {
	    	if($key!=='message'){
	    		unset($data[$key]);
	    	}
	    }
	    //exit;
		
		$this->load->view('web/header');
		$this->load->view('web/transaction_cancel');
		$this->load->view('web/footer');
	}
	public function transactionFailure(){
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Transction failed.');
		$this->authorize->audit_log($audit_log);
		$data=array(
			'status'=>@$_POST["status"],
			'firstname'=>@$_POST["firstname"],
			'amount'=>$this->get_amount($_POST["txnid"]), //Please use the amount value from database
			'txnid'=>$_POST["txnid"],
			'oid'=>$this->get_oid($_POST["txnid"]),
			'phone'=>$this->session->userdata('phone'),
			'posted_hash'=>@$_POST["hash"],
			'key'=>@$_POST["key"],
			'productinfo'=>@$_POST["productinfo"],
			'email'=>@$_POST["email"],
			//'salt'=>"xZLymvPT",//test
			'salt'=>"SMBJdLFO",//live
			'udf1'=>@$_POST["udf1"] ? @$_POST["udf1"] :'',// udf1 - course
			'udf2'=>@$_POST["udf2"] ? @$_POST["udf2"] :'',// udf2 - location
			'udf3'=>@$_POST["udf3"],
			'additionalCharges'=>@$_POST["additionalCharges"]?@$_POST["additionalCharges"]:'',
			'payUresponse'=>json_encode($_POST),
			'user_id'=>$this->session->userdata('user_id'),
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
	  	
	    if ($hash != $data['posted_hash']) {	    	
	    	$data['status']='tampered';
	    	$update_status=$this->registerm->update_order($data);

	        $data['message']= "Transaction has been tampered. Please try again";
	  	}else { 
	  		$data['status']='Failed';
	  		$update_status=$this->registerm->update_order($data);	  		
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
	    }
	    /*echo "<pre>";
	    print_r($_POST);
	    exit;*/
	    foreach ($data as $key => $value) {
	    	if($key!=='message'){
	    		unset($data[$key]);
	    	}
	    }
	    //exit;
		$this->load->view('web/header');
		$this->load->view('web/transaction_failure',$data);
		$this->load->view('web/footer');
	}
	public function register_for_course_classroom(){
		/*if($this->session->userdata('user_id')!=2){
			$this->load->view('web/header');
			$this->load->view('web/downtime');
			$this->load->view('web/footer');
			return;
		}*/
		if(!$this->authorize->checkAliveSession()){
			redirect("courses",'refresh');
		}
		$data=keyword_desc();
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for classroom course.');
		$this->authorize->audit_log($audit_log);		
		$this->load->view('web/header',$data);
		$this->load->view('web/payment_classroom_course');
		$this->load->view('web/footer');
	}
	public function register_for_course_online($cd=''){
		//if($this->session->userdata('user_id')!=2){
			// $this->load->view('web/header');
			// $this->load->view('web/downtime');
			// $this->load->view('web/footer');
			// return;
		//}
		if(!empty($cd)){
			$this->load->library('user_agent');
			//print_r($cd);
			if ($this->agent->is_referral()){
			    $cd= base64_decode(base64_decode(base64_decode(urldecode($cd))));
			    $data=$this->registerm->get_coupon_code($cd);			   
			    if(!empty($data)){
			    	if(stristr($this->agent->referrer(),@$data[0]['domian'])!==FALSE){
			    		$this->session->set_userdata('coupon_code',$cd);			    		  		
			    	}
			    }
			}
		}
		$data=keyword_desc();
		if($this->session->userdata('coupon_code')!=''){			
			$data['coupon_code']=$this->session->userdata('coupon_code');
		}		
		if(!$this->authorize->checkAliveSession()){
			redirect("login",'refresh');
		}		
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for online course.');
		$this->authorize->audit_log($audit_log);
		// print_r("expression");
		// exit();
		$this->load->view('web/header',$data);
		$this->load->view('web/payment_online_course');
		$this->load->view('web/footer');
	}

	// public function register_for_course_online($cd=''){
	// 	//if($this->session->userdata('user_id')!=2){
	// 		// $this->load->view('web/header');
	// 		// $this->load->view('web/downtime');
	// 		// $this->load->view('web/footer');
	// 		// return;
	// 	//}
	// 	if(!empty($cd)){
	// 		$this->load->library('user_agent');
	// 		//print_r($cd);
	// 		if ($this->agent->is_referral()){
	// 		    $cd= base64_decode(base64_decode(base64_decode(urldecode($cd))));
	// 		    $data=$this->registerm->get_coupon_code($cd);			   
	// 		    if(!empty($data)){
	// 		    	if(stristr($this->agent->referrer(),@$data[0]['domian'])!==FALSE){
	// 		    		$this->session->set_userdata('coupon_code',$cd);			    		  		
	// 		    	}
	// 		    }
	// 		}
	// 	}
	// 	$data=keyword_desc();
	// 	if($this->session->userdata('coupon_code')!=''){			
	// 		$data['coupon_code']=$this->session->userdata('coupon_code');
	// 	}		
	// 	if(!$this->authorize->checkAliveSession()){
	// 		redirect("login",'refresh');
	// 	}		
	// 	$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for online course.');
	// 	$this->authorize->audit_log($audit_log);
	// 	// print_r("expression");
	// 	// exit();
	// 	$this->load->view('web/header',$data);
	// 	$this->load->view('web/payment_online_course');
	// 	$this->load->view('web/footer');
	// }

	public function register_for_excel_online($cd=''){
		//if($this->session->userdata('user_id')!=2){
			// $this->load->view('web/header');
			// $this->load->view('web/downtime');
			// $this->load->view('web/footer');
			// return;
		//}
		if(!empty($cd)){
			$this->load->library('user_agent');
			//print_r($cd);
			if ($this->agent->is_referral()){
			    $cd= base64_decode(base64_decode(base64_decode(urldecode($cd))));
			    $data=$this->registerm->get_coupon_code($cd);			   
			    if(!empty($data)){
			    	if(stristr($this->agent->referrer(),@$data[0]['domian'])!==FALSE){
			    		$this->session->set_userdata('coupon_code',$cd);			    		  		
			    	}
			    }
			}
		}
		$data=keyword_desc();
		if($this->session->userdata('coupon_code')!=''){			
			$data['coupon_code']=$this->session->userdata('coupon_code');
		}		
		if(!$this->authorize->checkAliveSession()){
			redirect("login",'refresh');
		}		
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for online course.');
		$this->authorize->audit_log($audit_log);
		// print_r("expression");
		// exit();
		$this->load->view('web/header',$data);
		$this->load->view('web/payment_excel_course');
		$this->load->view('web/footer');
	}

	public function register_for_combine_course($cd=''){
		//if($this->session->userdata('user_id')!=2){
			// $this->load->view('web/header');
			// $this->load->view('web/downtime');
			// $this->load->view('web/footer');
			// return;
		//}		
		if(!empty($cd)){
			$this->load->library('user_agent');
			//print_r($cd);
			if ($this->agent->is_referral()){
			    $cd= base64_decode(base64_decode(base64_decode(urldecode($cd))));
			    $data=$this->registerm->get_coupon_code($cd);			   
			    if(!empty($data)){
			    	if(stristr($this->agent->referrer(),@$data[0]['domian'])!==FALSE){
			    		$this->session->set_userdata('coupon_code',$cd);			    		  		
			    	}
			    }
			}
		}
		$data=keyword_desc();
		if($this->session->userdata('coupon_code')!=''){			
			$data['coupon_code']=$this->session->userdata('coupon_code');
		}		
		if(!$this->authorize->checkAliveSession()){
			redirect("login",'refresh');
		}		
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for online course.');
		$this->authorize->audit_log($audit_log);
		// print_r("expression");
		// exit();
		$this->load->view('web/header',$data);
		$this->load->view('web/payment_combine_course');
		$this->load->view('web/footer');
	}

	public function payment_for_course(){		
		$amount=0;//Amount initalized to zero for implementing coupon code
		
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to payment for '.$_POST['c_type_hid']);
		$this->authorize->audit_log($audit_log);
		
		$this->load->view('web/header');
		$currentURL = current_url();
		$params   = $_SERVER['QUERY_STRING'];
		$fullURL = $currentURL . '?' . $params;
		//print_r($fullURL);exit;
		if(!$this->authorize->checkAliveSession()){
			redirect("login?redirect_to=$fullURL",'refresh');
		}	
		/*if($this->session->userdata('user_id') != 2 ){
			$this->mail_for_downtime();
			$this->load->view('web/header');
			$this->load->view('web/downtime');
			$this->load->view('web/footer');
			return;
			//exit;
		}	*/	
		
		$data['udf1']='';
		$data['udf2']='';
		$data['udf3']=$_POST['c_type_hid'];//crc -classroom course olc- online course
		if(empty($data['udf3'])){
			$this->load->library('user_agent');
			$data['referr']=$this->agent->referrer();
			redirect($data['referr'],'refresh');
		}
		if($data['udf3']==="olc"){			
			$data['productinfo']="Online Course";
			//$data['amount']=$this->olc_amt;
			$data['amount']=11500;
			$o_data['course_id']=10;
			//$o_data['order_amt']=$this->olc_amt;
			$o_data['order_amt']=11500;
			$o_data['billing_name']=$this->input->post('billing_name');
			$o_data['address']=$this->input->post('billing_address');
			$o_data['reverse_charge']=empty($this->input->post('reverse_charge'))?0:1;
			if($o_data['reverse_charge']){
				$o_data['gstin_no']=$this->input->post('gstin');
			}
			/*Coupon code implementation*/
			if(!empty($this->input->post('coupon_code'))){
				$coupon_data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));
				if(!$this->validate_coupon_code($this->input->post('coupon_code')))//chcek date validity
				{
					$response['res_code']=0;      		
				    $response['message']="Coupon code is invalid!";
				    $response['coupon_code']=$this->input->post('coupon_code');
					redirect(base_url('register/register-for-course-online?message='.urlencode(base64_encode(json_encode($response)))),'refresh');
				}
				//check coupon is used or not
				if(@$coupon_data[0]['is_used']==0 || @$coupon_data[0]['multiple_use']==1 || $this->session->userdata('coupon_code')!=''){
					// $amount=$coupon_data[0]['amount'];
					$amount=1;
					$data['amount']=$data['amount']-$amount;					
					$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST with coupon
					$data['order_amt'] = $o_data['order_amt'];
				}
			}
			else{
				$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST without coupon
				$data['order_amt'] = $o_data['order_amt'];
			}
			/*Coupon code implementation end*/
			/*echo "<pre>";
			print_r($o_data);
			exit;*/
			
		}elseif($data['udf3']==="oec"){			
			$data['productinfo']="Online Excel Course";
			//$data['amount']=$this->olc_amt;
			$data['amount']=2500;
			$o_data['course_id']=8;
			//$o_data['order_amt']=$this->olc_amt;
			$o_data['order_amt']=2500;
			$o_data['billing_name']=$this->input->post('billing_name');
			$o_data['address']=$this->input->post('billing_address');
			$o_data['reverse_charge']=empty($this->input->post('reverse_charge'))?0:1;
			if($o_data['reverse_charge']){
				$o_data['gstin_no']=$this->input->post('gstin');
			}
			/*Coupon code implementation*/
			if(!empty($this->input->post('coupon_code'))){
				$coupon_data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));
				if(!$this->validate_coupon_code($this->input->post('coupon_code')))//chcek date validity
				{
					$response['res_code']=0;      		
				    $response['message']="Coupon code is invalid!";
				    $response['coupon_code']=$this->input->post('coupon_code');
					redirect(base_url('register/register-for-course-online?message='.urlencode(base64_encode(json_encode($response)))),'refresh');
				}
				//check coupon is used or not
				if(@$coupon_data[0]['is_used']==0 || @$coupon_data[0]['multiple_use']==1 || $this->session->userdata('coupon_code')!=''){
					// $amount=$coupon_data[0]['amount'];
					$amount=1;
					$data['amount']=$data['amount']-$amount;					
					$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST with coupon
					$data['order_amt'] = $o_data['order_amt'];
				}
			}
			else{
				$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST without coupon
				$data['order_amt'] = $o_data['order_amt'];
			}
			/*Coupon code implementation end*/
			/*echo "<pre>";
			print_r($o_data);
			exit;*/
			
		}
		elseif($data['udf3']==="occ"){			
			$data['productinfo']="Online Excel Course & CFACFI Course";
			//$data['amount']=$this->olc_amt;
			$data['amount']=12500;
			$o_data['course_id']=999;
			//$o_data['order_amt']=$this->olc_amt;
			$o_data['order_amt']=12500;
			$o_data['billing_name']=$this->input->post('billing_name');
			$o_data['address']=$this->input->post('billing_address');
			$o_data['reverse_charge']=empty($this->input->post('reverse_charge'))?0:1;
			if($o_data['reverse_charge']){
				$o_data['gstin_no']=$this->input->post('gstin');
			}
			/*Coupon code implementation*/
			if(!empty($this->input->post('coupon_code'))){
				$coupon_data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));
				if(!$this->validate_coupon_code($this->input->post('coupon_code')))//chcek date validity
				{
					$response['res_code']=0;      		
				    $response['message']="Coupon code is invalid!";
				    $response['coupon_code']=$this->input->post('coupon_code');
					redirect(base_url('register/register-for-course-online?message='.urlencode(base64_encode(json_encode($response)))),'refresh');
				}
				//check coupon is used or not
				if(@$coupon_data[0]['is_used']==0 || @$coupon_data[0]['multiple_use']==1 || $this->session->userdata('coupon_code')!=''){
					// $amount=$coupon_data[0]['amount'];
					$amount=1;
					$data['amount']=$data['amount']-$amount;					
					$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST with coupon
					$data['order_amt'] = $o_data['order_amt'];
				}
			}
			else{
				$o_data['order_amt']=$data['amount'] + ($data['amount'] * (18/100)); //calculation 18% GST without coupon
				$data['order_amt'] = $o_data['order_amt'];
			}
			/*Coupon code implementation end*/
			/*echo "<pre>";
			print_r($o_data);
			exit;*/
			
		}
		elseif($data['udf3']==="crc"){
			$data['udf1']=@$_POST['courselist'];
			$data['udf2']=@$_POST['location'];
			$data['productinfo']="Classroom Course -3 day Certification";
			$data['amount']=30000;
			$o_data['course_id']='0';
			$o_data['order_amt']=30000;
			/*Coupon code implementation*/
			/*if(!empty($this->input->post('coupon_code'))){
				$coupon_data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));
				if(@$coupon_data[0]['is_used']==0){
					$amount=$coupon_data[0]['amount'];
					$data['amount']=30000-$amount;
					$o_data['order_amt']=$data['amount'];
				}
			}*/
			/*coupon code implementation end*/
			
		}elseif($data['udf3']==="git"){
			if($this->authorize->isProfileComplete() == "false"){
				redirect(base_url('profile?complete=false&redirect_to=books'),'refresh');
			}
			$data['udf1']='';
			$data['udf2']='';
			$data['productinfo']="Gita For Professionals";
			$this->form_validation->set_rules('book_qty', 'Quantity', 'trim|required|numeric|max_length[2]');
			$this->form_validation->set_rules('address', 'Address ', 'trim|required|min_length[20]|max_length[500]');

			if ($this->form_validation->run() == FALSE ){ 
				$response['book_qty']=$this->input->post('book_qty');      		
	        	$response['message']=validation_errors();
	        	$response['address']=$this->input->post('address');
	        	$response['open_popup']=1;	        	     	
	        	redirect(base_url('books/?message='.urlencode(base64_encode(json_encode($response)))),'refresh');         	       
			}			
			$data['amount']=125*(int)$_POST['book_qty'];			
			$o_data['course_id']='0';
			$o_data['order_amt']=$data['amount'];
			$o_data['address']=$this->input->post('address');
			
		}else{
			$response['message']="No product information found for purchase.";
			redirect(base_url('/?message='.urlencode(base64_encode(json_encode($response)))),'refresh');
		}

		//exit;
		$o_data['user_id']=$this->session->userdata('user_id');
		$o_data['coupon_code']=$this->input->post('coupon_code');
		

		$o_data['transaction_id']=$this->session->userdata('user_id')."_".$o_data['course_id']."_".substr(hash('sha256', uniqid().mt_rand() . microtime()), 0, 20);
		$data['o_id']=$this->registerm->generateorder($o_data);	
		//$data['MERCHANT_KEY']="G1DDBd";//old live
		//$data['MERCHANT_KEY']="CY6vDs";//test
		//$data['SALT']="xAJTzWR3";//old live
		//$data['SALT']="xZLymvPT";//test
		$data['MERCHANT_KEY']="aJdT5P";//latest live	
		$data['SALT']="SMBJdLFO";//latest live

		$data['txnid']=$data['o_id']."_".$o_data['transaction_id'];

		// print_r($o_data['order_amt']);	exit;
		$data['PAYU_BASE_URL']="https://secure.payu.in/_payment";
		$data['user_id']=$this->session->userdata('user_id');
		$data['firstname']=$this->session->userdata('firstname');
		$data['lastname']=$this->session->userdata('lastname');
		$data['phone']=$this->session->userdata('phone');		
		//$data['phone']='9773353778';		
		$data['email']=$this->session->userdata('email');
		$hashSequence=$data['MERCHANT_KEY']."|".$data['txnid']."|".$o_data['order_amt']."|".$data['productinfo']."|".$data['firstname']."|".$data['email']."|".@$data['udf1']."|".@$data['udf2']."|".$data['udf3']."||||||||".$data['SALT'];
		$data['hash']=strtolower(hash('sha512', $hashSequence));
		
		//exit;
		$this->load->view('web/header');
		$this->load->view('web/payment',$data);
		$this->load->view('web/footer');
	}
	private function validate_coupon_code($couponCode=""){
		if($couponCode!=""){
			$data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));				
			if(!empty($data)){	
				if($this->input->post('c_type_hid')!=$data[0]['coupon_for']){
					return false;
				}
				if($data[0]['validupto'] < date('Y-m-d')){
					return false;
				}
			}else{
				return false;
			}
		}
		return true;
	}
	public function get_coupon_code(){
		$coupon_code='';	
		if($this->input->post('c_type_hid')=='olc'){
			$coupon_code=$this->session->userdata('coupon_code');
		}
		$this->form_validation->set_rules('billing_name', 'Billing Name', 'trim|required|max_length[30]|alpha_numeric_spaces');
		$this->form_validation->set_rules('billing_address', 'Billing Address', 'trim|required|max_length[500]|min_length[10]');
		//print_r($this->input->post('reverse_charge'));
		if($this->input->post('reverse_charge')){
			$this->form_validation->set_rules('gstin', 'GST No', 'trim|required|alpha_numeric');
		}
		/*print_r($this->input->post());
		exit;*/
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=0;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";         	        	        	       	
        	print_r(json_encode($response));
	        exit;        	
		}

		if($coupon_code!==$this->input->post('coupon_code')){
			if(!empty($this->input->post('coupon_code'))){
				$data=$this->registerm->get_coupon_code($this->input->post('coupon_code'));				
				if(!empty($data)){	
					if($this->input->post('c_type_hid')!=$data[0]['coupon_for']){
							$response['res_code']=0;      		
					    	$response['message']="Coupon code is invalid!";		    	         	       	
					    	print_r(json_encode($response));
					        exit;
					}
					if($data[0]['multiple_use']==0){									
						if($data[0]['is_used']==1){
							$response['res_code']=0;      		
					    	$response['message']="Coupon code is invalid!";		    	         	       	
					    	print_r(json_encode($response));
					        exit;
						}
					}
					if($data[0]['validupto'] < date('Y-m-d')){
						$response['res_code']=0;      		
				    	$response['message']="Coupon code expired!";		    	         	       	
				    	print_r(json_encode($response));
				        exit;
					}
				}
				else{
					$response['res_code']=0;      		
			    	$response['message']="Coupon code is invalid!";
			    	$response['method']="RegErrorMsg";         	       	
			    	print_r(json_encode($response));
			        exit;
				}						 
			}
		}
		$response['res_code']=1;
		$response['amount']=@$data[0]['amount']?@$data[0]['amount']:0;
    	print_r(json_encode($response));
        exit;  
	}
	private function mail_for_course_registration($data){
		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('training@chetandalal.com', 'chetandalal.com');
		$this->email->to($data['email']);
		if($data['udf3']=='olc'){
			$this->email->cc('elearning_enrol@chetandalal.com');
		}else if($data['udf3']=='crc'){
			$this->email->cc('class_enrol@chetandalal.com');
		}else if($data['udf3']=='git'){
			$this->email->cc('support@chetandalal.com');			
		}else{
			$this->email->cc('training@chetandalal.com');			
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
		$this->email->from('training@chetandalal.com', 'chetandalal.com');
		$this->email->to('nadar.rajeshnadar@gmail.com');		
	
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
	private function mail_for_user_registration($data){		
		// $config['priority'] = 1;
		// $config['protocol']         = 'smtp'; 
		// $config['dkim_identity'] ="support@chetandalal.com";
		$this->load->library('email');	
		//$this->email->initialize($config);	
		$this->email->from('training@cdimsacademy.com', 'CDIMS Academy');
		$this->email->to($data['email']);		
		$this->email->cc('registration@chetandalal.com');
		$this->email->subject('Successful Registration ');
		$template_email=$this->load->view('web/registration_success_mail_template',$data,true);
		$this->email->message($template_email);		
		$this->email->send();		
		// echo $this->email->print_debugger();
		// exit();
	}
	/*public function mail_for_user_registration_test(){
		$data=array(
					'link'=>base_url('register/verifyemail/'.@$data['lms_id'].'/'.@$data['hash']),
					'email'=>'nadar.rajeshnadar@gmail.com',
					'firstname'=>'rajesh'					
				);
		$config['protocol']         = 'sendmail'; 

		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('training@chetandalal.com', 'chetandalal.com');
		$this->email->to('rajeshsnadar1989@gmail.com');		
		//$this->email->cc('registration@chetandalal.com');
		$this->email->subject('Successful Registration ');
		$template_email=$this->load->view('web/registration_success_mail_template',$data,true);
		$this->email->message($template_email);		
		echo $this->email->send();		
		echo $this->email->print_debugger();
	}*/
	public function view_mail_template(){
		$this->load->view('web/newsletter_subscription_mail_template');
	}
	public function subscribe_newsletter(){
		$this->form_validation->set_rules('email', 'Email ID ', 'trim|required|valid_email|min_length[2]|is_unique[mdl_cdims_newsletter_subcription.emailid]', array('is_unique' => 'Email ID already exists. So we have resubscribed you to our newsletter.'));
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg"; 
        	$this->registerm->re_subscription($this->input->post('email'));        	        	       	
        	print_r(json_encode($response));
	        exit;        	
		}
		$data['emailid']=$this->input->post('email');
		$this->registerm->save_subscription($data);
		$this->load->library('email');
		$this->email->from('training@cdimsacademy.com', 'Newsletter Subscription');
		$this->email->to($this->input->post('email'));
		//$this->email->cc('registration@chetandalal.com','Chetandalal - Newsletter subscription');
		$this->email->subject('Thanks for subscribing to chetandalal newsletter');
		$email=explode('@', $this->input->post('email'));
		$data['firstname']=$email['0'];
		$template_email = $this->load->view('web/newsletter_subscription_mail_template',$data,true);
			//echo $template_email;
		$this->email->message($template_email);
		if($this->email->send()){
			$response['res_code']=1;
			$response['method']='Newsletter';
			$response['type']='success';
			$response['message']='Subscription successful.';
			print_r(json_encode($response));
			exit;
		}else{
			$response['res_code']=1;
			$response['method']='Newsletter';
			$response['type']='error';
			$response['message']='Subscription Failed.';
			print_r(json_encode($response));
			exit;
		}
	}
	public function un_subscribe_newsletter($mail='0',$hash='0'){
		if($mail!='0'){
			$hashcheck=substr(hash_hmac('whirlpool',$mail.$mail,'R@J€$h'),0,14);			
			if($hashcheck==$hash){
				$this->registerm->unsubmail($mail);
			}else{
				redirect('home','refresh');
			}
			$this->load->view('web/header');
			$this->load->view('web/unsubscribe');
			$this->load->view('web/footer');
		}				
	}
	public function un_subscribe_article($mail='',$hash='0'){			
		if($mail != '' ){
			$hashcheck=substr(hash_hmac('whirlpool',$mail.$mail,'R@J€$h'),0,14);				
			if($hashcheck==$hash){
				$this->registerm->unsubmail_article($mail);				
			}else{
				redirect('home','refresh');
			}	
			$this->load->view('web/header');
			$this->load->view('web/unsubscribe');
			$this->load->view('web/footer');
		}		
	}
	public function redirect(){
		if(!$this->authorize->checkAliveSession()){
			redirect('courses','refresh');
		}		
		$data=$this->registerm->get_orderDetails($this->session->userdata('user_id'));
		if(is_array(@$data)){
			foreach ($data as  $value) {
				if($value['c_type']=='olc'){
					$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to LMS');
					$this->authorize->audit_log($audit_log);
					//if(date('Y-m-d',str$value['orderdatetime'])==strtodate('Y-m-d',))
					//redirect('lms/course/view.php?id=2','refresh');
					redirect('lms/?redirect=0','refresh');
				}
			}
			$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to course page in website');
					$this->authorize->audit_log($audit_log);			
			redirect('courses','refresh');
		}
		redirect('courses','refresh');
		$audit_log=array('page'=>"Register",'action'=>'8','description'=>'Redirected to course page in website');
					$this->authorize->audit_log($audit_log);	
	}	

	public function load_mail_template(){
		$this->load->view('web/registration_success_mail_template');
	}
}
?>