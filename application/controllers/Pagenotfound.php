<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pagenotfound extends CI_Controller {
	/**	
	 *
	 * @return void
	 */
	function __construct() {		
		parent::__construct();		
		$this->load->helper(array('api_helper','url','security'));
		$this->load->library(array('session','authorize'));
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	
	public function index() {		
		$this->load->view('web/header');
		$this->load->view('web/404');		
		$this->load->view('web/footer');
	}

}

?>