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

class Expert extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','form'));
		//$this->load->library(array('session','authorize','pagination','form_validation'));				
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$data=keyword_desc();
		$audit_log=array('page'=>"Expert",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$this->load->view('web/header',$data);
		$this->load->view('web/');
		$this->load->view('web/footer');		
	}
}
?>