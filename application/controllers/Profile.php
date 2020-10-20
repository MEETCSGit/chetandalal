<?php
 /**
 * CDIMS - Controller 
 *
 * @category Controller
 * @package Controllers
 * @subpackage Home
 * @author Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version 1.0.0
 */

 defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Profile extends CI_Controller {

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

    private $alloweduserids = array(2); // for testing purpose

    private $docverifyflag = '';

    /**	
	 *
	 * @return void
	 */

	function __construct() {		
		parent::__construct();
		if(!$this->authorize->checkAliveSession()){
			redirect('home','refresh');
		}/*else if($this->session->userdata('web_admin')!=9){
			redirect('home','refresh');
		}*/
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
	public function index() {
		$audit_log=array('page'=>"Profile",'action'=>'3','description'=>'Navigated');
		$this->authorize->audit_log($audit_log);
		$data=keyword_desc();
		// $data['pageid'] = 6;
		/*print_r($this->session->userdata());
		exit;*/

		$data['countries'] = $this->profilem->get_countries();

		$userid = $this->session->userdata('user_id');
		$userdata = $this->getUserProfile($userid);
		/*print_r(json_encode($userdata));
		exit;*/

		$data['user_details']['id'] = $userdata['id'];
		$data['user_details']['firstname'] = $userdata['firstname'];
		$data['user_details']['lastname'] = $userdata['lastname'];
		
		$data['user_details']['middlename'] = isset($userdata['middlename'])?$userdata['middlename']:'';
		
		$data['user_details']['city'] = isset($userdata['city'])?$userdata['city']:'';
		$data['user_details']['state_name'] = isset($userdata['state_name'])?$userdata['state_name']:'';
		$data['user_details']['country_name'] = isset($userdata['country_name'])?$userdata['country_name']:'';
		$data['user_details']['pincode'] = isset($userdata['pincode'])?$userdata['pincode']:'';
		$data['user_details']['docpath'] = isset($userdata['docpath'])?$userdata['docpath']:'';
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
		
		$data['user_details']['docfilepaths'] = json_encode($this->docfilepaths);

		// print_r(json_encode($data));exit;


		$this->load->view('web/header',$data);
		// if(in_array($this->session->userdata('user_id'), $this->alloweduserids)){
			// $this->load->view('web/profile_renew');
		// }
		// else{
			$this->load->view('web/profile');
		// }
		$this->load->view('web/footer');		
	}

	public function getStates($country_id){
		$states = $this->profilem->get_states($country_id);
		print_r(json_encode($states['states']));
	}

	private function createFileUploadTemplate($docpath){
		if(!empty($docpath)){
			$jsobj = json_decode($docpath);
			foreach ($jsobj as $key => $value) {
				if(empty($jsobj->$key)){
					$arr_file[] = $this->createBlankFileTemplate($key);
				}else{
					$arr_file[] = $this->createUploadedFileTemplate($key,$value);
				}
			}
		}else{
			foreach ($this->inputfilenames as $key => $value) {
				$arr_file[] = $this->createBlankFileTemplate($key);
			}
		}
		return $arr_file;
	}

	/*private function createBlankFileTemplate($id){
		return "<div class='col-md-6'><label>".$this->inputfilenames[$id]."</label><input type='file' name=".$id." id=".$id." class='txt' value='choose'></div>";
	}

	private function createUploadedFileTemplate($id,$filename){
		return "<div class='col-md-6'><label>".$this->inputfilenames[$id]."</label>&nbsp;<i><span>(".$filename.")</span></i><input type='file' name=".$id." id=".$id." class='txt' value='choose'></div>";
	}*/

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

	public function editProfile($page='home'){
		
		/*print_r($this->input->post());
		exit;*/

		// print_r($_FILES);exit;

		/*if(!empty($_FILES['docpp']['name']))
			echo 'true';
		else
			echo 'false';
		exit;*/
		$this->form_validation->set_rules('salutation', 'Salutation ', 'trim|required');
		$this->form_validation->set_rules('firstname', 'First name ', "trim|required|regex_match[/^[a-zA-Z' ]+$/]",array('regex_match'=>'Only characters are allowed in First Name'));
		$this->form_validation->set_rules('middlename', 'Middle name ', "trim|required|regex_match[/^[a-zA-Z' ]+$/]",array('regex_match'=>'Only characters are allowed in Middle Name'));
		$this->form_validation->set_rules('lastname', 'Last name ', "trim|required|regex_match[/^[a-zA-Z' ]+$/]",array('regex_match'=>'Only characters are allowed in Last Name'));
		$this->form_validation->set_rules('city', 'City ', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender ', 'trim|required');
		$this->form_validation->set_rules('mobileno', 'Mobile no ', 'trim|required|regex_match[/^(\+\d{1,3}[- ]?)?\d{10}$/]',array('regex_match'=>'Invalid format for Mobile number'));
		// $this->form_validation->set_rules('dateofbirth', 'Date of birth', 'trim|required|regex_match[(0[1-9]|1[0-9]|2[0-9]|3(0|1))-(0[1-9]|1[0-2])-\d{4}]');
		$this->form_validation->set_rules('address', 'Address ', 'trim|required');
		$this->form_validation->set_rules('state', 'State ', 'trim|required');
		$this->form_validation->set_rules('country', 'Country ', 'trim|required');
		$this->form_validation->set_rules('pincode', 'Pin Code', 'trim|required|regex_match[/^[1-9][0-9]{5}$/]',array('regex_match'=>'Invalid format for PIN code'));
		$this->form_validation->set_rules('dateofbirth', 'Date of birth ', 'trim|required|callback_data_of_birth_validate');
		$this->form_validation->set_rules('university', 'University ', "trim|required|regex_match[/^[a-zA-Z'. ]+$/]",array('regex_match'=>'Only characters are allowed in University'));
		$this->form_validation->set_rules('universitycity', 'University city ', 'trim|required');
		$this->form_validation->set_rules('yearofpassing', 'Year of passing ', 'trim|required');
		$this->form_validation->set_rules('passinggrade', 'Percentage ', 'trim|greater_than[0]|less_than[100]');
		$this->form_validation->set_rules('sinceyears', 'Experience ', 'trim|greater_than[0]|min_length[1]|max_length[2]');
		$this->form_validation->set_rules('designation', 'Designation ', 'trim|max_length[30]');
		$this->form_validation->set_rules('workprofile', 'Work Profile ', 'trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$response['res_code']=1;      		
        	$response['message']=validation_errors();
        	$response['method']="RegErrorMsg";
        	print_r(json_encode($response));
	        exit;
		}

		/*if($this->profile_picture_validate($_FILES['docpp']) == FALSE){ // custom validation for profile picture : required
			$response['res_code']=1;      		
        	$response['message']='Please upload your profile picture';
        	$response['method']="RegErrorMsg";
        	print_r(json_encode($response));
	        exit;
		}*/

		$userdata['id'] = $this->session->userdata('user_id');

		$userdata['cf']['docpath'] = $this->moveDocsToAssets($this->uploadDocs($userdata['id'], $_FILES));

		$userdata['firstname'] = $this->input->post('firstname');
		$userdata['lastname'] = $this->input->post('lastname');
		$userdata['middlename'] = $this->input->post('middlename');
		$userdata['city'] = $this->input->post('city');
		// $userdata['hiddocpath'] = $this->input->post('hiddocpath');
		$userdata['cf']['address'] = $this->input->post('address');
		$userdata['cf']['state_name'] = $this->input->post('state');
		$userdata['cf']['country_name'] = $this->input->post('country');
		$userdata['cf']['pincode'] = $this->input->post('pincode');
		$userdata['cf']['phone1'] = $this->input->post('mobileno');
		$userdata['cf']['dateofbirth'] = $this->input->post('dateofbirth');
		$userdata['cf'][$this->fieldidarr[0]] = $this->input->post('organisation');
		$userdata['cf'][$this->fieldidarr[1]] = $this->input->post('gender');
		$userdata['cf'][$this->fieldidarr[2]] = $this->input->post('university');
		$userdata['cf'][$this->fieldidarr[3]] = $this->input->post('universitycity');
		$userdata['cf'][$this->fieldidarr[4]] = $this->input->post('yearofpassing');
		$userdata['cf'][$this->fieldidarr[5]] = $this->input->post('passinggrade');
		$userdata['cf'][$this->fieldidarr[6]] = $this->input->post('designation');
		$userdata['cf'][$this->fieldidarr[7]] = $this->input->post('workprofile');
		$userdata['cf'][$this->fieldidarr[8]] = $this->input->post('othereducation');
		$userdata['cf'][$this->fieldidarr[9]] = $this->input->post('sinceyears');
		$userdata['cf'][$this->fieldidarr[10]] = '0%';
		// $userdata['cf'][$this->fieldidarr[11]] = 'not verified';
		$userdata['cf'][$this->fieldidarr[11]] = $this->docverifyflag; 
		// for rejection branch pass a blank record : '' , 'not verified'(after user upload any document) , 'rejected' (if any of the doc is rejected)

		if(!empty($_FILES['docpp']['name'])){
			$userdata['cf'][$this->fieldidarr[12]] = $this->uploadImage($userdata['id'],$_FILES['docpp']);
		}else{
			$result = $this->profilem->get_profile_picture_path($userdata['id']);
			if(!empty($result))
		 		$userdata['cf'][$this->fieldidarr[12]] = $result[0]['profilepicture'];
		 	else
		 		$userdata['cf'][$this->fieldidarr[12]] = '';
		}
		$userdata['cf'][$this->fieldidarr[13]] = $this->generateCVCode($userdata['id']); // cvcode
		$userdata['cf'][$this->fieldidarr[14]] = ''; // serial number
		$userdata['cf'][$this->fieldidarr[15]] = 'not verified'; // certificate 
		$userdata['cf'][$this->fieldidarr[16]] = $this->input->post('salutation'); // salutation 

		/*print_r(json_encode($userdata));
		exit;*/


		$this->updateUserProfile($userdata,$page);
	}

	private function uploadImage($userid,$imagefile){
		/*echo 'uploadImage';
		print_r($imagefile);
		exit;*/
		if(!empty($imagefile['name'])){
			if($this->validateImage($imagefile)){
				$file = explode(".",$imagefile['name']);
				$newfilename = $userid.'_docpp.'.strtolower(end($file));

				$width = 120;
				$height = 120;


				$config_image_lib['image_library'] = 'gd2';
				$config_image_lib['source_image'] = $imagefile['tmp_name'];
				$config_image_lib['new_image'] = $this->imageuploadpath.$newfilename;
				$config_image_lib['create_thumb'] = FALSE;
				$config_image_lib['maintain_ratio'] = FALSE;
				$config_image_lib['width']         = $width;
				$config_image_lib['height']       = $height;

				$this->load->library('image_lib', $config_image_lib);

				$this->image_lib->resize();


				// move_uploaded_file($imagefile['tmp_name'], $this->imageuploadpath.$newfilename);
				return $newfilename;
			}else{
				$response['res_code']=1;
				$response['method']='RegErrorMsg';
				$response['message']='Trying to upload invalid document';
				print_r(json_encode($response));
				exit;
			}
		}else{
			return '';
		}
	}

	private function validateImage($image){
		if( $this->imageTypeCheck($image) && $this->imageSizeCheck($image))
			return true;
		else
			return false;
	}

	private function imageTypeCheck($image){
		$imagetype = $image['type'];
		switch ($imagetype) {
			case 'image/jpeg':
				return true;
				break;
			case 'image/png':
				return true;
				break;
			default:
				return false;
				break;
		}
	}

	private function imageSizeCheck($image){
		
		$imagesize = $image['size'];
		if($imagesize > $this->imagesizelimit)
			return false;
		else
			return true;
	}

	private function generateCVCode($userid){
		return str_pad($userid, 7, '0', STR_PAD_LEFT);
	}

	private function updateUserProfile($userdata,$page){

		$this->load->library('curl');

		$site = moodle_site();
		$token = '799ed071b21aef609de0fa42df0900a7';
		$domainname = $site['name']; 
		$functionname = 'core_user_update_users';
		$restformat = 'json';

		$user = new stdClass();
		$user->id = $userdata['id'];
		$user->firstname = $userdata['firstname'];
		$user->lastname = $userdata['lastname'];
		$user->middlename = $userdata['middlename'];
		$user->city= $userdata['city'];
		// $user->country= $userdata['country'];


		$users = array($user);
		$params = array('users'=>$users);

		$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname.'&moodlewsrestformat=json';
		$restres = $this->curl->simple_post($serverurl, $params, array(CURLOPT_BUFFERSIZE => 0));


		if($this->profilem->update_profile($this->fieldidarr,$userdata['cf'],$userdata['id'])){

			$this->session->set_userdata('isProfileCompleted','true');

			$this->setProfileComplete($userdata);
				
			$response['res_code']=1;
			$response['method']='RegSuccMsg';
			$response['path']=$page;
			$response['message']='Profile Updated Successfully.';
			print_r(json_encode($response));
		}


		$this->profilem->update_ci_register($userdata['id'],$userdata['firstname'],$userdata['lastname'],$userdata['cf']['phone1']);
		$this->session->set_userdata('firstname',$userdata['firstname']);
		$this->session->set_userdata('lastname',$userdata['lastname']);
		$this->session->set_userdata('phone',$userdata['cf']['phone1']);
	}

	/*Documents Upload*/

	private function uploadDocs($userid, $allfiles){

		/*print_r($_FILES);
		exit;*/

		unset($allfiles['docpp']); // unsetting the profile picture from $_FILES : it is already added above
		/*print_r($allfiles);
		exit;*/

		$jsondocpaths = array('docbc'=>'','docaddr'=>'','docgrad'=>'','docnamechng'=>'');

		$docnames = array('docbc'=>'Birth Certificate','docaddr'=>'Address Proof','docgrad'=>'Graduation certificate','docnamechng'=>'Name change certificate');

		$errordocs = array();

		$dbdocpaths = $this->profilem->get_doc_paths($userid);
		/*print_r($dbdocpaths);
		exit;*/

		if(!empty($dbdocpaths['docpath'])){
			$jsondocpaths=json_decode($dbdocpaths['docpath'],true);
			/*print_r($jsondocpaths);
			exit;*/
		}
		foreach ($allfiles as $key => $value) {
			if(!empty($allfiles[$key]['name'])){
				if($this->validateDocument($allfiles[$key])){
					$file = explode(".",$allfiles[$key]['name']);
					$newfilename = $userid.'_'.$key.'.'.strtolower(end($file));
					$jsondocpaths[$key] = array('name'=>$newfilename, 'tmp_name'=>$allfiles[$key]['tmp_name']);
				}else{
					$errordocs[] = $docnames[$key];
				}
			}
		}
		/*print_r($jsondocpaths);
		exit;*/

		if(empty($errordocs)){   // no errors found in validating the documents
			/*print_r($jsondocpaths);
			exit;*/
			return $jsondocpaths;
		}else{
			$response['res_code']=1;
			$response['method']='RegErrorMsg';
			$response['message']=implode(',', $errordocs).'<br/> Please upload files only in pdfs, jpg/jpeg and png formats and file size should be less than 2 MB';
			print_r(json_encode($response));
			exit;
		}
	}


	private function moveDocsToAssets($jsondocpaths){
		/*print_r($jsondocpaths);
		exit;*/
		$isFileUploaded = false;
		foreach ($jsondocpaths as $key => $value) {
			if(is_array($value)){
				if(!empty($jsondocpaths[$key])){
					$isFileUploaded = true;
					move_uploaded_file($value['tmp_name'], $this->docfilepaths[$key].$value['name']);
					$jsondocpaths[$key]=$value['name'];
				}
			}
		}
		
		if($isFileUploaded){
			$this->docverifyflag = 'not verified';
		}

		return json_encode($jsondocpaths);
	}

	private function validateDocument($file){
		if( $this->fileTypeCheck($file) && $this->fileSizeCheck($file))
			return true;
		else
			return false;
	}

	private function fileTypeCheck($file){
		$filetype = $file['type'];
		switch ($filetype) {
			case 'application/pdf':
				return true;
				break;
			case 'image/jpeg':
				return true;
				break;
			case 'image/png':
				return true;
				break;
			default:
				return false;
				break;
		}
	}

	private function fileSizeCheck($file){
		
		$filesize = $file['size'];
		if($filesize > $this->filesizelimit)
			return false;
		else
			return true;
	}

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
		unset($userprofile['customfields']['serialnumber']);
		unset($userprofile['customfields']['certificateverified']);

		// print_r(json_encode($userprofile));exit;

		// $totalnooffields = 23;
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
						// unset($jsobj['docaddr']);
						// unset($jsobj['docbc']);
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
		// exit;
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
		
		// $totalnooffields = 16;  // including profile picture
		$totalnooffields = 18;  // including profile picture
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
						if(!empty($docarr['docbc']))
							++$filledfields;
						if(!empty($docarr['docaddr']))
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

	
	/*Custom Validation*/
	public function data_of_birth_validate($dob){
		$dobdate = date('Y-m-d',strtotime($dob));
		$validatedate = date('Y-m-d',strtotime('-18 year',time()));

		if($dobdate > $validatedate){
			$this->form_validation->set_message('data_of_birth_validate', '{field} : Age must be above 18 years');
			return FALSE;
		}else{
			return TRUE;
		}

		// echo date('Y-m-d');
	}

	private function profile_picture_validate($filepicture){
		if(!empty($filepicture['name']))
			return TRUE;
		else
			return FALSE;
	}	
	public function validChr($str) {
	    if(!preg_match('/^[A-Za-z0-9\-\'.]+$/',$str)){
	    	$this->form_validation->set_message('validChr', '{field} : Invalid character provided.');
	    	return false;
	    }
	    return true;
	}

	/*public function isProfileCompleted($userid){
		$userdata = $this->profilem->get_profile_completion($userid);
		$flag = "true";
		foreach ($userdata[0] as $key=>$value) {
			if(empty($userdata[0][$key])){
				$flag = "false";
				break;
			}
		}
		$this->session->set_userdata('isProfileCompleted',$flag);
	}*/
}

?>