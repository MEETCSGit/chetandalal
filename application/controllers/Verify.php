<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Verify
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Verify extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

    private $docfilepaths = array(
									'docbc'=>'assets/docs/birthcertificate/',
									'docaddr'=>'assets/docs/addressprf/',
									'docgrad'=>'assets/docs/gradcert/',
									'docnamechng'=>'assets/docs/namechange/',
									'docpp'=>'assets/img/profile/'
								);

    private $buttonnames = array(
    							'docbc'=>'B.Certi',
								'docaddr'=>'Address proof',
								'docgrad'=>'Grad Certi',
								'docnamechng'=>'N.C certi',
								'docpp'=>'Profile Picture'
							);

    //private $useridsforverify = array(2,1339,48);

    private $documentkeys = array('docbc','docaddr','docgrad','docnamechng','docpp');

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session', 'form_validation'));
		$this->load->model('verifym');		
		if(!$this->authorize->checkAliveSession()){
            if($this->session->userdata('web_admin')!=9){
            	redirect('home','refresh');
            }
        }
		
	}
	/**
	 * Verify documents page
	 *
	 * @return void
	 */

	public function index(){

		$userflag = !empty($this->input->post('selflagusers'))?$this->input->post('selflagusers'):'not verified';
		/*echo $userflag;
		exit;*/

		$users = $this->verifym->get_profile_completed_users($userflag);
		foreach ($users as &$user) {
			$user['profilepicture'] = base_url().$this->docfilepaths['docpp'].$user['profilepicture'];
			if($user['documentverified'] === ''){
				$user['documentverified'] = 'not verified';
			}
			$docarr = array();
			$arr = json_decode($user['docpath']);
			foreach ($arr as $key => $value) {
				if(!empty($value))
					$docarr[$key] = base_url().$this->docfilepaths[$key].$value;
			}
			$user['documents'] = $docarr;
			unset($user['docpath']);
		}

		$data=keyword_desc();
		$data['users'] = $users;
		$data['userflag'] = $userflag;
		$data['buttonnames'] = $this->buttonnames;

		/*echo '<pre>';
		print_r(json_encode($data['users']));exit;
		echo '</pre>';*/

		$this->load->view('web/header',$data);		
		$this->load->view('web/verify');		
		$this->load->view('web/footer');
		
	}

	public function verifyUserDocuments($userid){
		if($this->verifym->verify_user_documents($userid)){

			$versubject = "CDIMS - Document verification";
			// $vercontent = "Your documents have been verified.You can continue to attempt the final examination.";
			$vercontent = "Your documents have been verified.";
			$res = $this->verifym->get_emailid($userid);
			$emailid = $res['email'];
			$this->sendVerifiedMail($emailid,$versubject,$vercontent,$userid);

			$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['path']='verify';
			$response['message']='User verified successfully.';
			print_r(json_encode($response));
			exit;
		}
	}

	public function sendRejectionMail(){
		// print_r($this->input->post());exit;

		$this->form_validation->set_rules('rejmailcontent', 'Rejection Reason ', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";
        	print_r(json_encode($response));
	        exit;
		}

		$documentarr = $this->input->post($this->documentkeys);
		// print_r($documentarr);exit;
		$isEmpty = true;
		foreach ($documentarr as $key=>$value) {
			if(empty($documentarr[$key])){
				unset($documentarr[$key]);
			}
			else{
				$isEmpty = false;
				$documentarr[$key] =  '<li>'.$documentarr[$key].'</li>';
			}
		}
		if($isEmpty){
			$response['res_code']=1;
			$response['method']='RegErrorMsg';
			$response['message']='Please mark check to atleast one document that needs to be rejected.';
			print_r(json_encode($response));
			exit;
		}
		/*print_r($documentarr);exit;*/

		$rejtomailid = $this->input->post('rejtomailid');

		$rejmailcontent = 'Following documents have been rejected in the verification process. Please upload valid documents as soon as possible : <br/>';

		$rejmailcontent .= '<br/><ol>'.implode(' ',$documentarr).'</ol><br/>';
		if(!empty($_POST['rejmailcontent'])){
			$rejmailcontent .= '<br/>' . $this->input->post('rejmailcontent');
		}
		
		$rejtomailuserid = $this->input->post('rejtomailuserid');
		$rejmailsubject = 'CDIMS - Rejection of Documents';



		$this->sendMail($rejtomailid,$rejmailcontent,$rejtomailuserid,$rejmailsubject,$documentarr);	
	}


	private function sendMail($tomailid, $mailcontent, $tomailuserid, $mailsubject, $documentarr){
		$this->load->library('email');
		$this->email->from('training@cdimsacademy.com', 'cdimsacademy.com');
		$this->email->subject($mailsubject);
		$this->email->to($tomailid);
		$this->email->cc('training@chetandalal.com');
		$mailbody['username'] = substr($tomailid, 0, strpos($tomailid, '@'));
		$mailbody['content'] = $mailcontent;
		$template_email=$this->load->view('web/newsletter_mail_template',$mailbody,true);
		$this->email->message($template_email);	
		if($this->email->send()){
			
			$this->verifym->set_rejection_documents($tomailuserid); //sets the rejection flag : 'rejected'

			$this->saveRejectionMail($tomailid,$mailsubject,$mailcontent, $documentarr);
			
			$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['path']='verify';
			$response['message']='Rejection Mail sent successfully.';
			print_r(json_encode($response));
			exit;
		}
	}

	private function saveRejectionMail($to, $subject, $content, $documentarr){
		$dbmaildata['type'] = 4;
		$dbmaildata['user_selection'] = 1;
		$dbmaildata['subject'] = $subject;

		/*$contentarr = explode('<li>',substr($content,strpos($content,'<li>')));
		array_splice($contentarr,0,1);
		$dbcontent = strip_tags(implode(',',$contentarr));*/
		
		// $dbmaildata['content'] = strip_tags(implode(',', $documentarr));
		$dbmaildata['content'] = $content;
		$dbmail['sent_mail']['to'] = $to;
		
		$dbmaildata['sent_mail_ids'] = json_encode($dbmail['sent_mail']);
		$dbmaildata['created_by'] = $this->session->userdata('user_id');

		$this->verifym->save_rejection_mail($dbmaildata);
	}


	private function sendVerifiedMail($tomailid, $mailsubject ,$mailcontent, $tomailuserid){
		$this->load->library('email');
		$this->email->from('training@cdimsacademy.com', 'cdimsacademy.com');
		$this->email->subject($mailsubject);
		$this->email->to($tomailid);
		// $this->email->cc($data['cc_mail_ids']);
		$mailbody['username'] = substr($tomailid, 0, strpos($tomailid, '@'));
		$mailbody['content'] = $mailcontent;
		$template_email=$this->load->view('web/newsletter_mail_template',$mailbody,true);
		$this->email->message($template_email);	
		if($this->email->send()){
			$this->saveVerifiedMail($tomailid,$mailsubject,$mailcontent);
		}
	}

	private function saveVerifiedMail($to, $subject, $content){
		$dbmaildata['type'] = 5;
		$dbmaildata['user_selection'] = 1;
		$dbmaildata['subject'] = $subject;
		$dbmaildata['content'] = $content;
		$dbmail['sent_mail']['to'] = $to;
		$dbmaildata['sent_mail_ids'] = json_encode($dbmail['sent_mail']);
		$dbmaildata['created_by'] = $this->session->userdata('user_id');

		$this->verifym->save_verified_mail($dbmaildata);
	}
}
?>