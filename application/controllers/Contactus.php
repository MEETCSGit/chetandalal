<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Contact US
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Contactus extends CI_Controller {

    /**	
	 *
	 * @return void
	 */
 
	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->library(array('session','form_validation','authorize')); 
		$this->load->helper(array('url','html','form','api_helper'));
		//$this->$this->load->model("sendMail");
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	
	public function index() {		
		$audit_log=array('page'=>"Contact Us",'action'=>'3','description'=>'Navigated');
		//$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 7;
		$this->load->view('web/header',$data);
		$this->load->view('web/contact-us');
		$this->load->view('web/footer');		
	}

	public function sendmail(){
		
		$this->form_validation->set_rules('firstname', 'Name ', 'trim|required|alpha_numeric_spaces|min_length[2]');
		$this->form_validation->set_rules('lastname', 'Name ', 'trim|required|alpha_numeric_spaces|min_length[2]');
		$this->form_validation->set_rules('email', 'Email ID ', 'trim|required|valid_email|min_length[2]');
		$this->form_validation->set_rules('mob', 'Mobile No. ', 'trim|required|min_length[10]|numeric|max_length[10]');
		$this->form_validation->set_rules('message', 'Message ', 'trim|required|min_length[10]|max_length[500]');
		
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";         	       	
        	print_r(json_encode($response));
	        exit;        	
		}

		//load email library
		$this->load->library('email');
		$email_from=$this->input->post('email');
		$email_subject="Chetandalal - Contact us from mail. ";
		$name=ucfirst($this->input->post('firstname'));
		$message=$this->input->post('message');
		$data['firstname']=$name;
		$data['email']=$this->input->post('email');
		$data['phone']=$this->input->post('mob');
		$data['message']=$message;
		$this->email->from('training@cdimsacademy.com','CDIMS Training');
		$this->email->cc('training@chetandalal.com');
		$this->email->to($email_from,$name);
		$this->email->subject($email_subject);
		$email_template=$this->load->view('web/contact_us_mail_template',$data,true);
		$this->email->message($email_template);
			
		//print_r()
		$data=array();
		if($this->email->send()){
			$audit_log=array('page'=>"Contact Us",'action'=>'4','description'=>'Mail Sent at ');
			$this->authorize->audit_log($audit_log);
			$data['res_code']=1;
			$data['method']='RegSuccMsg';
			$data['path']=base_url('contactus');
			$data['message']="Thank you for your message. <br />CDIMS team will get back to you soon";
		}
		else{
			$audit_log=array('page'=>"Contact Us",'action'=>'4','description'=>'Mail Error at '.date('d-m-Y H:i:s'));		
			$this->authorize->audit_log($audit_log);
			$data['res_code']=1;
			$data['method']='loginErrorMsg';
			$data['message']="Error while sending email.";	
		}
		print_r(json_encode($data));
	}
}
?>