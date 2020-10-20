<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Rajesh Nadar <rajesh.nadar@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class User_history extends CI_Controller {

	/*
	 *@description : This are custom fields added in moodle to capture extra user info.
		table name mdl_user_info_fields
		Primary Key - Custom fields
		3-organisation
		11-gender
		14-university
		15-university city
		16-yearofpassing
		17-passinggrade
		21-designation
		22-workprofile
		23-othereducation
		24-sinceyears
		25-profileuploaded
		26-documentverified
		27-profilepicture
		28-cvcode
		29-serialnumber
		30-certificateverified
		32-salutation
	*/

    private $fieldidarr = array(3,11,14,15,16,17,21,22,23,24,25,26,27,28,29,30,32);	// Do not change the order
    private $filesizelimit = 2097152; // 2 MB : Maximum upload document size 
    private $imagesizelimit = 2097152; // 2 MB : Maximum upload image size 
    private $imageuploadpath = 'assets/img/profile/';

    private $inputfilenames = array('docbc'=>'Birth Certificate','docaddr'=>'Address Proof','docgrad'=>'Graduation Certificate','docnamechng'=>'Name change certificate','docpp'=>'Profile Picture (only .jpg)');


    private $docfilepaths = array(
								'docbc'=>'assets/docs/birthcertificate/',
								'docaddr'=>'assets/docs/addressprf/',
								'docgrad'=>'assets/docs/gradcert/',
								'docnamechng'=>'assets/docs/namechange/'
							);

    private $alloweduserids = array(2,47); // for testing purpose

    private $docverifyflag = '';

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		$this->load->database();
		$this->load->helper(array('url','html','api_helper'));
		$this->load->library(array('session','form_validation'));	
		$this->load->model("profilem");			
	}
	/**
	 * profile page
	 *
	 * @return void
	 */
	public function index($userid="2") {
		$audit_log=array('page'=>"USER HISTORY",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		// $data['pageid'] = 6;
		/*print_r($this->session->userdata());
		exit;*/
		if(!is_numeric($userid)){
			redirect('registration-report','refresh');
		}
		if($userid==""){
			redirect('registration-report','refresh');
		}

		
		//$userid = $this->session->userdata('user_id');
		$userdata = $this->getUserProfile($userid);
		/*print_r(json_encode($userdata));
		exit;*/

		$countries = $this->profilem->get_countries();
		
		foreach ($countries['country'] as $key => $value) {
			if($value['id']==@$userdata['country_name']){
				$countries=$value['name'];
				break;
			}
		}

		$states = $this->profilem->get_states(isset($userdata['country_name'])?$userdata['country_name']:'');
		foreach ($states['states'] as $key => $value) {
			if($value['id']==@$userdata['state_name']){
				$states=$value['name'];
				break;
			}
		}

		$data['user_details']['id'] = $userdata['id'];
		$data['user_details']['firstname'] = $userdata['firstname'];
		$data['user_details']['lastname'] = $userdata['lastname'];
		$data['user_details']['email'] = $userdata['email'];
		
		$data['user_details']['middlename'] = isset($userdata['middlename'])?$userdata['middlename']:'';
		
		$data['user_details']['city'] = isset($userdata['city'])?$userdata['city']:'';
		$data['user_details']['state_name'] = $states;
		$data['user_details']['country_name'] = $countries;
		$data['user_details']['pincode'] = isset($userdata['pincode'])?$userdata['pincode']:'';
		$data['user_details']['docpath'] = json_decode(isset($userdata['docpath'])?$userdata['docpath']:'',true);
		$data['user_details']['phone1'] = isset($userdata['phone1'])?$userdata['phone1']:'';
		$data['user_details']['address'] = isset($userdata['address'])?$userdata['address']:'';
		$data['user_details']['dateofbirth'] = isset($userdata['dob'])?$userdata['dob']:'';
		$data['user_details']['profileimageurl'] = isset($userdata['profileimageurl'])?$userdata['profileimageurl']:'';

		$data['user_details']['customfields'] = array(
														'organisation'=>'',
														'gender'=>'',
														'university'=>'',
														'universitycity'=>'',
														'yearofpassing'=>'',
														'passinggrade'=>'',
														'sinceyears'=>'',
														'designation'=>'',
														'workprofile'=>'',
														'othereducation'=>'',
														'salutation'=>'',
														'profilepicture'=>''
													);
		
		if(isset($userdata['customfields'])){
			foreach ($userdata['customfields'] as $field) {
				$data['user_details']['customfields'][$field['shortname']] = $field['value'];
			}
		}

		/*print_r(json_encode($data['user_details']['customfields']));
		exit;*/

		$data['user_details']['customfields']['othereducation'] = strip_tags($data['user_details']['customfields']['othereducation']); //removing html tags

		$data['user_details']['profilepercent']=$this->getProfilePercent($data['user_details']);

		// $data['user_details']['filefields'] = $this->createFileUploadTemplate($data['user_details']['docpath']);

		$profilepicpath = base_url().'assets/img/profile/';

		if(!empty($data['user_details']['customfields']['profilepicture']))
			$data['user_details']['profilepicture'] = $profilepicpath.$data['user_details']['customfields']['profilepicture'];
		else
			$data['user_details']['profilepicture'] = $profilepicpath.'defaultuser.png';
		
		$data['user_details']['docfilepaths'] = $this->docfilepaths;
		$data['user_details']['get_quiz']=$this->profilem->get_quiz($userid);
		$data['user_details']['get_rating']=$this->profilem->get_rating($userid);


		/*print_r(json_encode($data));
		exit;*/
		/*echo "<pre>";
		print_r($data);
		exit();*/

		$this->load->view('web/header',$data);	
		$this->load->view('web/user_history');		
		$this->load->view('web/footer');	
	}

	public function getStates($country_id){
		$states = $this->profilem->get_states($country_id);
		print_r(json_encode($states['states']));
	}

	


	private function getUserProfile($userid){
		
		$this->load->library('curl');

		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'core_user_get_users_by_field';
		$restformat = 'json';
		/*$user = new stdClass();
		$user->field = 'id';
		$user->values[0] = $userid;*/

		$params = array('field' => 'id', 'values'=>array($userid));
		// print_r($params);
		
		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat='.$restformat;
		$restres = $this->curl->simple_post($serverurl, $params);
		$restres=json_decode($restres,true);
		/*print_r(json_encode($restres));
		exit;*/
		// print_r($serverurl);

		$resultset=$this->profilem->get_profile($userid);
		$restres[0]['middlename']=$resultset['middlename'];
		if(!empty($resultset['dob']))
				$restres[0]['dob']=date('Y-m-d',strtotime($resultset['dob']));
		/*print_r($restres);
		exit;*/
		$restres[0]['state_name']=$resultset['state_name'];
		$restres[0]['country_name']=$resultset['country_name'];
		$restres[0]['pincode']=$resultset['pincode'];
		$restres[0]['docpath']=$resultset['docpath'];
		return $restres[0];
	}

	




	private function generateCVCode($userid){
		return str_pad($userid, 7, '0', STR_PAD_LEFT);
	}

	
	/*Documents Upload*/






	/*Percent Profile*/

	/*
	 * This function is to get the percentage of profile completion to show on the Edit profile page.
	 */

	private function getProfilePercent($userprofile){
		
		unset($userprofile['id']);
		unset($userprofile['profileimageurl']);
		unset($userprofile['customfields']['profilecompleted']);
		unset($userprofile['customfields']['documentverified']);
		unset($userprofile['customfields']['cvcode']);
		unset($userprofile['customfields']['certificateverified']);

		/*print_r(json_encode($userprofile));
		exit;*/

		$totalnooffields = 25;
		$filledfields = 0;

		foreach ($userprofile as $key => $value) {
			if(is_array($value)){
				foreach ($value as $key => $value) {
					if(!empty($userprofile['customfields'][$key]))
						++$filledfields;
				}
			}else{
				if($key === 'docpath'){
					if(!empty($userprofile[$key])){
						$jsobj = json_decode($userprofile[$key],TRUE);					
						unset($jsobj['docnamechng']);
						foreach ($jsobj as $doc) {
							if(!empty($doc))
								++$filledfields;
						}
					}
				}else{
					if(!empty($userprofile[$key]))
						++$filledfields;
				}
			}
		}

		/*echo $filledfields .'/'. $totalnooffields;
		exit;*/
		$percent = intval(($filledfields / $totalnooffields)*100);

		return $percent;
	}

	/*
	 * This function is to update the profile complete flag in custom field
	 */

	private function setProfileComplete($userdata){

		$userid = $userdata['id'];
		unset($userdata['id']);
		unset($userdata['middlename']);
		unset($userdata['hiddocpath']);
		unset($userdata['cf']["3"]);
		unset($userdata['cf']["17"]);
		unset($userdata['cf']["21"]);
		unset($userdata['cf']["22"]);
		unset($userdata['cf']["23"]);
		unset($userdata['cf']["24"]);
		unset($userdata['cf']["25"]);
		unset($userdata['cf']["26"]);
		unset($userdata['cf']["29"]);
		unset($userdata['cf']["28"]);
		unset($userdata['cf']["30"]);

		/*print_r(json_encode($userdata));
		exit;*/
		
		$totalnooffields = 16;  // including profile picture
		$filledfields = 0;

		foreach ($userdata as $key => $value) {
			if(is_array($value)){
				foreach ($value as $key => $value) {
					if($key !== 'docpath'){
						if(!empty($userdata['cf'][$key]))
							++$filledfields;
					}else{
						$docarr = json_decode($userdata['cf']['docpath'], TRUE);
						if(!empty($docarr['docgrad']))
							++$filledfields;
					}
				}
			}else{
				if(!empty($userdata[$key]))
					++$filledfields;
			}
		}
		
		/*echo $filledfields." ".$totalnooffields;
		exit;*/

		if($totalnooffields === $filledfields){
			$this->profilem->set_profile_completed($userid);
		}
	}

}

?>