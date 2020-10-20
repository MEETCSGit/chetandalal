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

class Courses extends CI_Controller {

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','form_validation'));
		error_reporting(E_ALL);
		ini_set('display_errors', 1);	
	}
	/**
	 * home page
	 *
	 * @return void
	 */
	public function index() {		
		$audit_log=array('page'=>"Courses",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		$userid = $this->session->userdata('user_id')?$this->session->userdata('user_id'):0;
		$data['course']=$this->get_users_courses($userid);
		$course_ids=array();
		if(count(@$data['course'])>0){
			foreach (@$data['course'] as $value) {
				@$course_ids[]=$value['id'];
			}
		}
		$data['course']=$course_ids?$course_ids:array();
		$data['pageid'] = 4;			
		$this->load->view('web/header',$data);
		$this->load->view('web/courses');
		$this->load->view('web/footer');		
	}
	public function c1() {
		$data=keyword_desc();				
		$this->load->view('web/header',$data);
		$this->load->view('web/courses');
		$this->load->view('web/footer');		
	}
	public function course_details($id=0){
		if($id==0){
			redirect('courses','refresh');
		}
		$data=keyword_desc();
		$data['pageid'] = 4;		
		$this->load->view('web/header',$data);
		if($id==2){			
			$audit_log=array('page'=>"Courses",'action'=>'3','description'=>'Navigated to online course');	
			$this->authorize->audit_log($audit_log);  
			$this->load->view('web/course_online_trailers');
		}
		else{			
			$audit_log=array('page'=>"Courses",'action'=>'3','description'=>'Navigated to classrom course');
			$this->authorize->audit_log($audit_log);  
			$this->load->view('web/course_trailers');			
		}
		$this->load->view('web/footer');
	}
	public function free_course_webinar_enrolement(){
		if(!$this->authorize->checkAliveSession()){
			$response['code']="0";
			$response['message']="Please login to access the course.";
			$respone= json_encode($response);		
			header("location:".base_url()."login/?message=".base64_encode($respone));
			exit;			
		}
		$userid = $this->session->userdata('user_id');
		$roleid = 5;  // roleid : 5 student
		$courseid = 9; // Webinar, Investigation course id
		$course=$this->get_users_courses($userid);
		if($course!=0){
			$this->enrolUserRest($roleid, $userid, $courseid);
			redirect(base_url('lms/course/view.php?id=9'),'refresh');
		}
		else{
			redirect(base_url('lms/course/view.php?id=9'),'refresh');
		}
	}
	public function free_course_excel_enrolement(){
		if(!$this->authorize->checkAliveSession()){
			$response['code']="0";
			$response['message']="Please login to access the course.";
			$respone= json_encode($response);		
			header("location:".base_url()."login/?message=".base64_encode($respone));
			exit;			
		}
		$userid = $this->session->userdata('user_id');
		$roleid = 5;  // roleid : 5 student
		$courseid = 8; // Excel, Investigation course id
		$course=$this->get_users_courses($userid);
		if($course!=0){
			$this->enrolUserRest($roleid, $userid, $courseid);
			redirect(base_url('lms/course/view.php?id=8'),'refresh');
		}
		else{
			redirect(base_url('lms/course/view.php?id=8'),'refresh');
		}

	}
	public function start_a_course(){
		$this->load->model('coursem');
		$this->form_validation->set_rules('city', 'City Name ', 'trim|required|alpha_numeric_spaces|min_length[2]');
		$this->form_validation->set_rules('week', 'Week ', 'trim|required');
		$this->form_validation->set_rules('month', 'Month ', 'trim|required');		
		$this->form_validation->set_rules('message', 'Message ', 'trim|required|min_length[10]|max_length[500]');		
		if ($this->form_validation->run() == FALSE ){ 
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";         	       	
        	print_r(json_encode($response));
	        exit;        	
		}		
		
		$data['created_by']=$this->session->userdata('user_id');
		$data['city']=$this->input->post('city');
		$data['week']=$this->input->post('week');
		$data['month']=$this->input->post('month');
		$data['message']=$this->input->post('message');
		
		$this->coursem->save_course_request($data);
		$data['firstname']=ucfirst($this->session->userdata('firstname'));
		$data['email']=$this->session->userdata('email');
		$this->send_request_mail($data);
		$response['res_code']=1;      		
    	$response['message']="Course request raised successfully.";
    	$response['method']="RegSuccMsg";      	
		$audit_log=array('page'=>"Courses",'action'=>'1','description'=>'Requested new course to be started');
		$this->authorize->audit_log($audit_log);       	       	
    	print_r(json_encode($response));
	    exit;
	}
	private function send_request_mail($data){
		$config['priority'] = 1;
		$this->load->library('email');	
		$this->email->initialize($config);	
		$this->email->from('support@chetandalal.com', 'chetandalal.com');
		$this->email->to($data['email']);		
		$this->email->cc('training@chetandalal.com');
		$this->email->subject('Chetandalal - Training Request  ');
		$template_email=$this->load->view('web/Course_request_mail_template',$data,true);
		$this->email->message($template_email);		
		if($this->email->send()){			
			$audit_log=array('page'=>"Courses",'action'=>'4','description'=>'Mail sent for new course.');
			$this->authorize->audit_log($audit_log);
		}
			
	}
	
	private function get_users_courses($userid){
		$this->load->library('curl');		
		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'core_enrol_get_users_courses';
		$restformat = 'json';		
		$params = array('userid' => $userid);
		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
		$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_BUFFERSIZE => 0));
		$restres=json_decode($restres,true);
		//print_r($restres);
		if(isset($restres['exception'])){
			return 0;
		}else{
			return $restres;
		}		 
	} 
	private function enrolUserRest($roleid, $userid, $courseid){
		$this->load->library('curl');
		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'enrol_manual_enrol_users';
		$restformat = 'json';
		$user = new stdClass();
		$user->roleid = $roleid;
		$user->userid = $userid;
		$user->courseid = $courseid;
		$user->timestart = time();
		$user->timeend = time() + (30 * 24 * 60 * 60);
		$enrol = array($user);
		$params = array('enrolments' => $enrol);
		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
		$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_BUFFERSIZE => 0));
		if(isset($restres->exception)){
			/*$response['res_code']=0;
			$response['method']='loginErrorMsg';
			$response['message']='Oops! Something went wrong,Please try again...';*/
			return 1;
			//exit;
		}else{
			/*$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['message']='Enrolled successfully to the online course.';*/
			return 0;
			//exit;
		}
	}

}
?>