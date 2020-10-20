<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 /**
 * CDIMS Auth Controller - Controller
 *
 * @category Controller
 * @package Controllers
 * @subpackage Auth
 * @author Rajesh Nadar <nadar.rajeshnadar@gmail.com>
 * @copyright 2018 meetcs.com
 * @version 1.0.0
 */

class Lauth extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->library(array('form_validation','authorize'));
		$this->load->helper(array('url','language','api_helper'));
		$this->load->model('lauthm');
		
	}
	public function index(){
		redirect('home','refresh');		
	}
	/**
	*
	* Authentication for admin login .
	*
	*/
	public function login(){
		$data=$this->lauthm->login();
		$data['num_rows']=$this->lauthm->login(1);		
		if($data['num_rows'] > 1 || $data['num_rows'] === 0 ){				
			$this->session->set_tempdata('error_message', 'Invalid login.', 10);
			redirect('lauth','refresh');
		}elseif($data['num_rows']===1){	
			if($data['data'][0]['username']===$this->input->post('username') && $data['data'][0]['password']===$this->input->post('password')){
				$this->session->set_userdata('adm_username',$this->input->post('username'));
				$this->session->set_userdata('adm_user',1);
				$this->session->set_userdata('user_type','admin');	
				$this->index();
			}
			$this->index();
		}		
	}// not used	
	public function logged_in(){
		$adm_user=$this->session->userdata('adm_username');
		$adm_user=$this->session->userdata('adm_user');
		$user_id=$this->session->userdata('user_id');
		$is_web_user=$this->session->userdata('is_web_user');
		if(isset($adm_user) && isset($adm_user) && $adm_user!==null ){
			return TRUE;
		}else if(isset($user_id) && isset($is_web_user) && $is_web_user!==null && $user_id!==null){
			return TRUE;
		}
		return false;
	}//not used
	/**
	*
	* Authentication for webuser.
	* This method is not used now due to change in requirement. 
	*/
	public function userAuth(){
		$this->load->library('curl');	        
		$post = array(
			'username'=>$this->input->post('username'),
			'password'=>$this->input->post('password'),
			'action'=>'Authenticate'
			);		
		$response = $this->curl->simple_post(moodle_site1().'/custom_login/custom_login.php?action=Authenticate', $post, array(CURLOPT_BUFFERSIZE => 0));
		$response=json_decode($response,true);
		if(!array_key_exists('longToken', $response)){
			$response="";
			$response['res_code']=1;
			$response['method']='loginErrorMsg';
			$response['message']='Invalid login.';
			print_r(json_encode($response));
			exit;
		}		
		list($userdata,$token, $hmac) = explode(':', $response['longToken'], 3);		
		if ($hmac != hash_hmac('md5', $userdata.':'.$token, 'r@jeshN@D@r')) {
			$response="";
			$response['res_code']=1;
			$response['method']='loginErrorMsg';
			$response['message']='Invalid login.';			
			print_r(json_encode($response));
			exit;
		}else{
			$userdata=json_decode(base64_decode(urldecode(base64_decode($userdata))),true);
			$phone=$this->lauthm->getuserdetails($userdata['id']);
			$userdata['phone1']=$phone[0]['mobile_no'];
			$this->session->set_userdata('userDetails',$userdata);
			$this->session->set_userdata('user_type',"web_user");
			$this->session->set_userdata('firstname',$userdata['firstname']);
			$this->session->set_userdata('lastname',$userdata['lastname']);
			$this->session->set_userdata('phone',$userdata['phone1']);
			$this->session->set_userdata('user_id',$userdata['id']);
			$this->session->set_userdata('email',$userdata['username']);
			
			$response="";
			$response['res_code']=1;
			$response['method']='reload';
			$response['redirect_to']=base_url($this->input->get('redirect_to', TRUE));
			$response['message']='Success.';			
			print_r(json_encode($response));
			exit;
		}
	} //
	public function set_ci_session($id){
		/*if($id!=2){
			$this->downtime();
			return;
		}*/
			if($this->authorize->checkAliveSession()){
				redirect('home/index','refresh');
			}
			$userdata=$this->lauthm->getuserdetails($id);
			$roledata=$this->lauthm->getUserRole($id);
			//print_r($roledata[0]['roleid']);
			$roledata=explode(',', $roledata[0]['roleid']);	
			$this->session->set_userdata('web_admin',"0");

			foreach ($roledata as  $value) {
				if($value==9){
					$this->session->set_userdata('web_admin',"9");
					//print_r($this->session->userdata('web_admin'));
				}
			}	

			//print_r($userdata);
			/*if(is_array($userdata)){
				if(!isset($userdata[0])){
					redirect(moodle_site1()."/login/logout.php?sesskey=".$this->input->get('sesskey',true),'refresh');										
				}
			}	
			if(!isset($userdata)){
				redirect(moodle_site1()."/login/logout.php?sesskey=".$this->input->get('sesskey',true),'refresh');
			}*/			
			$userdata=$userdata[0];

			//print_r($this->input->get("sesskey",true));
			//$this->session->set_userdata('userDetails',$userdata);
			$this->session->set_userdata('user_type',"web_user");
			$this->session->set_userdata('firstname',$userdata['first_name']);
			$this->session->set_userdata('lastname',$userdata['last_name']);
			$this->session->set_userdata('phone',$userdata['mobile_no']);
			$this->session->set_userdata('user_id',$id);
			$this->session->set_userdata('sesskey',$this->input->get("sesskey",true));
			$this->session->set_userdata('email',$userdata['email']);

			$this->isProfileCompleted($id);

			$audit_log=array('page'=>"Authorization",'action'=>'7','description'=>'User Logged into the system');
			$this->authorize->audit_log($audit_log);

			// print_r($this->authorize->isProfileComplete());
			// exit;
			if($this->authorize->isProfileComplete() == "false"){
				redirect(base_url('profile?complete=false'),'refresh');
			}

			//$lurl==''?base_url():$lurl;
			$url=$this->input->get('redirect_to', TRUE);
			$url=rtrim($url,"=");
			//print_r($url);
			redirect($url,'refresh');
			//print_r($this->session->userdata());
			//exit;
	}
		
	public function logout($is_web=0){
		$audit_log=array('page'=>"Authorization",'action'=>'7','description'=>'User Logged out of the system');
		$this->authorize->audit_log($audit_log);
		$sesskey=$this->session->userdata('sesskey');
		$this->session->sess_destroy();		
		redirect(base_url('lms/login/logout.php?sesskey='.$sesskey),'refresh');
	}
	public function log_out_from_moodle(){
		$audit_log=array('page'=>"Authorization",'action'=>'7','description'=>'User Logged out of the system');
		$this->authorize->audit_log($audit_log);
		$this->session->sess_destroy();		
		redirect('home','refresh');
	}
	public function downtime(){

		$this->load->view('web/header');		
		$this->load->view('web/downtime');
		$this->load->view('web/footer');
	}
	private function isProfileCompleted($userid){
		$userdata = $this->lauthm->get_profile_completion($userid);
		$flag = "true";
		foreach ($userdata[0] as $key=>$value) {
			if(empty($value)){
				$flag = "false";
				break;
			}
		}
		$this->session->set_userdata('isProfileCompleted',$flag);
	}		
}

?>