<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Careers extends CI_Controller {
	
		public function __construct(){
			parent::__construct();
			$this->load->helper(array('url','html','api_helper'));
		}

		public function index(){
			$data['pageid'] = 9;
			$this->load->view('web/header', $data);
			$this->load->view('web/careers');
			$this->load->view('web/footer');
		}
	
	}
	
	/* End of file Careers.php */
	/* Location: .//C/Users/Ela/AppData/Local/Temp/fz3temp-2/Careers.php */