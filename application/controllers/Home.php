<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Home extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session'));	
		$this->load->model('homem');
		redirect(base_url(),'refresh');
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$audit_log=array('page'=>"Home",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 1;
		if($this->authorize->checkAliveSession()){
			$data['enrol_msg'] = $this->get_user_enrolment();
		}
					
		$this->load->view('web/header',$data);
		$this->load->view('web/index');
		$this->load->view('web/footer');		
	}


	private function get_user_enrolment(){
		// print_r($this->session->userdata());exit;
		$user_enrol_res = $this->homem->get_enrollment($this->session->userdata('user_id'));

		if(!empty($user_enrol_res)){
			return 'Dear '.$this->session->userdata('firstname').' '.$this->session->userdata('lastname').', your Forensic Accounting course validity is till <b>'.$user_enrol_res[0]['end_date'].'</b>';
		}else{
			return '';
		}
	}
}
?>