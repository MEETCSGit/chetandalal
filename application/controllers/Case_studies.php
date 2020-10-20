<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Case_studies extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
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
		$audit_log=array('page'=>"Case_studies",'action'=>'3','description'=>'Navigated');		
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 6;				
		$this->load->view('web/header',$data);
		$this->load->view('web/Case_studies');
		$this->load->view('web/footer');		
	}

	public function case_studies_details($id){
		$this->load->view('web/header');
		switch ($id) {
			case 1:
				$audit_log=array('page'=>"Case_studies",'action'=>'3','description'=>'Navigated to case_study_1');
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/case_study_1');
				break;
			case 2:
				# code...
				break;
			case 3:
				# code...
				break;
			case 4:
				# code...
				break;
			case 5:
				# code...
				break;
			case 6:
				# code...
				break;
			case 7:
				$audit_log=array('page'=>"Case_studies",'action'=>'3','description'=>'Navigated to case_study_7');
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/case_study_7');
				break;
			case 8:				
				$audit_log=array('page'=>"Case_studies",'action'=>'3','description'=>'Navigated to case_study_8');
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/case_study_8');
				break;
			case 9:
				$audit_log=array('page'=>"Case_studies",'action'=>'3','description'=>'Navigated to case_study_9');	
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/case_study_9');
				break;
			default:
				# code...
				break;
		}
		$this->load->view('web/footer');
	}
}
?>