<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Rajesh Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Login extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		if($this->authorize->checkAliveSession()){
			redirect('home','refresh');
		}
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session'));		
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$data=keyword_desc();
		$audit_log=array('page'=>"Login",'action'=>'3','description'=>'Navigated to Login');
		$this->authorize->audit_log($audit_log);
		$data['getData']=$this->input->get('message',true);
		if($data['getData']!=""){
			$data['getData']=json_decode(base64_decode($data['getData']),true);
		}
		$data['hideHeader']=1;
		$data['pageid'] = 8;
		$this->load->library('user_agent');
		$data['referr']=$this->agent->referrer();				
		$this->load->view('web/header',$data);		
		$this->load->view('web/login');		
		$this->load->view('web/footer');
	}
	

}
?>