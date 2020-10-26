<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Mail extends CI_Controller {

    /*private $test_email_ids = array(
    		array('firstname'=>'Rajesh','email'=>'nadar.rajeshnadar@gmail.com'),
    		array('firstname'=>'Atul','email'=>'atuladhikari17@gmail.com'),
    		array('firstname'=>'Akshay','email'=>'akshaydusane@gmail.com'),
    		array('firstname'=>'RajeshC','email'=>'rajesh.nadar@camplus.co.in'),
    		array('firstname'=>'AkshayD','email'=>'akshay.dusane@camplus.co.in'),
    		array('firstname'=>'Ela','email'=>'ela.goyal@camplus.co.in'),
    		array('firstname'=>'AtulA','email'=>'atul.adhikari@camplus.co.in'),
    		array('firstname'=>'MG','email'=>'mahendra.gupta@camplus.co.in'),
    		array('firstname'=>'MG','email'=>'mahendramgupta@gmail.com'),
    		array('firstname'=>'Rajesh','email'=>'nadar.rajeshnadar@gmail.com'),
    		array('firstname'=>'Atul','email'=>'atuladhikari17@gmail.com'),
    		array('firstname'=>'Akshay','email'=>'akshaydusane@gmail.com'),
    		array('firstname'=>'RajeshC','email'=>'rajesh.nadar@camplus.co.in'),
    		array('firstname'=>'AkshayD','email'=>'akshay.dusane@camplus.co.in'),
    		array('firstname'=>'Ela','email'=>'ela.goyal@camplus.co.in'),
    		array('firstname'=>'AtulA','email'=>'atul.adhikari@camplus.co.in'),
    		array('firstname'=>'MG','email'=>'mahendra.gupta@camplus.co.in'),
    		array('firstname'=>'MG','email'=>'mahendramgupta@gmail.com')
		);*/

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library('excel');
		$this->load->model("mailm");
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$audit_log=array('page'=>"Mail",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 1;	
		$this->load->view('web/header');
		$this->load->view('web/mail');
		$this->load->view('web/footer');
	}

	public function sendMail(){
		/*print_r($this->input->post());
		exit;*/
		$audit_log=array('page'=>"Mail",'action'=>'4','description'=>'Mail sent to the users.');
		$this->authorize->audit_log($audit_log);
		$maildata['type'] = $this->input->post('mailtype');
		
		// if($maildata['type'] == 1 || $maildata['type'] == 2){ // 1-Article | 2-Newsletter | 3-Notification
			$maildata['user_selection'] = $this->input->post('selectall');
			if($maildata['user_selection'] == 1){  // selected users  // take emailids from formfield and broadcast
				
				$to_emailids = $this->input->post('tomails');

				if($maildata['type'] == 1 || $maildata['type'] == 2)
					$maildata['to_mails'] = $this->checkForSubscription($this->explodeMailIds($to_emailids),$maildata['type']);
				else
					$maildata['to_mails'] = $this->getUserDetails($this->explodeMailIds($to_emailids));
				

			}else if($maildata['user_selection'] == 2){	// to all users  // fetch emailids from DB who are subscribed and broadcast

				if($maildata['type'] == 1 || $maildata['type'] == 2){
					$resultset = $this->mailm->get_email_ids($maildata['type']); //live
					// $resultset = $this->test_email_ids; //test
					// print_r($resultset);exit;
				}
				else{
					$resultset = $this->mailm->get_all_email_ids();
				}
				/*print_r($resultset);exit;*/
				foreach ($resultset as $mail) {
					$maildata['to_mails'][] = array('firstname'=>$mail['firstname'], 'email'=>$mail['email']);
				}
				
				
				//$maildata['users'] = $resultset;  
			}
			
			if(!empty($this->input->post('ccmails'))){
				$cc_emailids = $this->input->post('ccmails');
				$maildata['cc_mail_ids'] = $cc_emailids;
			}/*else{
				$maildata['cc_mail_ids'] = $this->getCcMailIds();
			}*/

			if(!empty($this->input->post('bccmails'))){
				$bcc_emailids = $this->input->post('bccmails');
				$maildata['bcc_mail_ids'] = $bcc_emailids;
			}/*else{
				$maildata['bcc_mail_ids'] = $this->getBccMailIds();
			}*/

			if(!empty($this->input->post('subject'))){
				$maildata['subject'] = $this->input->post('subject');
			}
			if(!empty($this->input->post('content'))){
				$maildata['content'] = $this->input->post('content');
			}

			// print_r(json_encode($maildata));exit;

			$this->mail_to_subscribed_users($maildata);
		// }
	}

	private function mail_to_subscribed_users($data){

		// print_r($data);exit;

		$config['priority'] = 1;
		$this->load->library('email');
		/*$this->email->initialize(array(
		  'protocol' => 'sendmail',
		  'smtp_host' => 'smtp.sendgrid.net',
		  'smtp_user' => 'akshaydusane@gmail.com',
		  'smtp_pass' => 'India@123',
		  'smtp_port' => 587,
		  'crlf' => "\r\n",
		  'newline' => "\r\n",
		  'priority'=>1,
		  'dkim_identity'=>'support@chetandalal.com'
		));*/
			
		// $this->email->initialize($config);	
		$this->email->set_header('X-DKIM', 'DKIM-Signature: v=1; a=rsa-sha256; c=relaxed/relaxed; d=cdimsacademy.com; s=google;');
		$this->email->from('info@cdimsacademy.com', 'Chetan Dalal');
		
		
		// $template_email=$data['content'];
		$mailbody['content'] = $data['content'];
		$arr_to_mailids = array();
		foreach($data['to_mails'] as $user){
			$this->email->subject($data['subject']);
			// $this->email->to('akshaydusane@gmail.com'); --test
			//print_r($user['email']);
			$this->email->to($user['email']);
			$arr_to_mailids[] = $user['email'];
			if(isset($data['cc_mail_ids']))
				$this->email->cc($data['cc_mail_ids']);
			if(isset($data['bcc_mail_ids']))
				$this->email->bcc($data['bcc_mail_ids']);
			// $mailbody['username'] = substr($tomail, 0, strpos($tomail, '@'));
			$mailbody['username'] = ucfirst(strtolower($user['firstname']));
			$mailbody['emailid'] = $user['email'];
			$hash = $this->getHash($user['email']);
			
			
			if($data['type']==1)
				$mailbody['unsubslink'] = base_url().'/Register/un-subscribe-article/'.$user['email'].'/'.$hash;
			else if($data['type']==2 || $data['type']==3)
				$mailbody['unsubslink'] = base_url().'/Register/un-subscribe-newsletter/'.$user['email'].'/'.$hash;
			
			// print_r($mailbody);exit;
			// $template_email=$this->load->view('web/newsletter_mail_template',$mailbody,true);
			
		 	$template_email=$this->load->view('web/indpd70',$mailbody,true);
		 	// print_r($template_email);exit;
			$this->email->message($template_email);	
			/*$attachment_path = base_url('assets/crouse_brochure/Brochure-Classroom.pdf');
			$this->email->attach($attachment_path);*/
			$this->email->send();
			// break;
		}
		$data['emailids'] = $arr_to_mailids;
		// print_r($data['emailids']);
		$this->saveSentMails($data);
		// echo $this->email->print_debugger();
	}

	public function promomail(){
		$this->load->view('web/a_promomail.php');
	}
	
	public function sendpromomail(){
		error_reporting(-1);
		ini_set('display_errors', 1);
		$resultset = $this->mailm->get_subscribed_users();
		//$resultset = $this->get_mail_ids();
		//print_r($resultset);
		/*$emailids=array();
		foreach ($resultset as $key => $value) {
			$emailids[]=$value['emailid'];
		}*/
		/*echo "<pre>";
		var_dump($emailids);
		exit;*/
		$this->load->library('email');
		$config['protocol'] = 'mail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'UTF-8';
		$config['mailtype'] = 'html';
		$email=array();
		foreach ($resultset as  $value) {
			$this->email->initialize($config);
			$this->email->from('info@cdimsacademy.com', 'cdimsacademy.com');		
			$this->email->reply_to('training@cdimsacademy.com', 'cdimsacademy.com');		
			$this->email->subject("Reduce your Organisation's vulnerability against Frauds and Increase Your Profitability Next Year ....check out How?  ");
			$this->email->to($value['emailid'],$value['emailid']);

			$email[]=$value['emailid'];
			/*$this->email->to('nadar.rajeshnadar@gmail.com','rajeshnadar');
			$this->email->to('mahendra.gupta@camplus.co.in','mahendra.gupta');
			$this->email->to('atuladhikari17@gmail.com','atuladhikari17');
			$this->email->to('akshaydusane@gmail.com','akshaydusane');
			$this->email->to('piyushshekhar5151@gmail.com','piyushshekhar5151');*/
			$template_email=$this->load->view('web/a_promomail.php','',true);
			$this->email->message($template_email);
			//$this->email->attach('assets/mail/eLearn_Brochure_corp.pdf');	
			$this->email->send();
			//sleep(1);

		}
		echo "<pre>";
		print_r($email);
			
		
	}

	public function saveSentMails($maildata){
		$audit_log=array('page'=>"Mail",'action'=>'1','description'=>'Stored the mail content and mailed user.');
		$this->authorize->audit_log($audit_log);
		$dbmaildata['type'] = $maildata['type'];
		$dbmaildata['user_selection'] = $maildata['user_selection'];
		$dbmaildata['subject'] = $maildata['subject'];
		$dbmaildata['content'] = $maildata['content'];
		$dbmail['sent_mail']['to'] = implode(',', $maildata['emailids']);
		if(isset($data['cc_mail_ids']))
			$dbmail['sent_mail']['cc'] = $maildata['cc_mail_ids'];
		if(isset($data['bcc_mail_ids']))
			$dbmail['sent_mail']['bcc'] = $maildata['bcc_mail_ids'];
		$dbmaildata['created_by'] = $this->session->userdata('user_id');
		
		$dbmaildata['sent_mail_ids'] = json_encode($dbmail['sent_mail']);

		// print_r(json_encode($dbmaildata));

		if($this->mailm->save_mail($dbmaildata)){
			$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['path']='home';
			$response['message']='Mail sent Successfully.';
		}else{
			$response['res_code']=1;
			$response['method']='RegErrorMsg';
			$response['message']='Something went wrong.';
		}
		print_r(json_encode($response));
	}	

	private function checkForSubscription($tomailids,$mailtype){
		$arr_mail_users = array();
		foreach ($tomailids as $key => $value){
			$res = $this->mailm->check_subscription($value,$mailtype);
			if($res){
				$set = $res[0];
				$arr_mail_users[] = array('firstname'=>$set['firstname'], 'email'=>$set['email']);
			}
		}
		return $arr_mail_users;
	}

	private function getUserDetails($tomailids){
		$arr_mail_users = array();
		foreach ($tomailids as $key => $value){
			$res = $this->mailm->get_user_details($value);
			if($res){
				$set = $res[0];
				$arr_mail_users[] = array('firstname'=>$set['firstname'], 'email'=>$set['email']);
			}
		}
		return $arr_mail_users;
	}

	private function explodeMailIds($str_emailds){
		$arr_emailids = explode(",", $str_emailds);
		return $arr_emailids;
	}

	private function getHash($email){
		return substr(hash_hmac('whirlpool',$email.$email,'R@J€$h'),0,14);
	}
	public function viewtemplate(){
		$mailbody['emailid']="rajesh";
		$mailbody['unsubslink']="rajesh";
		$this->load->view('web/indpd70',$mailbody);
	}

	public function email_test(){
		$this->load->library('email');
		
		$this->email->from('training@cdimsacademy.com', 'Name');
		$this->email->to('atul.adhikari@camplus.co.in');
		// $this->email->cc('another@example.com');
		// $this->email->bcc('and@another.com');
		
		$this->email->subject('subject');
		$this->email->message('message');
		
		$this->email->send();
		
		echo $this->email->print_debugger();
		exit();
	}

	//Only to be used while testing
	/*public function getCcMailIds(){
		$arr_cc_mailids = 'akshay.dusane@camplus.co.in';
		return $arr_cc_mailids;
	}

	public function getBccMailIds(){
		$arr_bcc_mailids = 'akshay.dusane93@gmail.com';
		return $arr_bcc_mailids;
	}*/
	
}
?>