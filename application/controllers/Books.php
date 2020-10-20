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

class Books extends CI_Controller {

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
		/*if($this->session->userdata('user_id')!=2){
			$this->load->view('web/header');
			$this->load->view('web/downtime');
			$this->load->view('web/footer');
			return;
		}*/
		$audit_log=array('page'=>"Books",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['getData']=$this->input->get('message',true);
		$temp=json_decode(base64_decode($data['getData']),true);
		$data['open_popup']=$temp['open_popup'];
		$data['address']=$temp['address'];
		$data['book_qty']=$temp['book_qty'];
		//print_r($temp);
		//exit;
		if($data['getData']!=""){
			$data['getData']=json_decode(base64_decode($data['getData']),true);
		}
		$data['pageid'] = 6;				
		$this->load->view('web/header',$data);
		$this->load->view('web/books');
		$this->load->view('web/footer');		
	}
}
?>