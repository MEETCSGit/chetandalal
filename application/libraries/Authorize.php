<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Autorize
*
* Author: Rajeshkumar Nadar
*		  nadar.rajeshnadar@gmail.com
*
*
* Description:  validate weather the user session is available. Also stores the audit log
*
* Requirements: PHP5 or above
*
*/

class Authorize{

	private $action=array(
			'1'=>'Inserted',
			'2'=>'Updated',
			'3'=>'Navigated',
			'4'=>'Mail',
			'5'=>'Excel Insert',
			'6'=>'Login',
			'7'=>'Authorization',
			'8'=>'Redirect'			
		);
	public function __construct(){
		$this->load->library('session');		
		$this->load->helper(array('cookie', 'language','url'));		
	}

	public function __get($var)
	{
		return get_instance()->$var;
	}

	public function checkAliveSession($session_for=1){ // 1 - for Web : 0 - for admin
		$user_type=$this->session->userdata('user_type');
		if($user_type==='web_user'){			
			return true;
		}else if($user_type==='admin'){
			return true;
		}
		return false;
	}

	public function isProfileComplete(){
		return $this->session->userdata('isProfileCompleted');
	}
	public function audit_log($audit_data){
		$this->load->model('audit_logm');
		$data=$this->get_useragent();
		$data['lms_id']=0;
		if($this->checkAliveSession()){
			$data['lms_id']=$this->session->userdata('user_id');
		}
		$data['page']=$audit_data['page'];
		$data['action']=$this->action[$audit_data['action']];
		$data['description']=$audit_data['description'];
		$this->audit_logm->save_audit_log($data);
	}
	private function get_useragent(){
		$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
		        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		        $agent = $this->agent->mobile();
		}
		else
		{
		        $agent = 'Unidentified User Agent';
		}
		$platform= $this->agent->platform();
		$agent_string=$this->agent->agent_string();	
		
		$data['user_agent']="Platform : ".$platform." | UserAgent : ".$agent." | UserAgent Details : ".$agent_string;
		$data['ip_address']=getIpAddress();
		return $data;
	}

}
?>