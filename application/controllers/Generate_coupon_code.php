<?php
/**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Coupon Code
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Generate_coupon_code extends CI_Controller {
    /**	
	 *
	 * @return void
	 */
	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper','cookie'));
		$this->load->library(array('session','form_validation'));	
		if(!$this->authorize->checkAliveSession()){
			redirect('home','refresh');
		}else if($this->session->userdata('web_admin')!=9){
			redirect('home','refresh');
		}	
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {
		$audit_log=array('page'=>"Generate_coupon_code",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$data['pageid'] = 0;
		$this->load->model('couponcodem');
		$data['coupon_data']=$this->couponcodem->get_coupon_data();				
		$this->load->view('web/header',$data);
		$this->load->view('web/coupon_generate_code');
		$this->load->view('web/footer');		
	}
	public function store_coupon_code(){
		$audit_log=array('page'=>"Generate_coupon_code",'action'=>'1','description'=>'Generated new coupon code.'.date('d-m-Y H:i:s'));
		$this->authorize->audit_log($audit_log);
		$this->load->model('couponcodem');

		$this->form_validation->set_rules('domian', 'Domian ', 'trim|valid_url');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code ', 'trim|required|alpha_numeric|min_length[5]|max_length[8]|is_unique[mdl_cdims_coupon_code.coupon_code]', array('is_unique' => 'Coupon code already exist.'));
		$this->form_validation->set_rules('amount', 'Amount ', 'trim|required|numeric|min_length[2]');
		$this->form_validation->set_rules('coupon_for', 'Coupon for  ', 'trim|required');
		$this->form_validation->set_rules('valid_up_to', 'Valid Upto date ', 'trim|required|callback_checkDateFormat',array('checkDateFormat'=>'Invalid date selected.'));
		$this->form_validation->set_rules('multiple_use', 'Multiple Use ', 'trim|in_list[S,M]');
		
		
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";         	       	
        	print_r(json_encode($response));
	        exit;        	
		}
		$multiple_use=trim($this->input->post('multiple_use'));

		if($multiple_use=='S'){
			$multiple_use=0;
		}elseif($multiple_use=='M'){
			$multiple_use=1;			
		}
		/*print_r($multiple_use);
		exit;*/
		$date=explode('/',$this->input->post('valid_up_to'));
		$date=$date[2]."-".$date[1]."-".$date[0];
		$data['domian'] = $this->input->post('domian');
		$data['coupon_code'] = $this->input->post('coupon_code');
		$data['amount'] = $this->input->post('amount');
		$data['coupon_for'] = $this->input->post('coupon_for');
		$data['multiple_use'] = $multiple_use;
		$data['created_by'] = $this->session->userdata('user_id');
		$data['validupto'] = $date;

		
		$this->couponcodem->save_coupon_data($data);
		$response['res_code']=1;
		$response['method']='RegSuccMsg';
		$response['path']=base_url('generate-coupon-code');				
		$response['message']='Coupon code generated.';	      	       	
    	print_r(json_encode($response));
        exit;   
	}
	function checkDateFormat($date) {		
		$date=explode('/',$date);
		if(sizeof($date)==1){			
			return false;
		}		
		$date=$date[2]."-".$date[1]."-".$date[0];		
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
	    {
	        return true;
	    }else{
	        return false;
	    }
	} 

}
?>