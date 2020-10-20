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

class Articles extends CI_Controller {

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
		$audit_log=array('page'=>"Articles",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 6;				
		$this->load->view('web/header',$data);
		$this->load->view('web/Articles');
		$this->load->view('web/footer');		
	}

	public function article_details($cid){
		$this->load->view('web/header');
		switch($cid){
			case 'article-nature-of-fraud':				
				$audit_log=array('page'=>"Articles",'action'=>'3','description'=>'Navigated to article_nature_of_fraud');
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/article_nature_of_fraud');
				break;
			case 'article-optical-illusion':
				$audit_log=array('page'=>"Articles",'action'=>'3','description'=>'Navigated to article_optical_illusion');
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/article_optical_illusion');
				break;
			case 'article-benefits-of-variation':
				$audit_log=array('page'=>"Articles",'action'=>'3','description'=>'Navigated to article_benefits_of_variation');				
				$this->authorize->audit_log($audit_log);
				$this->load->view('web/article_benefits_of_variation');
				break;
			default :
				redirect('articles','refresh');
			break;

		}
		$this->load->view('web/footer');
	}

	public function article_nmims(){
		
		$data=keyword_desc();
		$data['pageid'] = 10;

		$this->load->view('web/header',$data);
		$this->load->view('web/nmims');
		$this->load->view('web/footer');
	}
}
?>