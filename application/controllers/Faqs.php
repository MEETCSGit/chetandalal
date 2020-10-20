<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage FAQs
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Faqs extends CI_Controller {

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
		$audit_log=array('page'=>"Faqs",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();				
		$this->load->view('web/header',$data);
		$this->load->view('web/faqs');
		$this->load->view('web/footer');		
	}
}
?>