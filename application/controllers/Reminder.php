<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Reminder
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Reminder extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

    private $filename = 'test.txt';

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper','file'));
		$this->load->library(array('session'));
		$this->load->model("reminderm");		
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		/*if($this->input->is_cli_request()){
			$data = 'true';
		    write_file($this->filename, $_SERVER);
	    }else{
	    	$data = 'false';
		    write_file($this->filename, $data);
	    }*/
		$this->checkNonVerifiedUsers();		
		/*}else{
			$this->load->view('web/header');
			$this->load->view('web/404');
			$this->load->view('web/footer');
		}*/
	}

	/**
	 * Check for those users whose profile is completed but not document are not verified
	 *
	 * @return void
	 */

	private function checkNonVerifiedUsers(){
		$this->load->library('user_agent');
		if($this->reminderm->check_non_verified_users()){
			/*print_r(json_encode($this->reminderm->get_web_admin_users()));
			exit;*/
			$arr_to_mailids = $this->reminderm->get_web_admin_users();
			$nonsubject = 'Reminder for document verification';
			$nonmessage = 'There are some users whose documents need to be verified.';
			$this->sendMailWebAdminUsers($arr_to_mailids, $nonsubject, $nonmessage);
		}
	}

	/**
	 * Send Mail to the web admin users for reminding about there are users whose document verification is pending
	 *
	 * @return void
	 */
	private function sendMailWebAdminUsers($to_mailids, $mailsubject, $content){
		$this->load->library('email');
		$this->email->from('support@chetandalal.com', 'chetandalal.com');
		$mailbody['content'] = $content;
		foreach ($to_mailids as $tomail) {
			$this->email->subject($mailsubject);
			$this->email->to($tomail['email']);
			$mailbody['username'] = substr($tomail['email'], 0, strpos($tomail['email'], '@'));
			$template_email=$this->load->view('web/newsletter_mail_template',$mailbody,true);
			$this->email->message($template_email);
			$this->email->send();
		}
		$this->saveMailWebAdminUsers($to_mailids,$mailsubject,$content);
	}

	/**
	 * Logs reminder mail to database
	 *
	 * @return void
	 */

	private function saveMailWebAdminUsers($to_mailids, $subject, $content){
		$dbmaildata['type'] = 6; //reminder type
		$dbmaildata['user_selection'] = 1; 
		$dbmaildata['subject'] = $subject;
		$dbmaildata['content'] = $content;
		$dbmail['sent_mail']['to'] = $to_mailids;
		$dbmaildata['sent_mail_ids'] = json_encode($dbmail['sent_mail']);
		$dbmaildata['created_by'] = 0; // bot is sending mails

		$this->reminderm->save_reminder_mail($dbmaildata);
	}
}
?>